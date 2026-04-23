<?php
session_start();
if(isset($_SESSION["user"])){
	header("Location:admin/admin.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Rescue Login</title>
    <!--<link rel="stylesheet" type="text/css" href="log.css"/>-->
	<style>
	* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            width: 310px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #444;
        }
        .input-box {
            margin: 15px 0;
        }
        .input-box input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 14px;
        }
        .input-box input:focus {
            border-color: #ff9900;
        }
        .login-btn {
            background: #ff9900;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-btn:hover {
            background: #e68a00;
        }
        .extra-links {
            margin-top: 15px;
            font-size: 14px;
        }
        .extra-links a {
            color: #ff9900;
            text-decoration: none;
        }
	</style>
</head>
<body>
    <div class="login-container">
        <h2>🐾 Pet Rescue Login</h2>
        <form method="POST" action="check.php" >
            <div class="input-box">
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" autocomplete="new-password">
            </div>
                <input type="submit" class="login-btn"/>
            <div class="extra-links">
                <a href="home interface/signup.php">Register here</a>
            </div>
        </form>
    </div>
    
</body>
</html>