<?php
require_once '../config.php';

// Cek login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);

    // Get file path before delete
    $result = mysqli_query($conn, "SELECT file_url, category FROM portfolio WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);

    // Delete file if it's a photo (not YouTube link)
    if ($row['category'] == 'foto' && file_exists('../' . $row['file_url'])) {
        unlink('../' . $row['file_url']);
    }

    mysqli_query($conn, "DELETE FROM portfolio WHERE id='$id'");
    header('Location: manage_portfolio.php?success=deleted');
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_portfolio'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';

    if ($category == 'video') {
        // For video, just save YouTube URL
        $file_url = mysqli_real_escape_string($conn, $_POST['video_url']);
        $thumbnail = '';

        // Extract YouTube ID for thumbnail
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $file_url, $matches);
        if (isset($matches[1])) {
            $thumbnail = 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        }
    } else {
        // For photo, handle file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['photo']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $new_filename = uniqid() . '.' . $ext;
                $upload_path = '../uploads/portfolio/' . $new_filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                    $file_url = 'uploads/portfolio/' . $new_filename;
                    $thumbnail = $file_url;
                } else {
                    $error = 'Failed to upload file';
                }
            } else {
                $error = 'Invalid file type. Only JPG, PNG, GIF allowed.';
            }
        } elseif ($id) {
            // If editing and no new file, keep old file
            $result = mysqli_query($conn, "SELECT file_url, thumbnail FROM portfolio WHERE id='$id'");
            $row = mysqli_fetch_assoc($result);
            $file_url = $row['file_url'];
            $thumbnail = $row['thumbnail'];
        } else {
            $error = 'Please upload a photo';
        }
    }

    if (!isset($error)) {
        if ($id) {
            // Update
            $sql = "UPDATE portfolio SET 
                    title='$title', 
                    category='$category', 
                    description='$description', 
                    file_url='$file_url', 
                    thumbnail='$thumbnail' 
                    WHERE id='$id'";
        } else {
            // Insert
            $sql = "INSERT INTO portfolio (title, category, description, file_url, thumbnail) 
                    VALUES ('$title', '$category', '$description', '$file_url', '$thumbnail')";
        }

        if (mysqli_query($conn, $sql)) {
            header('Location: manage_portfolio.php?success=saved');
            exit;
        } else {
            $error = 'Database error: ' . mysqli_error($conn);
        }
    }
}

// Get portfolio items
$portfolio_items = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY created_at DESC");

// Get item for edit
$edit_item = null;
if (isset($_GET['edit'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM portfolio WHERE id='$edit_id'");
    $edit_item = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio - ARS Visual</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 24px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar .logout-btn {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            text-align: center;
            border-radius: 8px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-add {
            background: #667eea;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-add:hover {
            background: #5568d3;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Form Section */
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-section h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input[type="file"] {
            padding: 8px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-submit {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #5568d3;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            margin-left: 10px;
            display: inline-block;
        }

        /* Portfolio Grid */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .portfolio-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .portfolio-card:hover {
            transform: translateY(-5px);
        }

        .portfolio-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .portfolio-card-content {
            padding: 15px;
        }

        .portfolio-card-content h3 {
            color: #333;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .portfolio-card-content p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .category-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .category-badge.foto {
            background: #d1ecf1;
            color: #0c5460;
        }

        .category-badge.video {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-edit {
            flex: 1;
            background: #667eea;
            color: white;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-delete {
            flex: 1;
            background: #e74c3c;
            color: white;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        #video-url-group {
            display: none;
        }

        #photo-group {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>🎥 ARS Visual</h2>
            <ul>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="manage_portfolio.php" class="active">🖼️ Portfolio</a></li>
                <li><a href="manage_messages.php">💬 Messages</a></li>
                <li><a href="manage_testimonials.php">⭐ Testimonials</a></li>
                <li><a href="../index.php" target="_blank">🌐 View Website</a></li>
            </ul>
            <div class="logout-btn">
                <a href="logout.php" style="color:white; text-decoration:none;">🚪 Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Manage Portfolio</h1>
                <a href="?add=new" class="btn-add">+ Add New Item</a>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    if ($_GET['success'] == 'saved') echo 'Portfolio item saved successfully!';
                    if ($_GET['success'] == 'deleted') echo 'Portfolio item deleted successfully!';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Add/Edit Form -->
            <?php if (isset($_GET['add']) || isset($_GET['edit'])): ?>
                <div class="form-section">
                    <h2><?php echo isset($_GET['edit']) ? 'Edit' : 'Add New'; ?> Portfolio Item</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <?php if ($edit_item): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                        <?php endif; ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Title *</label>
                                <input type="text" name="title" required
                                    value="<?php echo $edit_item ? htmlspecialchars($edit_item['title']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label>Category *</label>
                                <select name="category" id="category" required onchange="toggleCategoryFields()">
                                    <option value="foto" <?php echo ($edit_item && $edit_item['category'] == 'foto') ? 'selected' : ''; ?>>Photo</option>
                                    <option value="video" <?php echo ($edit_item && $edit_item['category'] == 'video') ? 'selected' : ''; ?>>Video</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"><?php echo $edit_item ? htmlspecialchars($edit_item['description']) : ''; ?></textarea>
                        </div>

                        <div class="form-group" id="photo-group">
                            <label>Upload Photo <?php echo $edit_item ? '(leave empty to keep current)' : '*'; ?></label>
                            <input type="file" name="photo" accept="image/*" <?php echo $edit_item ? '' : 'required'; ?>>
                            <?php if ($edit_item && $edit_item['category'] == 'foto'): ?>
                                <small style="color:#666;">Current: <?php echo basename($edit_item['file_url']); ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group" id="video-url-group">
                            <label>YouTube URL *</label>
                            <input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                value="<?php echo ($edit_item && $edit_item['category'] == 'video') ? htmlspecialchars($edit_item['file_url']) : ''; ?>">
                            <small style="color:#666;">Example: https://www.youtube.com/watch?v=rbftAwpr2-U</small>
                        </div>

                        <div>
                            <button type="submit" name="save_portfolio" class="btn-submit">
                                <?php echo isset($_GET['edit']) ? 'Update' : 'Save'; ?> Portfolio
                            </button>
                            <a href="manage_portfolio.php" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Portfolio Grid -->
            <div class="portfolio-grid">
                <?php if (mysqli_num_rows($portfolio_items) > 0): ?>
                    <?php while ($item = mysqli_fetch_assoc($portfolio_items)): ?>
                        <div class="portfolio-card">
                            <img src="../<?php echo $item['thumbnail'] ?: $item['file_url']; ?>"
                                alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <div class="portfolio-card-content">
                                <span class="category-badge <?php echo $item['category']; ?>">
                                    <?php echo ucfirst($item['category']); ?>
                                </span>
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($item['description'], 0, 80)); ?>...</p>
                                <div class="action-buttons">
                                    <a href="?edit=<?php echo $item['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="?delete=<?php echo $item['id']; ?>" class="btn-delete"
                                        onclick="return confirm('Delete this item?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center; color:#999; padding:40px; grid-column: 1/-1;">
                        No portfolio items yet. Click "Add New Item" to start.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleCategoryFields() {
            const category = document.getElementById('category').value;
            const photoGroup = document.getElementById('photo-group');
            const videoGroup = document.getElementById('video-url-group');
            const photoInput = photoGroup.querySelector('input');
            const videoInput = videoGroup.querySelector('input');

            if (category === 'video') {
                photoGroup.style.display = 'none';
                videoGroup.style.display = 'block';
                photoInput.removeAttribute('required');
                videoInput.setAttribute('required', 'required');
            } else {
                photoGroup.style.display = 'block';
                videoGroup.style.display = 'none';
                videoInput.removeAttribute('required');
                <?php if (!$edit_item): ?>
                    photoInput.setAttribute('required', 'required');
                <?php endif; ?>
            }
        }

        // Run on page load
        toggleCategoryFields();
    </script>
</body>

</html>