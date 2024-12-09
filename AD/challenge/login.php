<?php
    session_start();
    include('config.php');

    if (isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $params = array($username, $password);

        $stmt = sqlsrv_prepare($conn, $sql, $params);

        if ($stmt && sqlsrv_execute($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($row) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];

                header('Location: /index.php');
                exit();
            } else {
                echo "<script>alert('Invalid username or password')</script>";
            }
        } else {
            echo "<script>alert('Error processing your request.')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #f9f9f9;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container .form-group label {
            font-weight: bold;
        }
        .login-container .form-control {
            border-radius: 5px;
            box-shadow: none;
        }
        .login-container .btn {
            width: 100%;
            padding: 10px;
        }
        .login-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="#" method="post">
            <div class="login-container">
                <h2 class="text-center">Login</h2>
                <div class="form-group">
                    <label for="uname">Email</label>
                    <input type="email" class="form-control" id="uname" placeholder="Enter Email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="psw">Password</label>
                    <input type="password" class="form-control" id="psw" placeholder="Enter Password" name="password" required>
                </div>
                <button name="login" type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>