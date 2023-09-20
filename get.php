<?php
// Folder path where images will be saved
$saveFolderPath = 'seturapi_medias/';

if (!is_dir($saveFolderPath)) {
    // If the folder does not exist, create it
    mkdir($saveFolderPath, 0777, true);
}

// Save the file received via POST request
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $destination = $saveFolderPath . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo 'Saved : ' . $fileName;
    } else {
        echo 'File Save Error';
    }
} else {
    echo 'No File';
}
