<?php
require_once '../config.php';

// File ini hanya untuk membuat admin pertama kali
// Setelah admin dibuat, HAPUS atau DISABLE file ini!

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah email sudah ada
    $check = mysqli_query($conn, "SELECT id FROM admins WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = 'Email sudah terdaftar!';
    } else {
        $sql = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Admin berhasil dibuat! Silakan login.';
        } else {
            $error = 'Gagal membuat admin: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - ARS Visual</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            border: 1px solid #ffeaa7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: #fee;
            color: #c00;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🎥 Create Admin</h1>

        <div class="warning">
            <strong>⚠️ PENTING:</strong> File ini hanya untuk membuat admin pertama kali. Setelah selesai, hapus atau disable file ini untuk keamanan!
        </div>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required minlength="6">
            </div>
            <button type="submit">Create Admin</button>
        </form>

        <div class="link">
            <a href="login.php">← Kembali ke Login</a>
        </div>
    </div>
</body>

</html>