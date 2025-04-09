<?php
session_start();
include "config.php";

// Check if user is logged in
if (!isset($_SESSION['schoolID'])) {
    die("Error: No schoolID found in session. Please log in.");
}

$schoolID = $_SESSION['schoolID'];

// Prevent inserting NULL schoolID
if (empty($schoolID)) {
    die("Error: Invalid schoolID. Please log in again.");
}

if (isset($_POST['submit'])) {
    $president = $_POST['president'];
    $vice_pres = $_POST['vice_pres'];
    $secretary = $_POST['secretary'];
    $treasurer = $_POST['treasurer'];
    $auditor = $_POST['auditor'];

    // Prevent duplicate votes
    $checkVote = $conn->prepare("SELECT * FROM score WHERE schoolID = ?");
    $checkVote->bind_param("s", $schoolID);
    $checkVote->execute();
    $result = $checkVote->get_result();

    if ($result->num_rows > 0) {
        die("Error: You have already voted.");
    }

    // Get the current timestamp
    $voteTime = date("Y-m-d H:i:s");  // Format: YYYY-MM-DD HH:MM:SS

    // Save vote to database including timestamp
    $query = "INSERT INTO score (schoolID, president, vice_pres, secretary, treasurer, auditor, vote_time) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameters (now with the correct number)
    $stmt->bind_param("sssssss", $schoolID, $president, $vice_pres, $secretary, $treasurer, $auditor, $voteTime);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    // Prevent re-voting
    $update_query = $conn->prepare("UPDATE login SET status = 0 WHERE schoolID = ?");
    $update_query->bind_param("s", $schoolID);
    $update_query->execute();

    // Set a cookie to remember the vote
    setcookie("voted", "yes", time() + (86400 * 365), "/");

    // Log out user
    session_destroy();

    // Redirect to "already voted" page
    header("Location: already_voted.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SVS - Voting</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="padding-top:150px;">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 text-center" style="border:2px solid gray;padding:50px;">
                <h3>Vote Now</h3>
                <form action="" method="POST">
                    <label>Governor:</label>
                    <select name="president" class="form-control" required>
                        <option value="Nicole Cabiladas">Nicole Cabiladas</option>
                        <option value="Mark Smith">Mark Smith</option>
                    </select>

                    <label>Vice-Governor:</label>
                    <select name="vice_pres" class="form-control" required>
                        <option value="Kyle Alberca">Kyle Alberca</option>
                        <option value="Mark Vincent Lubrino">Mark Vincent Lubrino</option>
                    </select>

                    <label>Secretary:</label>
                    <select name="secretary" class="form-control" required>
                        <option value="Joe Marie Marcelino">Joe Marie Marcelino</option>
                        <option value="Ralph Angelo Pasobillo">Ralph Angelo Pasobillo</option>
                    </select>

                    <label>Treasurer:</label>
                    <select name="treasurer" class="form-control" required>
                        <option value="Kerby Pantuan">Kerby Pantuan</option>
                        <option value="Chrisleen Wilson">Chrisleen Wilson</option>
                    </select>

                    <label>Auditor:</label>
                    <select name="auditor" class="form-control" required>
                        <option value="Ren Landis">Ren Landis</option>
                        <option value="Justin Respecia">Justin Respecia</option>
                    </select>

                    <br>
                    <button type="submit" name="submit" class="btn btn-success">Submit Vote</button>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
