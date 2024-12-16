<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email=? AND password=?";
        $md5_pass = md5($password);

        $statement = $conn->prepare($sql);
        $statement->bind_param("ss", $email, $md5_pass);
        $statement->execute();

        $result = $statement->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // User exists, set session variables
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];

            echo "<script>
                window.location = 'index.php?page=dashboard';
            </script>";
        } else {
            // User not found or password incorrect
            echo "<script>
                window.location = 'index.php?page=login&notif=1';
            </script>";
        }

        $statement->close();
    } else {
        echo "<script>
            window.location = 'index.php?page=login&notif=1';
        </script>";
    }
}
?>