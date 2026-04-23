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
//Search bar empty check
$sea = isset($_POST["earch"]) ? $_POST["earch"] : ''; 





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/pet_management.css" />
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
        <div class="profile">
          <img src="../src/account.png" alt="Profile"><br>
          <h3><?php echo $_SESSION["user"]["Role"]." : ".$_SESSION["user"]["User_Name"]  ?></h3>
          <p><?php echo $_SESSION["user"]["Email"] ?></p>
	      <span>User ID:<?php echo $_SESSION["user"]["UserID"] ?></span>
        </div>
    <button><a href="../logout.php" style="color:white; font-weight:bold; text-decoration:none;">Log Out</a></button>
        <ul>
          <li><a href="staffadmin.php">Dashboard</a></li>
          <li><a href="notifications.php">Notification</a></li>
	      <li><a href="pet_management.php">Pet Management</a></li>
          <li><a href="petintake.php">Rescue Intake</a></li>
	      <li><a href="medical_management.php">Medical Management</a></li>
          <li><a href="adoption_approved_details.php">Adoption Approved Details</a></li>
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
	<br /><br />
    <h1>Adoption Approved Details</h1>
	<br /><br />
    <!--Pet Search Section-->
	<div class="admin-search-filter">
		    <form  method="POST" action="adoption_approved_details.php">
                <span class="search-bar">
		        <input type="search" id="admin-pet-search" name="earch" placeholder="Search Status Approved Applcations...">
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
                            <th><center>Application ID</center></th>
                            <th><center>Applied Date</center></th>
                            <th><center>Status</center></th>
                            <th><center>Preferences</center></th>
                            <th><center>PetID</center></th>
                            <th><center>AdopterID</center></th>
                            <th><center>Actions</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        if($sea){
							$rch = "select * from Adoption_Application where Status ='$sea'";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>
						                              <td><center><?php echo $ret["ApplicationID"] ?></center></td>
							                          <td><center><?php echo $ret["DateApplied"] ?></center></td>
							                          <td><center><?php echo $ret["Status"] ?></center></td>
							                          <td><center><?php echo $ret["Preferences"] ?></center></td>
							                          <td><center><?php echo $ret["PetID"] ?></center></td>
							                          <td><center>
													  <?php
                                                      $id = $ret["AdopterID"];													  
													  $var = "select * from user where Role='volunteer' and UserID='$id'";
													  $result = $conn->query($var);
													  if($result && $result->num_rows > 0){
                                                          $output = $result->fetch_assoc();
														  echo $id." ".$output['Role'];
													  }else{
													      echo $id;	  
													  }
													   ?></center></td>
							                          <td><center>   
                                                                <form method="POST" action="adoption_process_details.php" style="display:inline;">
																	<input type="hidden" name="applicationid" value="<?php echo $ret['ApplicationID']; ?>">
																	<input type="submit" name="adoption-process" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Adoption Process <?php echo $ret['ApplicationID']; ?>">
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
