<?php
#include('config.php');
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$uploadDirectory = 'upload/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $filePath = $uploadDirectory . uniqid() . '-' . $fileName;

            $fileStream = fopen($file['tmp_name'], 'rb');
            $magicBytes = fread($fileStream, 4); 
            fclose($fileStream);

            
            $magicByteMap = [
                "\xFF\xD8\xFF" => "jpeg",
                "\x89\x50\x4E\x47" => "png", 
                "GIF87a" => "gif", 
                "GIF89a" => "gif", 
            ];

            $isValidFile = false;
            $fileType = null;

            foreach ($magicByteMap as $bytes => $type) {
                if (strpos($magicBytes, $bytes) === 0) {
                    $isValidFile = true;
                    $fileType = $type;
                    break;
                }
            }

            if ($isValidFile) {
                $isRenderable = false;
                switch ($fileType) {
                    case 'jpeg':
                        $isRenderable = @imagecreatefromjpeg($file['tmp_name']) !== false;
                        break;
                    case 'png':
                        $isRenderable = @imagecreatefrompng($file['tmp_name']) !== false;
                        break;
                    case 'gif':
                        $isRenderable = @imagecreatefromgif($file['tmp_name']) !== false;
                        break;
                }

                if ($isRenderable) {
                    if (move_uploaded_file($file['tmp_name'], $filePath)) {
                        echo json_encode(['success' => true, 'file' => $filePath]);
                        return;
                    } else {
                        echo json_encode(['success' => false, 'error' => 'File move failed']);
                        return;
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'File is not a valid or renderable image']);
                    return;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'File is not a recognized image format']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'File upload error']);
            return;
        }
    }
}

$files = array_diff(scandir($uploadDirectory), ['.', '..']);
echo json_encode(['success' => true, 'files' => $files]);

?>
