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
    <link href="public/styles/dashboard/book.css" rel="stylesheet">

    <script src="public/scripts/menu.js" defer></script>
    <script src="public/scripts/book.js" defer></script>

    <title>Book</title>
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
    <main class="book-details">
        <?php if (isset($error)): ?>
            <h2><?php echo htmlspecialchars($error); ?></h2>
        <?php else: ?>
            <h1 class="title"><?php echo htmlspecialchars($book['title']); ?></h1>
            <p><strong> <?php echo htmlspecialchars($book['author']); ?></strong></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
            <h2>You can rent this book there:</h2>
            <ul class="availability-list">
                <?php foreach ($availability as $stock): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($stock['library']); ?></h3>
                        <?php echo (int) $stock['quantity']; ?> available
                        <button type="button" class="flex-row-center-center"><i class="fa-solid fa-book-medical"></i>Reserve book there</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>

</html>