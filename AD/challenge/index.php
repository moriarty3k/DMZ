<?php
    #include('config.php');
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errors Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4 text-primary"><b style="color:red;">Errors Management</b></h1>
            <p class="lead">Upload the screenshot containing errors BELLOW.</p>
        </div>
        <form id="uploadForm" class="bg-light p-4 rounded shadow">
            <div class="mb-3">
                <label for="file" class="form-label">Choose an Image</label>
                <input type="file" name="file" id="file" class="form-control" accept="image/jpeg, image/png, image/gif">
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>
        <hr class="my-4">
        <div id="fileList" class="mt-4">

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            $('#uploadForm').submit(function (event) {
                event.preventDefault(); 

                let formData = new FormData(this);

                let file = formData.get('file');
                if (!file.type.match(/^image\/(jpeg|gif|png)$/)) {
                    alert('Invalid file type. Please upload a JPEG or PNG, or GIF image.');
                    return;
                }

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        var response = jQuery.parseJSON(data);
                        if (response.success) {
                            let fileList = `<p><a href="${response.file}" target="_blank" class="text-decoration-none text-success">${response.file}</a></p>`;
                            $('#fileList').append(fileList);
                        } else {
                            alert('File upload failed. Please try again.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while uploading. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>
<!-- if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
} -->
