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

> If you don't know how to find the credentials i.e, clientId, clientSecret, refreshToken, read [here](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README.md#create-your-google-drive-api-keys).

- ## Usage

- ### Creating Content
  Use `put` method which accepts three parameters:
    - `content` - contents to be stored
    - `fileName` - filename of content to be stored
    - `dir` - If not specified, file will be stored under root. Otherwise, file will be stored under specifed dir.
  ```php
  $service->put('This is example text', 'example.txt');
  
  $service->put('This is text will be stored under specified dir','example.txt','12sdf_sdfjopwoeriupsdf')
  ```

- ### Getting File
  Use `get` method which accepts two parameters and return `Google\Drive\DriveFile` or `GuzzleHttp\Psr7\Response`
    - `fileName` - filename of content to be stored
    - `params` - If not specified, empty array is passed.
  ```php
  $service->get('xxxxxxxxxxxxx');

  // or

  $service->get('xxxxxxxxxxxxx', [
    // pass parameters
  ])
  ```

- ### Getting File Content
  Use `getContent` method which return `GuzzleHttp\Psr7\Response`. 
    - `fileName` - filename of content to be stored
  ```php
  $service->getContent('xxxxxxxxxxxxx');
  ```  

- ### Creating Dir
  Use `makeDirectory` which accepts two parameters:
    - `folderName` - folderName
    - `dir` - If not specified, folder will be created under root. Otherwise, folder will be created under specifed dir.
  ```php
  $service->makeDirectory('New Folder');
    
  $service->makeDirectory('New Folder Under Specified Dir','12sdf_sdfjopwoeriupsdf')
  ```

- ### Copy File
  Use `copy` which accepts three parameters:
    - `fromId` - fileId
    - `fileName` - fileName
    - `dir` - If not specified, folder will be created under root. Otherwise, folder will be created under specifed dir.
  ```php
  $service->copy('1kojo32uoiuo123','new file.txt');
    
  $service->copy('1kojo32uoiuo123','new file.txt','12sdf_sdfjopwoeriupsdf')
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
