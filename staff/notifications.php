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


//Start Notification data delete section
if(isset($_POST['delete'])){
	$PNotifi_id = $_POST['Notifi_ID'];
    // Delete Notification
    if($conn->query("DELETE FROM notifications WHERE notifi_id = '$PNotifi_id'")){
        echo "<script>alert('Notifications deleted Successfully');</script>";
        echo "<script>window.location.href = 'notifications.php';</script>";
    } else {
        echo "<script>alert('Notifications deleted Unsuccessfully');</script>";
    }
}
//End Pet data delete section





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
    <h1>Rescue Notifications</h1>
	<br /><br />
    <!-- Tables -->
    <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th><center>Notification ID</center></th>
                            <th><center>Message</center></th>
                            <th><center>Photo</center></th>
                            <th><center>Time</center></th>
                            <th><center>Sender ID</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
							$rch = "select * from notifications order by created_at DESC";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>  
												      <td><center><?php echo $ret["notifi_id"] ?></center></td>
							                          <td><center><?php echo $ret["message"] ?></center></td>
						                              <td><center><img src="../admin/Client Sending Photos/<?php echo htmlspecialchars($ret["photo"]) ?>" style="width:70px;"></center></td>
							                          <td><center><?php echo $ret["created_at"] ?></center></td>
							                          <td><center><?php echo $ret["SenderID"] ?></center></td>
							                          <td><center>
																<form method="POST" action="notifications.php" style="display:inline;">
																	<input type="hidden" name="Notifi_ID" value="<?php echo $ret['notifi_id']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['notifi_id']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>       
							                              </center>
							                          </td>
						                        </tr>
												<?php
										}
									}else{
										echo "<tr><td colspan='6' style='text-align:center; font-weight:bold; color:red;'>No Notification Records</td></tr>";
									}
                                
                    ?>	
                    </tbody>
                </table>
    </div>
  </div>
</body>
</html>
