<?php

namespace Zlt\PhpGoogleDrive;

use Exception;
use Google\Service\Drive;

class GoogleDriveService
{
    protected Drive $service;

    const SharedWithMe = 'sharedWithMe';

    private array $extensionToMime = [
        'docx' => 'application/vnd.google-apps.document',
        'csv' => 'application/vnd.google-apps.spreadsheet',
        'xlsx' => 'application/vnd.google-apps.spreadsheet',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    public function __construct(GoogleDriveConfig $config)
    {
        $client = new \Google\Client();
        $client->setScopes(Drive::DRIVE);
        $client->setClientId($config->clientId);
        $client->setClientSecret($config->clientSecret);
//        $client->set
        $client->refreshToken($config->refreshToken);
        $client->setAccessType('online');
        $this->service = new Drive($client);
    }

    public function listContents(string $path = '/', bool $recursive = false): array
    {
        $files = $this->service->files->listFiles([
            'q' => $this->resolveQuery($path),
            'spaces' => 'drive',
        ]);
        $out = [];
        foreach ($files->getFiles() as $file) {
            $temp = [
                'id' => $file->id,
                'mimeType' => $file->mimeType,
                'name' => $file->name,
                'fileExtension' => $file->fileExtension,
                'createdTime' => $file->createdTime,
            ];
            if ($recursive) {
                $children = $this->listContents($file->id, $recursive);
                if (!empty($children)) {
                    $temp['children'] = $children;
                }
            }
            $out[] = $temp;
        }
        return $out;
    }

    private function resolveQuery($path)
    {
        switch ($path) {
            case static::SharedWithMe:
                return $path;
            default:
                return !$path || $path === '/' ? null : "'$path' in parents";
        }
    }

    public function put($content, $fileName, $dir = null): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = pathinfo($fileName, PATHINFO_BASENAME);
        $mimeType = 'application/vnd.google-apps.file';
        if (in_array($extension, $this->extensionToMime)) {
            $mimeType = $this->extensionToMime[$extension];
        }
        $fileMetadata = new Drive\DriveFile(array(
            'name' => $fileName,
            'parents' => $dir ? array($dir) : null,
            'mimeType' => $mimeType));
        return $this->service->files->create($fileMetadata, array(
            'data' => $content,
            'uploadType' => 'multipart',
            'fields' => 'id'))->id;
    }

    public function makeDir($folderName, $dir = null): string
    {
        $fileMetadata = new Drive\DriveFile(array(
            'name' => $folderName,
            'parents' => $dir ? array($dir) : null,
            'mimeType' => 'application/vnd.google-apps.folder'));
        return $this->service->files->create($fileMetadata, array(
            'fields' => 'id'))->id;
    }

    /**
     * @throws Exception
     */
    public function directories(string $path = '/'): array
    {
        if (!$path) {
            throw new Exception('Invalid path');
        }
        $items = $this->listContents($path);
        $directories = [];
        foreach ($items as $file) {
            if ($file['mimeType'] === 'application/vnd.google-apps.folder') {
                $directories[] = $file;
            }
        }
        return $directories;
    }

    /**
     * @throws Exception
     */
    public function files(string $path = '/'): array
    {
        if (!$path) {
            throw new Exception('Invalid path');
        }
        $items = $this->listContents($path);
        $files = [];
        foreach ($items as $file) {
            if ($file['mimeType'] !== 'application/vnd.google-apps.folder') {
                $files[] = $file;
            }
        }
        return $files;
    }

    public function delete(string $fileId): bool
    {
        $this->service->files->delete($fileId);
        return true;
    }
}
