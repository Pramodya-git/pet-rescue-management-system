<?php
session_start();

$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
if(isset($_POST['submit-application'])){
	$Applied_Date = $_POST["DateApplied"];
	$Application_Status = $_POST["Status"];
	$Pet_Type_Preferences = $_POST["Preferences"];
	$Pet_ID = $_POST["PetID"];
	$Adopter_ID = $_POST["AdopterID"];
	
	$sql = $conn->query("insert into adoption_application(DateApplied,Status,Preferences,PetID,AdopterID)values('$Applied_Date','$Application_Status','$Pet_Type_Preferences','$Pet_ID','$Adopter_ID')");
	if($sql){
        echo "<script>alert('Adotion Application Submit Successfully!');
                      window.location='client.php';
	          </script>";

	}else{
		echo "<script>alert('Adotion Application Submit Unsuccessfully!');
		               window.location='adopting_application.php';
		      </script>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adoption Application Form</title>
<link rel="stylesheet" type="text/css" href="adopting_application.css"/>
</head>
<body>

<div class="container">
    <h2>Adoption Application</h2>
    <form action="adopting_application.php" method="POST">
        <div>
            <label for="DateApplied">Date Applied</label>
            <input type="date" id="DateApplied" name="DateApplied" required>
        </div>
        <div>
            <label for="Status">Status</label>
            <select id="Status" name="Status" required>
                <option value="">Select Status</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div>
            <label for="Preferences">Preferences</label>
            <input type="text" id="Preferences" name="Preferences" placeholder="Pet type preference" required>
        </div>
        <div>
            <label for="PetID">Pet ID</label>
            <input type="text" id="PetID" name="PetID" placeholder="<?php echo $PetID = $_POST['PetID']?>" required>
        </div>
        <div>
            <label for="AdopterID">Adopter ID</label>
            <input type="text" id="AdopterID" name="AdopterID" placeholder="<?php echo $_SESSION["user"]["UserID"]?>" required>
        </div>
        <input type="submit" value="Submit Application" name="submit-application">
    </form>
</div>

</body>
</html>
