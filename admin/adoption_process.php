<?php
$application_id = isset($_GET['id']) ? $_GET['id'] : '';


$conn = new mysqli("localhost","root","","petrescueandrehome_db");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

if(isset($_POST['submit'])){
	$payment = $_POST['Payment'];
	$adoptionDate = $_POST['AdoptionDate'];
	$meeting_Date = $_POST['Meeting_Date'];
	$approval_Status = $_POST['Approval_Status'];
	$applicationID = $_POST['ApplicationID'];
	
	$sql="insert into Adoption_Process(Payment,AdoptionDate,Meeting_Date,Approval_Status,ApplicationID)values('$payment','$adoptionDate','$meeting_Date','$approval_Status','$applicationID')";
	$result = $conn->query($sql);
	if($result){
		echo "<script>alert('Adoption Process Successfully!');
		      window.location='adoption_management.php';
			  </script>";
	}else{
		echo "<script>alert('Adoption Process Unsuccessfully!');
			  </script>";
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adoption Process Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
	  overflow:hidden;
    }
    form {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
      width: 350px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    #btn{
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }
    #btn:hover {
      background: #218838;
    }
  </style>
</head>
<body>

  <form action="adoption_process.php" method="POST">
    <h2>Adoption Process</h2>

    <label for="payment">Payment Amount:</label>
    <input type="number" id="payment" name="Payment" required>

    <label for="adoption_date">Adoption Date:</label>
    <input type="date" id="adoption_date" name="AdoptionDate" required>

    <label for="meeting_date">Meeting Date:</label>
    <input type="date" id="meeting_date" name="Meeting_Date" required>

    <label for="approval">Approval Status:</label>
    <select id="approval" name="Approval_Status" required>
      <option value="">-- Select Status --</option>
      <option value="Pending">Pending</option>
      <option value="Approved">Approved</option>
      <option value="Rejected">Rejected</option>
    </select>

    <label for="application_id">Application ID:</label>
    <input type="number" id="application_id" name="ApplicationID" placeholder="<?php echo $application_id ?>"required>

    <input type="submit" name="submit" id="btn">
  </form>

</body>
</html>
