<?php
session_start();
$name = $_POST["username"];
$password = $_POST["password"];

$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

// Correct table name -> users
$sql = "SELECT * FROM user WHERE User_Name='$name' AND Password='$password'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $_SESSION["user"]= $result->fetch_assoc();
	if($_SESSION["user"]["Role"]=="Admin"){
		header("Location:admin/admin.php");
        exit();
	}else if($_SESSION["user"]["Role"]=="client" || $_SESSION["user"]["Role"]=="Client"){
		header("Location: client/client.php");
		exit();
	}else if($_SESSION["user"]["Role"]=="volunteer" || $_SESSION["user"]["Role"]=="Volunteer"){
		header("Location: volunteer/volunteer.php");
		exit();	
	}else if($_SESSION["user"]["Role"]=="Staff" || $_SESSION["user"]["Role"]=="staff" || $_SESSION["user"]["Role"]=="Veterinary Doctor" || $_SESSION["user"]["Role"]=="veterinary doctor" || $_SESSION["user"]["Role"]=="Rescue" || $_SESSION["user"]["Role"]=="rescue"){
	    header("Location: staff/staffadmin.php");
    }else{
        header("Location: log.php?error=Inavalid.");
}
}else{
	header("Location: log.php?error=Inavalid.");
}
?>
