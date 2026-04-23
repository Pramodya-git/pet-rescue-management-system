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

$Client_pet_search = isset($_POST["C_P_Search"]) ? $_POST["C_P_Search"] : '' ;
//add notification for notification table
if(isset($_POST['send'])){
    $text = $_POST['message'];
    $sender_id = $_SESSION["user"]["UserID"];
    //$file_name = null;

    $file_name = $_FILES['photo']['name'];
	$tempname = $_FILES['photo']['tmp_name'];
	$folder = '../admin/Client Sending Photos/'.$file_name;
	
            $query = mysqli_query($conn,"insert into notifications (message,photo,SenderID) values ('$text', '$file_name','$sender_id')");
	        if (move_uploaded_file($tempname,$folder)){
	    	    echo "<script>
	    	            alert('Message Sent Successfully!');
	    	          </script>";
	        }else{
	    	    echo "<script>
	    	               alert('Message Not Sent!');
	    	          </script>";
	             }	
}else if(isset($_POST['delete'])){
	$application_ID = $_POST['ApplicationID'];
    $sql = "select * from adoption_application where ApplicationID='$application_ID'";
    $result = $conn->query($sql);
   	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResQPet & Adoption - Find Your Perfect Companion</title>
       <link rel="stylesheet" href="css_public.css">
	   <style>
	        /* Pet Table Styling */
            .admin-table-container {
                width: 100%;
                overflow-x: auto;
                margin-top: 2rem;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
                background-color: white;
                padding: 1rem;
            }
            
            .admin-table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .admin-table th,
            .admin-table td {
                padding: 12px 15px;
                text-align: center;
                border-bottom: 1px solid #e9ecef;
                font-size: 1rem;
            }
            
            .admin-table th {
                background-color: #667eea;
                color: white;
                font-weight: 600;
                border-radius: 10px 10px 0 0; /* Rounded top corners for header */
            }
            
            .admin-table tbody tr:nth-child(even) {
                background-color: #f8f9fa; /* striped rows */
            }
            
            .admin-table tbody tr:hover {
                background-color: #e2e8f0;
                transform: scale(1.01);
                transition: all 0.2s ease-in-out;
            }
            
            .admin-table img {
                border-radius: 50%; /* circular pet images */
                width: 60px;
                height: 60px;
                object-fit: cover;
            }
            
            .client-pet-search-btn {
                padding: 0.5rem 1rem;
                background-color: #667eea;
                color: white;
                border: none;
                border-radius: 50px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .client-pet-search-btn:hover {
                background-color: #5a67d8;
                transform: translateY(-2px);
            }
			.notification {
               background: #f9fafb;
               border-radius: 12px;
               box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
               padding: 2rem;
               max-width: 2000px;
               margin:5px;
               //text-align: center;
			   
            
            
            .notification label {
               font-size:10rem;
               font-weight: 600;
               color: #374151;
               display: block;
               margin-bottom: 0.8rem;
            
            
            .notification textarea {
               width: 100%;
               padding: 12px 15px;
               border: 1.5px solid #d1d5db;
               border-radius: 10px;
               font-size: 1rem;
               font-family: Arial, sans-serif;
               resize: none;
               outline: none;
               transition: border 0.3s ease, box-shadow 0.3s ease;
            
            
            .notification textarea:focus {
               border-color: #667eea;
               box-shadow: 0 0 8px rgba(102, 126, 234, 0.3);
            
            
            .notification input[type="submit"] {
               margin-top: 1rem;
               padding: 0.6rem 1.5rem;
               background-color: #667eea;
               border: none;
               border-radius: 50px;
               color: white;
               font-size: 1rem;
               font-weight: 600;
               cursor: pointer;
               transition: all 0.3s ease;
            
            
            .notification input[type="submit"]:hover {
               background-color: #5a67d8;
               transform: translateY(-2px);
            
	   </style>
  </head>
<body class="public-layout">
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-brand">
                    <i class="fas fa-paw"></i>
                    <span><image src="logo_icons\paw1.png" width="30" height="30">   ResQPet</span>
                </div>  
                <div class="nav-menu">
                    <a href="#home" class="nav-link">Home</a>
                    <a href="#pets" class="nav-link">Adopting</a>
					<a href="#notifi" class="nav-link">Notification for Rescue</a>
					<a href="#about" class="nav-link">About</a>
                    <a href="#contact" class="nav-link">Contact</a>
                    <a href="#" class="nav-link"><?php echo $_SESSION["user"]["Role"]." : ".$_SESSION["user"]["User_Name"]  ?></a>
					<a href="../logout.php" style="color:black; font-weight:bold; text-decoration:none;">Log Out</a>
                </div>
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </nav>
    </header>

 <!-- Hero Section -->
    <section id="home" class="hero">
        
           <h1>Find Your Perfect Companion</h1>
           <p>Every pet deserves a loving home. Browse our adoptable pets and make a difference today.</p>
           <a class="cta-button" href="#pets" style="text-decoration:none;">Start Adopting</a>
        <div class="hero-image">  
            <i class="fas fa-dog hero-icon"></i>
        </div>

        </div>

	
    </section>
  <!-- Search and Filter Section -->
  <section id="pets" class="pets-section">
    <div class="container">
      <h2>Available Pets</h2>
      <div class="search-filter-container">
        <div class="search-bar">
          <i class="fas fa-search"></i>
		  <form method="POST" action="volunteer.php#pets">
          <input type="text" placeholder="Search by pet type,breed..." name="C_P_Search"><br><br>
		  <input type="Submit" Value="Search" class="client-pet-search-btn" name="client-pet-search">
		  </form>
        </div>
      </div><br><br>
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
                        if($Client_pet_search){
							$rch = "select * from Pets where Pet_Type='$Client_pet_search' or Bread='$Client_pet_search'";
							$resc =  $conn->query($rch);
									if($resc->num_rows > 0){
										while($ret = $resc->fetch_assoc()){
												?>
												<tr>
						                              <td><center><img src="../admin/Test Image/<?php echo htmlspecialchars($ret["photo"]) ?>" style="width:70px;"></center></td>
							                          <td><center><?php echo $ret["Pet_Type"] ?></center></td>
							                          <td><center><?php echo $ret["Bread"] ?></center></td>
							                          <td><center><?php echo $ret["Age"] ?></center></td>
							                          <td><center><?php echo $ret["Status"] ?></center></td>
							                          <td><center><?php echo $ret["Gender"] ?></center></td>
							                          <td><center>
																<form method="POST" action="adopting_application.php" style="display:inline;">
																	<input type="hidden" name="PetID" value="<?php echo $ret['PetID']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Adopting Application <?php echo $ret['PetID']; ?>">&nbsp;&nbsp;&nbsp;
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
	</div><br><br><br>
	<!--Application Approved table-->
	<div class="admin-table-container">
	<h2>Application Approved Status Section</h2><br>
	            <table class="admin-table">
                    <thead>
                        <tr>
                            <th><center>Application ID </center></th>
                            <th><center>Applied Date</center></th>
                            <th><center>Status</center></th>
                            <th><center>Preferences</center></th>
                            <th><center>Pet ID</center></th>
                            <th><center>Adopter ID</center></th>
                            <th><center>Actions</center></th>
                        </tr>
                    </thead>
	                <tbody id="admin-pets-table" style="height:150px; overflow-y:auto; overflow-x:hidden;">
	                    <?php                   
                        //Search bar variable
						    $ClientID = $_SESSION["user"]["UserID"];
							$rch = "select * from adoption_application where AdopterID='$ClientID'";
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
							                          <td><center><?php echo $ret["AdopterID"] ?></center></td>
							                          <td><center>
																<form method="POST" action="adoption_process_details.php" style="display:inline;">
																	<input type="hidden" name="applicationid" value="<?php echo $ret['ApplicationID']; ?>">
																    <input type="submit" name="delete" style="padding:4px;background-color:#60a5fa;border-color:#60a5fa;border-radius:10px;" value="Adoption Process <?php echo $ret['ApplicationID']; ?>">&nbsp;&nbsp;&nbsp;
															    </form>															
							                              </center>
							                          </td>
						                        </tr>
												<?php
										}
									}else{
										echo "<script>document.getElementById('admin-pet-search').style.borderColor='red';</script>";
									}
                                
                                                 ?>	
                    </tbody>
                </table>
	</div>
   <!--Pet Rescue Inform Section-->
   <section id="notifi" class="pets-rescue-section"><br>
      <br><br><br>
	  <h2>Pet Rescue Inform Section</h2>
      <div class="notification">
         <form  method="POST" action="volunteer.php" enctype="multipart/form-data">
             <label for="message"><h3>Your Message:</h3></label><br>
             <textarea id="message" name="message" rows="10" cols="145" placeholder="Type your message here..." Required></textarea>
		     <br>
			 <label for="photo">Photo</label>	
		     <input type="file" name="photo" id="photo" Required>
		     <br><br>
             <input type="submit" value="Send" name="send" style="color:black;font-size:15px;padding:10px 25px;background-color:#667eea;border:none;border-radius:25px;cursor:pointer;min-width:120px;">
	     </form>
 	  </div>
   </section><br><br><br>
     </section>   
    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2>About ResQPet</h2>
            <div class="about-grid">
                <div class="about-card">
                    <image src="logo_icons\heart.png" width="50" height="50">
                    <h3>Our Mission</h3>
                    <p>We're dedicated to finding loving homes for every pet in our care while promoting responsible pet ownership.</p>
                </div>
                <div class="about-card">
                   <image src="logo_icons\silhouette.png" width="50" height="50">
                    <h3>Our Team</h3>
                    <p>Our passionate staff and volunteers work tirelessly to ensure each pet receives the care and attention they deserve.</p>
                </div>
                <div class="about-card">
                    <image src="logo_icons\home.png" width="50" height="50">
                    <h3>Success Stories</h3>
                    <p>Over 5,000 pets have found their forever homes through our adoption program since 2015.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-item">
                        <div>
				
                            <h4> <div> <image src="logo_icons\address.png" width="20" height="20">  Visit Us</h4>
                            <p>123 Pet Adoption Lane<br>Cityville, ST 12345</p>
				
                        </div>
                    </div>

                    <div class="contact-item">
                         <div> 
                            <h4> <image src="logo_icons\call.png" width="20" height="20"> Call Us</h4>
                            <p>(555) 123-PETS</p>
                        </div>
                    </div>

                    <div class="contact-item">
                         
                        <div>
                            <h4><image src="logo_icons\mail-inbox-app.png" width="22" height="22">  Email Us</h4>
                            <p>info@ResQPet&adoption.org</p>
                        </div>
                    </div>

                    <div class="contact-item">
                         <div>
                            <h4><image src="logo_icons\clock.png" width="20" height="20">  Hours</h4>
                            <p>Mon-Fri: 9AM-6PM<br>Sat-Sun: 10AM-4PM</p>
                        </div>
                    </div>
                </div>
                         </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>ResQPet</h4>
                    <p>Connecting loving families with pets in need since 2015.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"><image src="logo_icons\facebook.png" width="18" height="18"></i></a>
                        <a href="#"><image src="logo_icons\twitter2.png" width="18" height="18"></a>
                        <a href="#"><image src="logo_icons\instagram1.png" width="18" height="18"></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#pets">Adopt a Pet</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#">Volunteer</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Donation</a></li>
                        <li><a href="#">Foster Program</a></li>
                        <li><a href="#">Pet Care Tips</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ResQPet. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
