
<?php
$pageTitle = $pageTitle ?? "Agora E-Commerce";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="main-header">

    <div class="container">

        <a href="index.php" class="logo">
            AGORA
        </a>

        <nav>
            <?php if (isset($_SESSION["user_id"])): ?>

                <span>
                    Welcome,
                    <?php echo htmlspecialchars($_SESSION["full_name"]); ?>
                </span>

                <a href="index.php?page=dashboard">Dashboard</a>

                <a href="index.php?page=logout">Logout</a>

            <?php else: ?>

                <a href="index.php?page=login">Login</a>

                <a href="index.php?page=register">Register</a>

            <?php endif; ?>
        </nav>

    </div>

</header>

<main class="container">
