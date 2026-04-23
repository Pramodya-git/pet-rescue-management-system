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
//Post Adoption Follow Up  Report Generate Section
$sql = "SELECT * FROM post_adoption_follow_up";
$result = $conn->query($sql);

// File name
$filename = "post_adoption_follow_up_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "Post Adoption Follow Up Report\n\n");
fwrite($file, str_pad("FollowUpID", 20) . str_pad("Reminder_Date", 20) . str_pad("Updates", 25) . str_pad("Feedback", 30) . str_pad("AdoptionID", 20) ."\n");
fwrite($file, str_repeat("-", 115) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['FollowUpID'], 20) .
        str_pad($row['Reminder_Date'], 20) .
        str_pad($row['Updates'], 25) .
        str_pad($row['Feedback'], 30) .
        str_pad($row['AdoptionID'], 20) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);
//Search bar empty check
$sea = isset($_POST["earch"]) ? $_POST["earch"] : ''; 
//Start adoption follow up data delete section
if(isset($_POST['delete'])){
	$FollowUpID = $_POST['followupid'];
    // Delete pet
    if($conn->query("DELETE FROM Post_Adoption_Follow_Up WHERE FollowUpID = '$FollowUpID'")){
        echo "<script>alert('Post Follow Up Details Delete Successfully');</script>";
        echo "<script>window.location.href = 'post_adoption_follow_up_management.php';</script>";
    } else {
        echo "<script>alert('Post Follow Up Details Delete Unsuccessfully');</script>";
		echo "<script>window.location.href = 'post_adoption_follow_up_management.php';</script>";
    }
}
//End adoption follow up data delete section





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
	  <?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Post Adoption Follow Up Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>Post Adoption Follow Up</h1>
	<h3><a href="Add_New_Post_Adoption_Follow_Up.php" class="pet-add-btn">Add New Post Adoption Follow Up</a></h3>
	<br /><br />
    <!--Pet Search Section-->
	<div class="admin-search-filter">
		    <form  method="POST" action="post_adoption_follow_up_management.php">
                <span class="search-bar">
		        <input type="search" id="admin-pet-search" name="earch" placeholder="Search Foster Follow Up Details Using Adoption ID...">
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
						    <th><center>Follow Up ID</center></th>
						    <th><center>Reminder Date</center></th>
                            <th><center>Updates</center></th>
                            <th><center>Feedback</center></th>
                            <th><center>Adoption ID</center></th>
							<th><center>Action</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        if($sea){
							$rch = "select * from Post_Adoption_Follow_Up where AdoptionID='$sea'";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>  
												      <td><center><?php echo $ret["FollowUpID"] ?></center></td>
												      <td><center><?php echo $ret["Reminder_Date"] ?></center></td>
						                              <td><center><?php echo $ret["Updates"] ?></center></td>
							                          <td><center><?php echo $ret["Feedback"] ?></center></td>
							                          <td><center><?php echo $ret["AdoptionID"] ?></center></td>
							                          <td><center>
																<form method="POST" action="post_adoption_follow_up_management.php" style="display:inline;">
																	<input type="hidden" name="followupid" value="<?php echo $ret['FollowUpID']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['FollowUpID']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>
                                                                <form method="POST" action="edit_post_adoption_follow_up.php" style="display:inline;">
																	<input type="hidden" name="followupid" value="<?php echo $ret['FollowUpID']; ?>">
																	<input type="hidden" name="reminderdate" value="<?php echo $ret["Reminder_Date"]; ?>">
																	<input type="hidden" name="updates" value="<?php echo $ret["Updates"]; ?>">
																	<input type="hidden" name="feedback" value="<?php echo $ret["Feedback"]; ?>">
																	<input type="hidden" name="adoptionid" value="<?php echo $ret["AdoptionID"]; ?>">
																	<input type="submit" name="edit" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Edit <?php echo $ret['FollowUpID']; ?>">
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
