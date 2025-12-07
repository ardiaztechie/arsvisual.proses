<?php
include "../config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $file_url = $_POST['file_url'];

    $thumb = null;

    if (!empty($_FILES['thumbnail']['name'])) {
        $thumb = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../uploads/portfolio/" . $thumb);
    }

    $sql = "INSERT INTO portfolio (title, category, description, thumbnail, file_url) 
            VALUES ('$title','$category','$description','$thumb','$file_url')";

    mysqli_query($conn, $sql);

    $success = "Portfolio berhasil ditambahkan!";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Portfolio</title>
</head>

<body>

    <h2>Tambah Portfolio</h2>

    <?php if (!empty($success)) echo "<p style='color:green'>$success</p>"; ?>

    <form method="POST" enctype="multipart/form-data">

        Judul:<br>
        <input type="text" name="title" required><br><br>

        Kategori:<br>
        <select name="category">
            <option value="foto">Foto</option>
            <option value="video">Video</option>
        </select><br><br>

        Deskripsi:<br>
        <textarea name="description"></textarea><br><br>

        Thumbnail:<br>
        <input type="file" name="thumbnail"><br><br>

        Link File / YouTube:<br>
        <input type="text" name="file_url"><br><br>

        <button name="submit">Publish</button>

    </form>

</body>

</html>