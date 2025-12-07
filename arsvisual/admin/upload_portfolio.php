<?php
include "../config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['upload'])) {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];

    // Upload gambar
    $file = $_FILES['thumbnail'];
    $name = time() . "_" . $file['name'];
    $path = "../uploads/portfolio/" . $name;

    move_uploaded_file($file['tmp_name'], $path);

    mysqli_query($conn, "INSERT INTO portfolio (title, category, description, thumbnail, file_url)
        VALUES ('$title','$category','$description','$name','$video_url')");

    echo "Upload berhasil!";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title">

    <select name="category">
        <option value="foto">Foto</option>
        <option value="video">Video</option>
    </select>

    <textarea name="description" placeholder="Description"></textarea>

    <input type="text" name="video_url" placeholder="YouTube URL (untuk video)">

    <input type="file" name="thumbnail">

    <button name="upload">Upload</button>
</form>