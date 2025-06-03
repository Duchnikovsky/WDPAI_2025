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

    <script src="public/scripts/menu.js" defer></script>

    <title>Best Sellers</title>
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
            <h1>Best Sellers</h1>
        </div>

        <?php if (isset($bestsellers) && count($bestsellers) > 0): ?>
            <table class="books-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Reservations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bestsellers as $index => $book): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['category']); ?></td>
                            <td><?php echo (int) $book['reservations_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No reservations in the last month.</p>
        <?php endif; ?>
    </main>

</body>

</html>