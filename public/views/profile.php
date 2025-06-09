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
    <script src="public/scripts/dashboard.js" defer></script>

    <title>Your profile</title>
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
    <main class="profile-view">
        <h1>Your Profile</h1>
        <p><strong>Email:</strong> <?= htmlspecialchars($user->getEmail()) ?></p>

        <h2>Your Reservations</h2>
        <?php if (empty($reservations)): ?>
            <p>No reservations found.</p>
        <?php else: ?>
            <table class="books-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Library</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['reservation_code']) ?></td>
                            <td><?= htmlspecialchars($res['title']) ?></td>
                            <td><?= htmlspecialchars($res['author']) ?></td>
                            <td><?= htmlspecialchars($res['status']) ?></td>
                            <td><?= htmlspecialchars($res['library']) ?></td>
                            <td><?= htmlspecialchars($res['reserved_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>