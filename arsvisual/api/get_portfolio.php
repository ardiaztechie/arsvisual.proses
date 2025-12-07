<?php
include "../config.php";

$result = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY id DESC");

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
