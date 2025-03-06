<?php
    session_start();
    include 'connection.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $_SESSION['user'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Невірний логін або пароль";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="EN">
    <head>
        <title>Вхід</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .login-container {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 300px;
            }
            .login-container h2 {
                margin-bottom: 20px;
                color: #1F3C70;
            }
            .login-container input {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .login-container button {
                background-color: #1F3C70;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            .login-container button:hover {
                background-color: #FECF51;
            }
            .error-message {
                color: red;
                font-size: 14px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
    <div class="login-container">
            <h2>Вхід</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
    </html>