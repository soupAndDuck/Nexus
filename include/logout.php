<?php
include 'admin-db.php';
session_start();
if (isset($_SESSION["admin"])) {
    $username = $_SESSION["admin"];
    // Make user offline
    $updateStatusStmt = "UPDATE credentials SET status=0 WHERE username='$username'";
    mysqli_query($conn, $updateStatusStmt);

    echo '<script>
    localStorage.clear();
    window.location.href="../admin/admin-login.php";
    </script>';
} 
session_unset();
session_destroy();

header("Location: ../admin/admin-login.php");
exit();
?>