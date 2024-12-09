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
