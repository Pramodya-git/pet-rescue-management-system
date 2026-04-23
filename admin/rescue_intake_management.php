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

//Rescue Intake Report Generate Section
$sql = "SELECT * FROM rescue";
$result = $conn->query($sql);

// File name
$filename = "rescue_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "Rescue Report\n\n");
fwrite($file, str_pad("RescueID", 10) . str_pad("Date", 20) . str_pad("Location", 25) . str_pad("Notes", 30) . str_pad("RescuedBy", 20) . str_pad("Saved", 15) . "\n");
fwrite($file, str_repeat("-", 120) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['RescueID'], 10) .
        str_pad($row['Date'], 20) .
        str_pad($row['Location'], 25) .
        str_pad($row['Notes'], 30) .
        str_pad($row['RescuedBy'], 20) .
        str_pad($row['Saved'], 15) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);


//Search bar empty check
$sea = isset($_POST["usearch"]) ? $_POST["usearch"] : ''; 
//Start Rescue intake data delete section
if(isset($_POST['delete'])){
	$puser_id = $_POST["user_id"];
			$sql = $conn->query("DELETE FROM rescue WHERE RescueID = '$puser_id'");
			if($sql){
			  echo "<script>alert('Rescue details were deleted successfully.');</script>";
			}else{
		      echo "<script>alert('Rescue details were not deleted..');</script>";
	        } 
}
//End Rescue intake data delete section

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
	  <?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Rescue Intake Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>Rescue Management</h1><br><br>
    <!--Pet Search Section-->
	<div class="admin-search-filter">
	        <form method="POST" action="rescue_intake_management.php">
                <span class="search-bar">
                    <input type="search" id="admin-pet-search" name="usearch" placeholder="Search Rescue Details Using Date...">
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
                            <th><center>Rescue ID</center></th>
                            <th><center>Date</center></th>
                            <th><center>Location</center></th>
                            <th><center>Notes</center></th>
                            <th><center>Rescued By</center></th>
                            <th><center>Saved</center></th>
							<th><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        
                        //echo $sea;
                        if($sea){
							
							$rch = "select * from rescue where Date='$sea'";
							$resc =  $conn->query($rch); 
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>
						                              <td><center><?php echo $ret["RescueID"]?></center></td>
							                          <td><center><?php echo $ret["Date"] ?></center></td>
							                          <td><center><?php echo $ret["Location"] ?></center></td>
							                          <td><center><?php echo $ret["Notes"] ?></center></td>
							                          <td><center><?php echo $ret["RescuedBy"] ?></center></td>
							                          <td><center><?php echo $ret["Saved"] ?></center></td>
							                          <td><center>
													        <form method="POST" action="rescue_intake_management.php" style="display:inline;">
															    <input type="hidden" name="user_id" value="<?php echo $ret['RescueID']; ?>">
																<input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['RescueID'];?>">&nbsp;&nbsp;&nbsp;
															</form>
															    <!--Edit Button Section-->
															<form method="POST" action="edit_rescue_intake_details.php" style="display:inline;">
															    <input type="hidden" name="rescue_id" value="<?php echo $ret['RescueID']; ?>">
																<input type="hidden" name="rescuedby_id" value="<?php echo $ret['RescuedBy']; ?>">
																<input type="hidden" name="saved_id" value="<?php echo $ret['Saved']; ?>">
															    <input type="submit" name="edituser" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Edit <?php echo $ret['RescueID'];?>">
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
