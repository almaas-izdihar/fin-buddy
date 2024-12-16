<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $name && $password) {
        // Hash the password
        $md5_pass = md5($password);

        // Prepare SQL to insert new user
        $sql = "INSERT INTO users (email, name, password) VALUES (?, ?, ?)";

        $statement = $conn->prepare($sql);
        $statement->bind_param("sss", $email, $name, $md5_pass);

        if ($statement->execute()) {
            // Registration successful, redirect to login page
            echo "<script>
                window.location = 'index.php?page=login&notif=success';
            </script>";
        } else {
            // Registration failed, redirect back to register page with error
            echo "<script>
                window.location = 'index.php?page=register&notif=error';
            </script>";
        }

        $statement->close();
    } else {
        // Missing fields, redirect back to register page with error
        echo "<script>
            window.location = 'index.php?page=register&notif=missing';
        </script>";
    }
}
?>