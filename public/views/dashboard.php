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
    <script src="public/scripts/books.js" defer></script>

    <title>Dashboard</title>
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
            <h1>Books List</h1>
        </div>
        <div class="search-mobile hide-desktop">
            <i class="icon fa-solid fa-magnifying-glass"></i>
            <input id="mobile-search" type="search" placeholder="Search for books" class="search-bar" />
        </div>
        <div class="pagination"></div>

        <table class="books-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </main>
</body>

</html>