<?php
session_start();
require_once('config.php');

if (isset($_POST["insertvoter"])) {
    
    $schoolID = (int)$_POST["schoolID"];  // Cast to int for database compatibility
    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];
    $course = $_POST["course"];
    $year = $_POST["year"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user already exists by schoolID
    $check_query = $conn->prepare("SELECT * FROM login WHERE schoolID = ?");
    $check_query->bind_param("i", $schoolID); // Use "i" for integer
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('User with this ID Number already exists!');</script>";
    } else {
        // Insert into DB (no OTP)
        $status = 'unvoted';

        // Debugging: Ensure all values are correct before binding
        echo "Full Name: $full_name, Phone: $phone, Course: $course, Year: $year, Email: $email, Password: $password, Status: $status";

        // Updated insert query, excluding OTP and verified fields
        $insert_query = $conn->prepare("INSERT INTO login (schoolID, full_name, phone, course, year, email, password, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("isssssss", $schoolID, $full_name, $phone, $course, $year, $email, $password, $status);


        if ($insert_query->execute()) {
            echo "<script>alert('Data has been stored successfully.'); window.location='cpanel.php';</script>";
            exit();
        } else {
            die("Insert failed: " . $insert_query->error);
        }
    }
}



?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Insert Voter</title>


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <style>

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

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="cpanel.php">
        <img src="images/sis.png" alt="SIS Logo">
        SIS Voting System in College Department
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="insertvoter.php"><strong>Add Voters</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="users.php"><strong>Voters</strong></a></li>
          <li class="nav-item"><a class="nav-link" href="feedbackReport.php"><strong>Feedback Report</strong></a></li>
          <li class="nav-item">
            <a class="btn btn-danger navbar-btn" href="login.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Insert Voter Form -->
  <main class="login-form">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <form action="insertvoter.php" method="POST">
                <div class="form-group row">
                  <label for="schoolID" class="col-md-4 col-form-label text-md-right">School ID</label>
                  <div class="col-md-6">
                    <input type="text" id="schoolId" class="form-control" name="schoolID" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="full_name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                  <div class="col-md-6">
                    <input type="text" id="full_name" class="form-control" name="full_name" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                  <div class="col-md-6">
                    <input type="text" id="phone" class="form-control" name="phone" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="course" class="col-md-4 col-form-label text-md-right">Course</label>
                  <div class="col-md-6">
                    <input type="text" id="course" class="form-control" name="course" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="year" class="col-md-4 col-form-label text-md-right">Year</label>
                  <div class="col-md-6">
                    <input type="text" id="year" class="form-control" name="year" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                  <div class="col-md-6">
                    <input type="email" id="email" class="form-control" name="email" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                  <div class="col-md-6">
                    <input type="password" id="password" class="form-control" name="password" required>
                  </div>
                </div>

                <div class="col-md-6 offset-md-4">
                  <input type="submit" value="Insert Voter" name="insertvoter" class="btn btn-primary">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
