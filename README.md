# HTTP media transfer system coded in PHP. 
A simple solution to overcome the transfer and file viewing limitations in systems such as FTP or Cpanel, Plesk panel.

Configure the variables in the Send.php file according to the folder of your files to be moved.

Upload the get.php file to the server where the files will be sent.

You can rename the Send.php and Get.php files or limit the entries via tunnel. My advice is to set the media limitation and firewall at a basic level in get.php.

You can send files by setting a limit of 60-70 files to avoid IO problems.

Make sure you're running on https on both sides.

## The parameters you need to set on Send.php are:

### Media files in this folder will be collected
$localFolderPath = 'wp-content/uploads/blabla/';

### Media files will be sent to this address
$remoteServerUrl = 'https://blablablablablabla.com/get.php';

### Create this file in the same directory as send.php and grant write permission
$logFilePath = 'uploaded.log';

### Number of files to load each time. If the system gives an error, you can reduce the number
$uploadLimit = 50;

### Allowed media extensions
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'svg');
