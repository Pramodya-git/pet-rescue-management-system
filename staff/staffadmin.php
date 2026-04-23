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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Admin Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #f8f9fc;
      color: #333;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: #1e293b;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
      transition: all 0.3s ease;
    }

    .sidebar .profile {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar .profile img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .sidebar .profile h3 {
      font-size: 16px;
      margin-bottom: 5px;
    }

    .sidebar .profile p {
      font-size: 13px;
      color: #94a3b8;
    }

    .sidebar button {
      background: #ef4444;
      border: none;
      padding: 10px;
      margin: 15px 0;
      color: #fff;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
    }

    .sidebar ul {
      list-style: none;
    }
    
	a {
	  color:white;
	  text-decoration:none;
	}
    .sidebar ul li  {
      padding: 12px 0;
      cursor: pointer;
      transition: 0.3s;
    }

    a:hover {
      color: #60a5fa;
    }

    /* Main Content */
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .topbar {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
	  padding:15px;
	  box-shadow: 0px 2px 5px 1px rgba(0,0,0,0.1);
    }

    .topbar input {
      padding: 8px 12px;
      flex: 1;
      min-width: 200px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .cards {
      display: grid;
	  
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
    }

    .card {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
	  text-align:center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .card h2 {
      font-size: 22px;
      margin-bottom: 5px;
      color: #2563eb;
    }

    .tables {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .table-card {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      overflow-x: auto; /* makes table scrollable on small screens */
    }

    .table-card h3 {
      margin-bottom: 10px;
      color: #1e293b;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      min-width: 400px; /* force scroll on small screens */
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #eee;
      font-size: 14px;
    }

    .btn {
      margin-top: 10px;
      display: inline-block;
      padding: 6px 12px;
      background: #2563eb;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-size: 13px;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      body {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
      }
      .sidebar ul {
        display: flex;
        gap: 15px;
      }
    }

    @media (max-width: 768px) {
      .tables {
        grid-template-columns: 1fr;
      }
      .topbar {
        flex-direction: column;
        align-items: stretch;
      }
      .topbar input {
        width: 100%;
      }
    }

    @media (max-width: 480px) {
      .sidebar {
        flex-direction: column;
        align-items: flex-start;
      }
      .sidebar ul {
        flex-direction: column;
        width: 100%;
      }
      .card h2 {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="profile">
      <img src="src/account.png" alt="Profile"><br>
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
    <h1>Dashboard Overview</h1><br /><br />
    <!-- Status Cards -->
    <div class="cards">
      <div class="card"><h2><?php $sql = "select count(PetID) as total_pets from Pets";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_pets']; ?></h2><p>🐾Total Pets</p></div>
      <div class="card"><h2><?php $sql = "select count(FosterID) as total_foster from foster";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_foster']; ?></h2><p>🏠Adopted Total</p></div>
      <div class="card"><h2><?php $sql = "select count(ApplicationID) as total_application from adoption_application where Status='Pending'";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_application']; ?></h2><p>📄Pending Applications</p></div>
      <div class="card"><h2><?php $sql = "select count(RecordID) as total_medicalrecords from medicalrecord";
                            $result = $conn->query($sql); $total = $result->fetch_assoc(); echo $total['total_medicalrecords']; ?></h2><p>Medical Records</p></div>
    </div>

    <!-- Tables -->
    <div class="tables">
      <div class="table-card"><br>
        <center>
		    <h3>Pending Applications</h3>
        </center>
		<table>
          <tr><th><center>Application ID</center></th><th><center>Date Applied</center></th><th><center>Pet ID</center></th><th><center>Adopter ID</center></th></tr>
		  <?php 
		    $var = "select * from adoption_application where Status='Pending'";
			$feedback = $conn->query($var); 
			while($total = $feedback->fetch_assoc()){
				?>
			        <tr><td><center><?php echo $total["ApplicationID"]?></center></td><td><center><?php echo $total["DateApplied"]?></center></td>
					<td><center><?php echo $total["PetID"]?></center></td><td><center><?php echo $total["AdopterID"]?></center></td></tr>	
				<?php
			}
		  ?>
        </table>
      </div>
      <div class="table-card"><br>
        <center>
		    <h3>Approved Applications</h3>
        </center>
		<table>
          <tr><th><center>Application ID</center></th><th><center>Date Applied</center></th><th><center>Pet ID</center></th><th><center>Adopter ID</center></th></tr>
		  <?php 
		    $var = "select * from adoption_application where Status='Approved'";
			$feedback = $conn->query($var); 
			while($total = $feedback->fetch_assoc()){
				?>
			        <tr><td><center><?php echo $total["ApplicationID"]?></center></td><td><center><?php echo $total["DateApplied"]?></center></td><td><center><?php echo $total["PetID"]?></center></td>
					<td><center><?php echo $total["AdopterID"]?></center></td></tr>	
				<?php
			}
		  ?>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
