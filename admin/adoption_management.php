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
//Adoption Application Report Generate Section
$sql = "SELECT * FROM Adoption_Application";
$result = $conn->query($sql);

// File name
$filename = "adoption_application_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "Adoption Application Report\n\n");
fwrite($file, str_pad("ApplicationID", 20) . str_pad("DateApplied", 20) . str_pad("Status", 25) . str_pad("Preferences", 30) . str_pad("PetID", 20) . str_pad("AdopterID", 15) . "\n");
fwrite($file, str_repeat("-", 130) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['ApplicationID'], 20) .
        str_pad($row['DateApplied'], 20) .
        str_pad($row['Status'], 25) .
        str_pad($row['Preferences'], 30) .
        str_pad($row['PetID'], 20) .
        str_pad($row['AdopterID'], 15) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);

//Search bar empty check
$sea = isset($_POST["earch"]) ? $_POST["earch"] : ''; 
//Start adoption application data delete section
if(isset($_POST['approve'])){
	$PApplication_id = $_POST['applicationid'];
	
	$sql = "update Adoption_Application set Status='Approved' where ApplicationID='$PApplication_id'";
	$result = $conn->query($sql);
	if($result){
		//window.location එක සමග Applcations ID එකද පාස් වී ඇත
		echo "<script>alert('Approved Successfully!');
		              window.location='adoption_process.php?id=$PApplication_id';
			  </script>";
	}else{
		echo "<script>alert('Approved Unsuccessfully!');</script>";
	}
}else if(isset($_POST['rejected'])){
	$PApplication_id = $_POST['applicationid'];
	
	$sql = "update Adoption_Application set Status='Rejected' where ApplicationID='$PApplication_id'";
	$result = $conn->query($sql);
	if($result){
		$conn->query("DELETE FROM Adoption_Application WHERE ApplicationID = '$PApplication_id' and Status='Rejected'");
		echo "<script>alert('Rejected Successfully!');</script>";
	}else{
		echo "<script>alert('Rejected Unsuccessfully!');</script>";
	}
}
//End adoption application data delete section





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
	  <?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Adoption Application Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>Adoption Management</h1>
	<br /><br />
    <!--Pet Search Section-->
	<div class="admin-search-filter">
		    <form  method="POST" action="adoption_management.php">
                <span class="search-bar">
		        <input type="search" id="admin-pet-search" name="earch" placeholder="Search Status Pending Applcations...">
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
																<form method="POST" action="adoption_management.php" style="display:inline;">
																	<input type="hidden" name="applicationid" value="<?php echo $ret['ApplicationID']; ?>">
																    <input type="submit" name="approve" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Approve <?php echo $ret['ApplicationID']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>   
                                                                <form method="POST" action="adoption_management.php" style="display:inline;">
																	<input type="hidden" name="applicationid" value="<?php echo $ret['ApplicationID']; ?>">
																	<input type="submit" name="rejected" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Rejected <?php echo $ret['ApplicationID']; ?>">
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
