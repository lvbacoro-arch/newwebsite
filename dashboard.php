<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }

        /* Background (choose one) */
        body {
            background-image: url('nvidia-geforce-rtx-4090-gpu.png'); /* image */
            background-size: cover;
            background-position: center;
        }

        .message {
            margin-top: 20%;
            background: rgba(0,0,0,0.6);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Uncomment this if you want video background -->
    <!--
    <video autoplay muted loop class="video-bg">
        <source src="videos/background.mp4" type="video/mp4">
    </video>
    -->

    <div class="message">
        <?php echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "!"; ?>
    </div>
</body>
</html>
