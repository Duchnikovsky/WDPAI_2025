<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

    <link href="public/styles/main.css" rel="stylesheet">
    <link href="public/styles/fonts.css" rel="stylesheet">
    <link href="public/styles/dashboard/dashboard.css" rel="stylesheet">
    <link href="public/styles/dashboard/aside.css" rel="stylesheet">
    <link href="public/styles/dashboard/header.css" rel="stylesheet">
    <link href="public/styles/dashboard/categories.css" rel="stylesheet">

    <script src="public/scripts/menu.js" defer></script>

    <title>Categories</title>
</head>

<body>
    <aside>
        <div>
            <img src="public/assets/images/logo.png" alt="logo" class="logo">
        </div>
        <nav>
            <?php include 'public/components/dashboard_menu.php'; ?>
        </nav>
    </aside>
    <?php include 'public/components/dashboard_header.php'; ?>
    <main>
        <div class="title">
            <h1>Book Categories</h1>
        </div>
        <ul class="category-list">
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="/dashboard?category=<?php echo urlencode($category['name']); ?>">
                        <i class="fas <?php echo htmlspecialchars($category['icon']); ?>"></i>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>

</html>