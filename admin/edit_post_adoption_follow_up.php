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

$PFollowupid = $_POST['followupid'];
$PReminderdate = $_POST['reminderdate'];
$PUpdates = $_POST['updates'];
$PFeedback = $_POST['feedback'];
$PAdoptionid = $_POST['adoptionid'];
//Start update post adoption follow up Section
if(isset($_POST['submit'])){
	$Reminder_date = $_POST['_reminder-date'];
	$Updates = $_POST['_updates'];
	$Feedback = $_POST['_feedback'];
	$Adoption_id = $_POST['_adoption-id'];
	
	
    $update_sql = "UPDATE Post_Adoption_Follow_Up SET Reminder_Date='$Reminder_date',Updates='$Updates',Feedback='$Feedback',AdoptionID='$Adoption_id' where FollowUpID='$PFollowupid'";
    	if($conn->query($update_sql)){	
		    echo "<script>
                alert('Post Adoption Follow Up Details Updated Successfully!');
                window.location.href='post_adoption_follow_up_management.php';
              </script>";
        }else{
			echo "<script>
                alert('Post Adoption Follow Up Details Updated Unsuccessfully!');
                window.location.href='edit_post_adoption_follow_up.php';
              </script>";
		}
}	
	

//End update post adoption follow up Section

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
    <h1>Post Adoption Follow Up</h1>
	
	<br />  <fieldset><legend>Edit Post Adoption Follow Up Details Section</legend> 
	<br><br>
	        <form method="POST" action="edit_post_adoption_follow_up.php">
			<div class="section-one">
                <div class="section">
				    <br>
					<div>
					    <label for="_reminder-date">Reminder Date</label><br>
						<input type="text" name="_reminder-date" id="_reminder-date" size="30" placeholder="<?php echo $PReminderdate ?>" Required>
					</div>
					<div><br>
					    <label for="_updates">Updates</label><br>
						<input type="text" name="_updates" id="_updates" size="30" placeholder="<?php echo $PUpdates ?>" Required>
					</div>
				</div>
				 <div class="section"><br><br><br><br>
					<div><br>
					    <label for="_feedback">Feedback</label><br>
						<input type="text" name="_feedback" id="_feedback" placeholder="<?php echo $PFeedback ?>" size="30"> 
					</div>
					<div><br>
					    <label for="_adoption-id">Adoption ID</label><br>
						<input type="text" name="_adoption-id" id="_adoption-id" size="30" placeholder="<?php echo $PAdoptionid ?>" Required>
					</div>
					<div><br><br>
					    <input type="hidden" name="followupid" value="<?php echo $PFollowupid; ?>">
					    <input type="hidden" name="reminderdate" value="<?php echo $PReminderdate; ?>">
					    <input type="hidden" name="updates" value="<?php echo $PUpdates; ?>">
					    <input type="hidden" name="feedback" value="<?php echo $PFeedback; ?>">
					    <input type="hidden" name="adoptionid" value="<?php echo $PAdoptionid; ?>">
						<input type="submit"  value="Edit Post Adoption Follow Up Details" size="30" name="submit" class="update-button">
					</div>
				</div>
			</div>
	        </form><br><br><br><br><br><br><br><br>
			</fieldset>
    </div>
</body>
</html>
