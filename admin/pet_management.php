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

//Pet Report Generate Section
$sql = "SELECT * FROM Pets";
$result = $conn->query($sql);

// File name
$filename = "pets_report.txt";

// Open file
$file = fopen($filename, "w");

// Write header
fwrite($file, "Pets Report\n\n");
fwrite($file, str_pad("PetID", 10) . str_pad("Pet_Type", 20) . str_pad("Breed", 25) . str_pad("Age", 30) . str_pad("Gender", 20) . str_pad("Status", 15) . str_pad("Behavior", 15) . str_pad("Story", 15) . "\n");
fwrite($file, str_repeat("-", 150) . "\n");

// Write data
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
    fwrite($file, 
        str_pad($row['PetID'], 10) .
        str_pad($row['Pet_Type'], 20) .
        str_pad($row['Bread'], 25) .
        str_pad($row['Age'], 30) .
        str_pad($row['Gender'], 20) .
        str_pad($row['Status'], 15) .
        str_pad($row['Behavior'], 15) .
		str_pad($row['Story'], 15) .
		"\n"
    );}
}else{
    fwrite($file, "No Records Found\n");
}

fclose($file);







//Search bar empty check
$sea = isset($_POST["earch"]) ? $_POST["earch"] : ''; 
//Start Pet data delete section
if(isset($_POST['delete'])){
	$Ppet_id = $_POST['PetID'];
    // Optional: delete related adoption applications first
	$conn->query("delete from Post_Adoption_Follow_Up where AdoptionID in (select AdoptionID from Adoption_Process where ApplicationID in (select ApplicationID from Adoption_Application where PetID = '$Ppet_id'))");
    $conn->query("delete from Adoption_Process where ApplicationID in (select ApplicationID from Adoption_Application where PetID = '$Ppet_id')");
	$conn->query("DELETE FROM Adoption_Application WHERE PetID = '$Ppet_id'");
    $conn->query("DELETE FROM rescue WHERE Saved = '$Ppet_id'");
	$conn->query("DELETE FROM MedicalRecord WHERE PetID = '$Ppet_id'");
	$conn->query("DELETE FROM Foster WHERE PetID = '$Ppet_id'");
    // Delete pet
    if($conn->query("DELETE FROM Pets WHERE PetID = '$Ppet_id'")){
        echo "<script>alert('Pet $Ppet_id deleted successfully');</script>";
        echo "<script>window.location.href = 'pet_management.php';</script>";
    } else {
        echo "Error deleting pet: " . $conn->error;
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
	  <?php echo "<a href='$filename' download style='color:white;border-radius:20px;padding:10px 40px;background: linear-gradient(to right, #667eea, #764ba2);'>Pet Report Generate</a>"; ?>
    </div>
	<br /><br />
    <h1>Pet Management</h1>
	<h3><a href="add.php" class="pet-add-btn">Add New Pet</a></h3>
	<br /><br />
    <!--Pet Search Section-->
	<div class="admin-search-filter">
		    <form  method="POST" action="pet_management.php">
                <span class="search-bar">
		        <input type="search" id="admin-pet-search" name="earch" placeholder="Search pets...">
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
                            <th><center>Photo</center></th>
                            <th><center>Pet Type</center></th>
                            <th><center>Breed</center></th>
                            <th><center>Age</center></th>
                            <th><center>Status</center></th>
                            <th><center>Gender</center></th>
                            <th><center>Actions</center></th>
                        </tr>
                    </thead>
                    <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
					<?php                   
                        //Search bar variable
                        if($sea){
							$rch = "select * from Pets where Pet_Type='$sea'";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>
						                              <td><center><img src="Test Image/<?php echo htmlspecialchars($ret["photo"]) ?>" style="width:70px;"></center></td>
							                          <td><center><?php echo $ret["Pet_Type"] ?></center></td>
							                          <td><center><?php echo $ret["Bread"] ?></center></td>
							                          <td><center><?php echo $ret["Age"] ?></center></td>
							                          <td><center><?php echo $ret["Status"] ?></center></td>
							                          <td><center><?php echo $ret["Gender"] ?></center></td>
							                          <td><center>
																<form method="POST" action="pet_management.php" style="display:inline;">
																	<input type="hidden" name="PetID" value="<?php echo $ret['PetID']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Remove <?php echo $ret['PetID']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>
                                                                <form method="POST" action="edit.php" style="display:inline;">
																	<input type="hidden" name="PetID" value="<?php echo $ret['PetID']; ?>">
																	<input type="hidden" name="PetType" value="<?php echo $ret["Pet_Type"]; ?>">
																	<input type="hidden" name="PetBreed" value="<?php echo $ret["Bread"]; ?>">
																	<input type="hidden" name="Age" value="<?php echo $ret["Age"]; ?>">
																	<input type="hidden" name="Status" value="<?php echo $ret["Status"]; ?>">
																	<input type="hidden" name="Gender" value="<?php echo $ret["Gender"]; ?>">
																	<input type="hidden" name="Behavior" value="<?php echo $ret["Behavior"]; ?>">
																	<input type="submit" name="edit" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Edit <?php echo $ret['PetID']; ?>">
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
