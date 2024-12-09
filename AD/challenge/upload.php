<?php

$uploadDirectory = 'upload/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $filePath = $uploadDirectory . uniqid() . '-' . $fileName;

            // Open the uploaded file to read its contents
            $fileStream = fopen($file['tmp_name'], 'rb');
            $magicBytes = fread($fileStream, 4); // Read the first 4 bytes
            fclose($fileStream);

            // Map magic bytes to file types
            $magicByteMap = [
                "\xFF\xD8\xFF" => "jpeg", // JPEG
                "\x89\x50\x4E\x47" => "png", // PNG
                "GIF87a" => "gif", // GIF
                "GIF89a" => "gif", // GIF (alternate)
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
                // Validate the actual image content
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
                    // Move the uploaded file
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

// List uploaded files
$files = array_diff(scandir($uploadDirectory), ['.', '..']);
echo json_encode(['success' => true, 'files' => $files]);

?>
