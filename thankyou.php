<?php 
include('config.php');
?>
<link rel="stylesheet" type="text/css" href="admin/css/style.css" />

<script type="text/javascript">
    $(document).ready(function() {
        var delay = 3000; // 3-second delay before redirect
        setTimeout(function() { 
            window.location = 'index.php';
        }, delay);  
    });
</script>

</head>
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand">
                <img src="admin/images/chmsc.png" width="60" height="60">
            </a>
            <a class="brand">
                <h2>CHMSC Laboratory School Voting System</h2>
                <div class="chmsc_nav">
                    <font size="4" color="white">Carlos Hilado Memorial State College</font>
                </div>
            </a>
            
        </div>
    </div>
</div>

<div class="wrapper">
    <?php 
    // Fetch voter's name
    $result = mysqli_query($conn, "SELECT * FROM login WHERE full_name='$full_name'") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    ?>

    <div class="thank_you">
        <div class="thank">
            <h2><font size="6" color="white">Thank You For Voting, <?php echo htmlspecialchars($row['full_name']); ?>!</font></h2>
        </div>
    </div>
</div>

<?php session_destroy(); ?>

</body>
</html>
