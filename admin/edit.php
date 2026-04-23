<?php
session_start();
if(!isset($_SESSION["user"])){
	header("Location: ../log.php");
	exit;
}

$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

//Start Edit Section
$CPet_id = $_POST["PetID"];
$Breed = $_POST["PetBreed"];
$Gender = $_POST["Gender"];
$Behavior = $_POST["Behavior"];
$Pet_type = $_POST["PetType"];
$Age = $_POST["Age"];
$Status = $_POST["Status"];

if(isset($_POST['submit'])){
    $pet_type = $_POST['pet-type'];
    $bread = $_POST['bread'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $behavior = $_POST['behavior'];
    $story = $_POST['story'];
    
    $file_name = $_FILES['photo']['name'];
    $tempname = $_FILES['photo']['tmp_name'];
    $folder = 'Test Image/'.$file_name;

    // Build query
    $update_sql = "UPDATE Pets SET Pet_Type='$pet_type',Bread='$bread',Age='$age',Gender='$gender',Status='$status',Behavior='$behavior',Story='$story',Photo='$file_name' where PetID='$CPet_id'";
    
    // Execute query
    if($conn->query($update_sql)){
        // Move uploaded file if provided
        if(!empty($file_name)){
            move_uploaded_file($tempname, $folder);
        }
        echo "<script>
                alert('Pet Details Updated Successfully!');
                window.location.href='pet_management.php';
              </script>";
    } else {
        echo "Update failed: " . $conn->error;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/add.css" />
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <div class="profile">
          <img src="../src/account.png" alt="Profile"><br>
          <h3><?php echo $_SESSION["user"]["Role"]." : ".$_SESSION["user"]["User_Name"]  ?></h3>
          <p><?php echo $_SESSION["user"]["Email"] ?></p>
        </div>
    <button><a href="../logout.php" style="color:white; font-weight:bold; text-decoration:none;">Log Out</a></button>
        <ul>
          <li><a href="admin.php">Dashboard</a></li>
          <li><a href="user_management.php">User Management</a></li>
          <li><a href="pet_management.php">Pet Management</a></li>
          <li><a href="rescue_intake_management.php">Rescue Management</a></li>
          <li><a href="adoption_management.php">Adoption Management</a></li>
		  <li><a href="foster_management.php">Foster Management</a></li>
		  <li><a href="post_adoption_follow_up_management.php">Post Adoption Follow Up</a></li>
        </ul>
  </div>

  <!-- Main Content -->
  <div class="main">
    <!-- Topbar -->
    <div class="topbar">
      <span><h1>🐾 ResQPet</h1></span>
    </div>
	<br />
    <h1>Pet Management</h1>
	
	<br />  <fieldset><legend>Edit Pet Details</legend> 
	<br><br>
	        <form method="POST" action="edit.php" enctype="multipart/form-data">
			<div class="section-one">
                <div class="section">
					<div>
					    <label for="bread">Breed :<?php echo $Breed ?></label><br>
						<input type="text" name="bread" id="bread" size="30" Required>
					</div>
					<div><br>
					    <label for="gender">Gender :<?php echo $Gender ?></label><br>
						<input type="text" name="gender" id="gender" size="30" Required>
					</div>
					<div><br>
					    <label for="behavior">Behavior :<?php echo $Behavior ?></label><br>
						<input type="text" name="behavior" id="behavior" size="30" Required>
					</div>
					<div><br>
					    <label for="photo">Photo</label><br>
						<input type="file" name="photo" id="photo" >
					</div><br><br>
				</div>
				 <div class="section">
					<div>
					    <label for="pet-type">Pet Type :<?php echo $Pet_type ?></label><br>
						<input type="text" name="pet-type" id="pet-type" size="30" Required>
					</div>
					<div><br>
					    <label for="age">Age :<?php echo $Age ?></label><br>
						<input type="text" name="age" id="age" size="30" Required>
					</div>
					<div><br>
					    <label for="status">Status :<?php echo $Status ?></label><br>
						<input type="text" name="status" id="status" size="30" Required>
					</div>
					<div><br>
					    <label for="story">Story</label><br>
						<input type="text" name="story" id="story" size="30" Required>
					</div>
					<div><br>
					    <input type="hidden" name="PetID" value="<?php echo $CPet_id; ?>">
						<input type="hidden" name="PetBreed" value="<?php echo $Breed; ?>">
						<input type="hidden" name="Gender" value="<?php echo $Gender; ?>">
						<input type="hidden" name="Behavior" value="<?php echo $Behavior; ?>">
						<input type="hidden" name="PetType" value="<?php echo $Pet_type; ?>">
						<input type="hidden" name="Age" value="<?php echo $Age; ?>">
						<input type="hidden" name="Status" value="<?php echo $Status; ?>">
						<input type="submit"  value="Update" size="30" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
