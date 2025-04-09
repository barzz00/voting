<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['schoolID']) || empty($_SESSION['schoolID'])) {
    die("Error: No schoolID found in session. Please log in.");
}

$session_id = $_SESSION['schoolID'];
?>
