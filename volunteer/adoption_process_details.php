<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adoption Process Entry</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }
    form {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      width: 350px;
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      margin-top: 15px;
      padding: 10px;
      width: 100%;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
    }
    table {
      margin-top: 30px;
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #007bff;
      color: white;
    }
  </style>
</head>
<body>
  <h2>Adoption Process Records</h2>
  <table>
    <thead>
      <tr>
        <th>AdoptionID</th>
        <th>Payment</th>
        <th>Adoption Date</th>
        <th>Meeting Date</th>
        <th>Approval Status</th>
        <th>ApplicationID</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Connect to database
      $conn = new mysqli("localhost", "root", "", "petrescueandrehome_db");
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $Applicationid = $_POST["applicationid"];
      $sql = "SELECT * FROM Adoption_Process where ApplicationID='$Applicationid'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".$row['AdoptionID']."</td>
                      <td>".$row['Payment']."</td>
                      <td>".$row['AdoptionDate']."</td>
                      <td>".$row['Meeting_Date']."</td>
                      <td>".$row['Approval_Status']."</td>
                      <td>".$row['ApplicationID']."</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No records found</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>

</body>
</html>
