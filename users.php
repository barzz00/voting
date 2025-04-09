<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SVS</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

  
    <style>
      .headerFont{
        font-family: 'Ubuntu', sans-serif;
        font-size: 24px;
      }

      .subFont{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
        
      }
      
      .specialHead{
        font-family: 'Oswald', sans-serif;
      }

      .normalFont{
        font-family: 'Roboto Condensed', sans-serif;
      }

      .navbar {
      background-color: #424b8c !important;
      border: none;
      padding: 0 20px;
    }

    .navbar .container-fluid {
      padding: 0;
    }

    .navbar-header {
      display: flex;
      align-items: center;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      color: white !important;
      font-family: 'Oswald', sans-serif;
      font-size: 18px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .navbar-brand img {
      margin-right: 10px;
      width: 50px;
      height: 50px;
    }

    .navbar-nav {
      margin-right: 20px;
    }

    .navbar-nav > li > a {
      color: white !important;
      font-weight: bold;
      padding: 15px 12px;
    }

    .navbar-toggle .icon-bar {
      background-color: white;
    }

    .navbar-btn {
      margin-left: 10px;
      margin-right: 0;
    }

    /* Form and container */
    .login-form {
      padding-top: 100px;
      padding-bottom: 40px;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive fixes */
    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 14px;
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar-brand img {
        width: 40px;
        height: 40px;
      }

      .navbar-nav {
        text-align: center;
      }

      .navbar-nav > li {
        margin: 10px 0;
      }
    }
    </style>

  </head>
  <body>
	
	<div class="container">
  	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse
    " role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a href="cpanel.php" class="navbar-brand headerFont text-lg">SIS Voting System In College Department</a>
        </div>

      </div> <!-- end of container -->
    </nav>

    
    <div class="container" style="padding-top:70px;">
    <h4 class="text-center">Displaying Top 30 Voters</h4>
    <div class="row">
      
      <div class="col-sm-12">
        <table class="table table-bordered table-hover">
          <tr>
            <th><strong>Voter's Full Name</strong></th>
            <th><strong>Full Name</strong></th>
            <th><strong>Phone</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Course</strong></th>
            <th><strong>Year</strong></th>
            <th><strong>Status</strong></th>
          </tr>

          <?php
require('config.php');

// Establish Connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Fetch all voters
$query = "SELECT schoolID, full_name, phone, email, course, status, year FROM db_evoting.login";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Escape output to prevent XSS attacks
        $schoolID = htmlspecialchars($row['schoolID']);
        $full_name = htmlspecialchars($row['full_name']);
        $phone = htmlspecialchars($row['phone']);
        $email = htmlspecialchars($row['email']);
        $course = htmlspecialchars($row['course']);
        $year = htmlspecialchars($row['year']);
        $status = htmlspecialchars($row['status']);


        echo "
            <tr>
                <td>$schoolID</td>
                <td>$full_name</td>
                <td>$phone</td>
                <td>$email</td>
                <td>$course</td>
                <td>$year</td>
                <td>$status</td>
            </tr>   
        ";
    }
} else {
    echo "<tr><td colspan='3'>No voters found</td></tr>";
}

// Close connection
mysqli_close($conn);
?>


        </table>
      </div>
    </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>