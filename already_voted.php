<?php
session_start();

include "config.php";

$full_name = '';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; 

    $query = "SELECT full_name FROM `login` WHERE `full_name` = '$full_name'";
    $result = mysqli_query($conn, $query);


    if ($result && mysqli_num_rows($result) > 0) {
       
        $user_data = mysqli_fetch_assoc($result);
        $full_name = $user_data['full_name'];
    } else {
       
        $full_name = 'Guest';
    }
} else {

    $full_name = 'Guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Voting</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank You for Voting, <?php echo htmlspecialchars($full_name); ?>!
    <br>Your vote has been successfully recorded.</h1>
    
   
</body>

</html>
