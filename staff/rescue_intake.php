<?php
session_start();

$_SESSION["user"] = [ 
    "User_Name" => "TestStaff",
    "Role" => "Staff",
    "Email" => "test@resqpet.com",
    "UserID" => "0002"
];
include('connect.php');

if(isset($_POST['submit']))
{
    $petname      = $_POST['petname'];
    $breed        = $_POST['breed'];
    $pet_type     = $_POST['pet_type'];
    $age          = $_POST['age'];
    $gender       = $_POST['gender'];
    $notes        = $_POST['notes'];
    $healthstatus = $_POST['healthstatus'];
    $rescue_date  = $_POST['date'];
    $location     = $_POST['location'];
    $rescuedby    = $rescuedby = $_SESSION["user"]["UserID"];
    $_SESSION["user"]["UserID"];


    // Generate IDs
    $petid    = "P" . str_pad(rand(1,9999), 4, "0", STR_PAD_LEFT);
    $rescueid = "R" . str_pad(rand(1,9999), 4, "0", STR_PAD_LEFT);

    // Insert into pets
    $query1 = mysqli_query($con,
        "INSERT INTO pets(petid, petname, breed, pet_type, age, gender, rescueid) 
         VALUES('$petid','$petname','$breed','$pet_type','$age','$gender','$rescueid')");
 

    if($query1){
        // Insert into rescue
        $query2 = mysqli_query($con,
            "INSERT INTO rescue(rescueid, petid, notes, healthstatus, rescue_date, location, rescuedby) 
             VALUES('$rescueid','$petid','$notes','$healthstatus','$rescue_date','$location','$rescuedby')");

        if($query2){
            echo "<script>alert('Data inserted Successfully')</script>";
        } else {
            echo "<script>alert('Error inserting rescue')</script>";
        }
    } else {
        echo "<script>alert('Error inserting pet')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rescue Intake</title>
</head>
<body>
<form action="rescue_intake.php" method="post">
  <fieldset>
    <legend>Pet Rescue Information</legend>
    Pet Name: <input type="text" name="petname" required><br><br>
    Breed: <input type="text" name="breed"><br><br>
    Species: <input type="text" name="pet_type" placeholder="example: Bulldog" required><br><br>
    Age: <input type="number" name="age"><br><br>
    Gender:
    <input type="radio" name="gender" value="Female"> Female
    <input type="radio" name="gender" value="Male"> Male<br><br>
    Health Status: <input type="text" name="healthstatus" required><br><br>
    Rescued Date: <input type="date" name="date"><br><br>
    Location Found: <input type="text" name="location"><br><br>
    Notes: <textarea name="notes"></textarea><br><br>
    Rescued By: <input type="text" name="rescuedby"><br><br>
    <input type="submit" name="submit" value="Submit">
  </fieldset>
</form>
</body>
</html>
