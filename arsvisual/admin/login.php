<?php
include "../config.php";

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek akun
    $query = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' LIMIT 1");

    if (!$query) {
        die("Query error: " . mysqli_error($conn));
    }

    $admin = mysqli_fetch_assoc($query);

    if ($admin) {

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Admin</title>
</head>

<body>
    <h2>Login Admin</h2>

    <?php
    if (!empty($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button name="login">Login</button>
    </form>

</body>

</html>