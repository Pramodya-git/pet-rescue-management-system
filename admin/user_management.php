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
//User Report Generate Section
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

// File name
$filename = "user_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "User Report\n\n");
fwrite($file, str_pad("UserID", 10) . str_pad("UserName", 20) . str_pad("Role", 10) . str_pad("Email", 30) . str_pad("Address", 20) . str_pad("Phone", 15) . "\n");
fwrite($file, str_repeat("-", 105) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['UserID'], 10) .
        str_pad($row['User_Name'], 20) .
        str_pad($row['Role'], 10) .
        str_pad($row['Email'], 30) .
        str_pad($row['Address'], 20) .
        str_pad($row['Phone'], 15) . "\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);

//Search bar empty check
$sea = isset($_POST["usearch"]) ? $_POST["usearch"] : ''; 
//Start User data delete section
if(isset($_POST['delete'])){
	$puser_id = $_POST["user_id"];
    // Optional: delete related adoption applications first
	$conn->query("delete from Post_Adoption_Follow_Up where AdoptionID IN (select AdoptionID from Adoption_Process where ApplicationID in (select ApplicationID from Adoption_Application where AdopterID ='$puser_id'))");
	$conn->query("delete from Adoption_Process where ApplicationID in(select ApplicationID from Adoption_Application where AdopterID = '$puser_id')");
    $conn->query("DELETE FROM Adoption_Application WHERE AdopterID = '$puser_id'");
    $conn->query("DELETE FROM rescue WHERE RescuedBy = '$puser_id'");
	$conn->query("DELETE FROM MedicalRecord WHERE VetID = '$puser_id'");
	$conn->query("DELETE FROM Foster WHERE CaregiverID = '$puser_id'");
	$conn->query("DELETE FROM notifications WHERE SenderID = '$puser_id'");
	//If you delete your login admin accoun.this section check it and automatically log out you
	if($_SESSION["user"]["UserID"]==$puser_id){
			$conn->query("DELETE FROM user WHERE UserID = '$puser_id'");
			echo "<script>alert('Warning!You deleted your login account.');</script>";
			session_destroy();
	        echo "<script>window.location.href = '../log.php';</script>";
    }else{
		    if($conn->query("DELETE FROM user WHERE UserID = '$puser_id'") ){
                echo "<script>alert('User $puser_id deleted successfully');</script>";
                echo "<script>window.location.href = 'user_management.php';</script>";
            } else {
                echo "Error deleting user: " . $conn->error;
            }
	}
    
}
//End User data delete section

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/user_management.css" />
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
	<?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>User Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>User Management</h1>
	<h3><a href="adduser.php" class="user-add-btn">Add New User</a></h3>
	
	<br><br>
    <!--Pet Search Section-->
	<div class="admin-search-filter">
	        <form method="POST" action="user_management.php">
                <span class="search-bar">
                    <input type="search" id="admin-pet-search" name="usearch" placeholder="Search users...">
                </span>&nbsp;
				<span class="Search-button">
		        <input type="submit" value="Search" class="search">
		        </span>
            </form>
    </div>
    <!-- Tables -->
    <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th><center>UserID</center></th>
                            <th><center>User Name</center></th>
                            <th><center>Password</center></th>
                            <th><center>Role</center></th>
                            <th><center>Email</center></th>
                            <th><center>Address</center></th>
                            <th><center>Phone</center></th>
							<th><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        
                        //echo $sea;
                        if($sea){
							
							$rch = "select * from user where UserID='$sea' or Role='$sea'";
							$resc =  $conn->query($rch); 
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>
						                              <td><center><?php echo $ret["UserID"]?></center></td>
							                          <td><center><?php echo $ret["User_Name"] ?></center></td>
							                          <td><center><?php echo $ret["Password"] ?></center></td>
							                          <td><center><?php echo $ret["Role"] ?></center></td>
							                          <td><center><?php echo $ret["Email"] ?></center></td>
							                          <td><center><?php echo $ret["Address"] ?></center></td>
							                          <td><center><?php echo $ret["Phone"] ?></center></td>
							                          <td><center>
													        <form method="POST" action="user_management.php" style="display:inline;">
															    <input type="hidden" name="user_id" value="<?php echo $ret['UserID']; ?>">
																<input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['UserID'];?>">&nbsp;&nbsp;&nbsp;
															</form>
															    <!--Edit Button Section-->
															<form method="POST" action="edituser.php" style="display:inline;">
															    <input type="hidden" name="user_id" value="<?php echo $ret['UserID']; ?>">
															    <input type="submit" name="edituser" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Edit <?php echo $ret['UserID'];?>">
															</form> 
                                                                
							                              </center>
							                          </td>
						                        </tr>
												<?php
										}
									}else{
										echo "<script>document.getElementById('admin-pet-search').style.borderColor='red';</script>";
									}
                                
						}
                    ?>	
                    </tbody>
                </table>
    </div>
  </div>
</body>
</html>
