<?php
$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
if(isset($_POST['submit'])==1){
$username = $_POST["username"];
$email = $_POST["email"];
$mobile =$_POST["mobile"];
$address =$_POST["address"];
$password =$_POST["password"];
$confirm_password =$_POST["confirm-password"];
$role =$_POST["role"];
    if($password==$confirm_password){
		// Check if username exists
        $checkUser = $conn->query("SELECT * FROM user WHERE User_Name = '$username'");
        $checkPassword = $conn->query("SELECT * FROM user WHERE Password = '$password'");
        $checkemail = $conn->query("SELECT * FROM user WHERE Email = '$email'");
        $checkphone = $conn->query("SELECT * FROM user WHERE Phone = '$mobile'");
        if ($checkUser->num_rows > 0) {
            echo "<script>alert('User Name Already Exists...');
                  window.location='signup.php';</script>";
        } else if ($checkPassword->num_rows > 0) {
            echo "<script>alert('Password Already Exists...');
                  window.location='signup.php';</script>";
        } else if ($checkemail->num_rows > 0) {
            echo "<script>alert('Email Already Exists...');
                  window.location='signup.php';</script>";
        } else if ($checkphone->num_rows > 0) {
            echo "<script>alert('Phone Already Exists...');
                  window.location='signup.php';</script>";
        } else {
            $sql = "INSERT INTO user (User_Name, Password, Role, Email, Address, Phone) 
                    VALUES ('$username', '$password', '$role', '$email', '$address', '$mobile')";
            if ($conn->query($sql)) {
                echo "<script>alert('Registration Successful...');
                      window.location='../log.php';</script>";
            } else {
                echo "<script>alert('Error: Could not register user.');</script>";
            }
        }
		
	}else{
		echo "<script>alert('Confirm Password is wrong.Please check it.')</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup - Registration</title>
  <link rel="stylesheet" href="signup.css">
</head>
<body class="public-layout">

  <!-- Header -->
    <div class="nav-brand">🐾 ResQPet</div> 

  <!-- Signup Form Section -->
  <section class="form-section">
    <div class="form-container">
      <h2>Create Your Account</h2>
      <form action="signup.php" method="post" class="signup-form">
        
        <div class="form-group">
          <label for="username">User Name</label>
          <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="mobile">Mobile Number</label>
          <input type="tel" id="mobile" name="mobile" required pattern="[0-9]{10}">
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="3" required></textarea>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" required>
        </div>

        <div class="form-group">
          <label>Role</label>
          <div class="checkbox-group">
            <label><input type="radio" name="role" value="client"> Client</label>
            <label><input type="radio" name="role" value="volunteer"> Volunteer</label>
          </div>
        </div>

        <input type="submit" class="cta-button" value="Register" name="submit">
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-bottom">© 2025 ResQPet. All rights reserved.</div>
  </footer>

</body>
</html>
