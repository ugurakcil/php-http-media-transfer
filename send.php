<?php
/**
 * github : @ugurakcil
 */
set_time_limit(0);

// Media files in this folder will be collected
$localFolderPath = 'wp-content/uploads/blablablabla/';

// Media files will be sent to this address
$remoteServerUrl = 'https://blablablablabla.com/get.php';

// Create this file in the same directory as send.php and grant write permission
$logFilePath = 'uploaded.log';

// Number of files to load each time. If the system gives an error, you can reduce the number
$uploadLimit = 50;

// Allowed media extensions
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'svg');

// Get previously sent files from log file
$skippedFiles = file($logFilePath, FILE_IGNORE_NEW_LINES);

// Get files from folder
$files = scandir($localFolderPath);

// Specify files to send
$filesToSend = array();

foreach ($files as $file) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    if (!in_array($extension, $allowedExtensions)) {
        continue;
    }

    if (!in_array($file, $skippedFiles)) {
        $filesToSend[] = $file;
    }

    if (count($filesToSend) >= $uploadLimit) {
        break; // finish at the limit
    }
}

echo '<h3 style="display:block;margin:70px 0 4px 0;padding:10px 5px;">Files Sent</h3>';

$sentCount = 0;

// Send pending files in order
foreach ($filesToSend as $file) {
    $postData = array(
        'file' => curl_file_create($localFolderPath . $file),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remoteServerUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo '<p style="color:red;font-weight:bold;">File : ' . $file . ' / Error : ' . curl_error($ch) . '</p>';
        break;
    } else {
        echo '<p style="margin:0 0;padding:0 0 4px 15px;font-size:11px;">' . $file . '</p>';

        // Add the name of the sent file to the log file
        file_put_contents($logFilePath, $file . PHP_EOL, FILE_APPEND);
        $sentCount++;
    }

    curl_close($ch);

    sleep(0.2);
}

echo "<p style=\"font-weight:bold;display:inline-block;position:absolute;top:0;left:0;width:100%;margin:0;padding:20px 25px;background:black;color:green;border-bottom:1px solid gray;\">Total number of uploaded medias: " . (count($skippedFiles) + $sentCount) .' / '. count($files) . "</p>";
echo '<script>setTimeout(function(){ location.reload(); }, 2000);</script>';
