
<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$name = ($user && isset($user['firstname'])) ? $user['firstname'] : "";
?>


<!DOCTYPE html>
<html lang="en" class="h-full bg-green-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sign Up</title>
</head>

<body class="h-full">
    <!-- Navbar -->
    <nav class="bg-green-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left links -->
            <ul class="flex space-x-4">
                <li>
                    <a href="../signup.php" class="text-white text-sm font-medium hover:text-green-200">Signup</a>
                </li>
                <li>
                    <a href="../login.php" class="text-white text-sm font-medium hover:text-green-200">Login</a>
                </li>
                <li>
                    <a href="../actions/logout.php" class="text-white text-sm font-medium hover:text-green-200">Logout</a>
                </li>
                <li>
                    <a href="../users.php" class="text-white text-sm font-medium hover:text-green-200">Users</a>
                </li>
            </ul>

            <!-- Right greeting -->
            <div class="text-sm text-white">
                <?php if ($name): ?>
                    <span>Hello, <?php echo $name; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>
