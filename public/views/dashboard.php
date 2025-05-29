<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

    <link href="public/styles/main.css" rel="stylesheet">
    <link href="public/styles/dashboard/dashboard.css" rel="stylesheet">
    <link href="public/styles/dashboard/aside.css" rel="stylesheet">
    <link href="public/styles/dashboard/header.css" rel="stylesheet">

    <script src="public/scripts/menu.js" defer></script>

    <title>Dashboard</title>
</head>

<body>
    <aside>
        <div class="logo">
            <img src="public/assets/images/logo.png" alt="logo" class="logo">
        </div>
        <nav>
            <ul class="menu">
                <li><a href="/dashboard"><i class="fas fa-book"></i> Books List</a></li>
                <li><a href="/dashboard/categories"><i class="fas fa-list"></i> Categories</a></li>
                <li><a href="/dashboard/bestsellers"><i class="fas fa-ranking-star"></i> Bestsellers</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'ADMIN') : ?>
                    <li><a href="/dashboard/manage"><i class="fas fa-gear"></i> Books Management</a></li>
                <?php endif; ?>
            </ul>
            <ul class="menu logout">
                <li><a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>
    <header>
        <div class="logo hide-desktop">
            <img src="public/assets/images/logo.png" alt="logo" class="logo">
        </div>
        <i class="icon fa-solid fa-magnifying-glass hide-mobile"></i>
        <input type="search" placeholder="Search for books" class="search-bar hide-mobile" />
        <a href="/profile" class="profile-link hide-mobile">
            <i class="fa-solid fa-user"></i>
            <span>Your Profile</span>
        </a>
        <div class="menu-hamburger hide-desktop">
            <i class="fas fa-bars"></i>
        </div>
        <nav class="mobile-menu hide-desktop">
            <ul class="menu">
                <li><a href="/dashboard"><i class="fas fa-book"></i> Books List</a></li>
                <li><a href="/dashboard/categories"><i class="fas fa-list"></i> Categories</a></li>
                <li><a href="/dashboard/bestsellers"><i class="fas fa-ranking-star"></i> Bestsellers</a></li>
                <li><a href="/profile"><i class="fas fa-user"></i> Your Profile</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'ADMIN') : ?>
                    <li><a href="/dashboard/manage"><i class="fas fa-gear"></i> Books Management</a></li>
                <?php endif; ?>
                <li><a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

</body>

</html>