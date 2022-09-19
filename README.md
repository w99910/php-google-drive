# Easy-To-Use PHP Library For Google Drive

- ## Installation
  ```bash
  $ composer require zlt/php-google-drive
  ```

- ## Setup
  ```php
  $clientId = 'clientId';
  $clientSecret = 'clientSecret';
  $refreshToken = 'refreshToken';
  $config = new GoogleDriveConfig(clientId: $clientId, clientSecret: $clientSecret, refreshToken: $refreshToken);
  $service = new GoogleDriveService($config);
  ```

- ## Usage

- ### Creating Content
  Use `put' method which accepts three parameters:
    - `content` - contents to be stored
    - `fileName` - filename of content to be stored
    - `dir` - If not specified, file will be stored under root. Otherwise, file will be stored under specifed dir.
  ```php
  $service->put('This is example text', 'example.txt');
  
  $service->put('This is text will be stored under specified dir','example.txt','12sdf_sdfjopwoeriupsdf')
  ```

- ### Creating Dir
  Use `makeDir` which accepts two parameters:
    - `folderName` - folderName
    - `dir` - If not specified, folder will be created under root. Otherwise, folder will be created under specifed dir.
  ```php
  $service->makeDir('New Folder');
    
  $service->makeDir('New Folder Under Specified Dir','12sdf_sdfjopwoeriupsdf')
  ```

- ### List Contents
  Use `listContents` method which accepts two parameters: `path` which is either pathId, fileName, folderName
  ,and `recursive` which decide to show children contents.
  ```php
    // List files inside root dir.
    $service->listContents()
  
    // List files inside 'shared with me' folder.
    $service->listContents(Zlt\PhpGoogleDrive\GoogleDriveService::SharedWithMe);
  ```

- ### List Directories
  Use `directories` method which accepts two parameters: `path` which is either pathId, fileName, folderName
  ```php
    // List files inside root dir.
    $service->directories()
  
    // List files inside 'shared with me' folder.
    $service->directories(Zlt\PhpGoogleDrive\GoogleDriveService::SharedWithMe);
  ```

- ### List Files
  Use `files` method which accepts two parameters: `path` which is either pathId, fileName, folderName
  ```php
    // List files inside root dir.
    $service->files()
  
    // List files inside 'shared with me' folder.
    $service->files(Zlt\PhpGoogleDrive\GoogleDriveService::SharedWithMe);
  ```

- ### Delete File or Folder
  Delete file
    ```php
    $service->delete('fileId')
    ```
