<?php
session_start();
require_once '../config.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil nama admin
$admin_name = $_SESSION['admin_name'];

// Ambil statistik
$stats = [];
$stats['total_messages'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages"))['total'];
$stats['new_messages'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages WHERE status='new'"))['total'];
$stats['total_portfolio'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM portfolio"))['total'];
$stats['total_testimonials'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM testimonials"))['total'];

// Pesan terbaru
$recent_messages = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ARS Visual</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard Admin</h1>
            <div>
                <strong><?php echo htmlspecialchars($admin_name); ?></strong>
                <a href="logout.php" class="btn btn-sm btn-danger ms-2">Logout</a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">New Messages</h5>
                        <p class="card-text fs-3"><?php echo $stats['new_messages']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Messages</h5>
                        <p class="card-text fs-3"><?php echo $stats['total_messages']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Portfolio Items</h5>
                        <p class="card-text fs-3"><?php echo $stats['total_portfolio']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Testimonials</h5>
                        <p class="card-text fs-3"><?php echo $stats['total_testimonials']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="card">
            <div class="card-header">
                Recent Messages
            </div>
            <ul class="list-group list-group-flush">
                <?php if (mysqli_num_rows($recent_messages) > 0): ?>
                    <?php while ($msg = mysqli_fetch_assoc($recent_messages)): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($msg['name']); ?></strong> - <?php echo htmlspecialchars($msg['service']); ?>
                                <br><small class="text-muted"><?php echo date('d M Y', strtotime($msg['created_at'])); ?></small>
                            </div>
                            <span class="badge <?php echo $msg['status'] == 'new' ? 'bg-warning text-dark' : ($msg['status'] == 'read' ? 'bg-success' : 'bg-secondary'); ?>">
                                <?php echo ucfirst($msg['status']); ?>
                            </span>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item text-center text-muted">No messages yet</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>