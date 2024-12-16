<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>

<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
echo "<script>
    window.location = 'index.php?page=login&notif=loggedout';
</script>";
?>