<header class="<?= ($_SERVER['REQUEST_URI'] === '/dashboard') ? 'search-visible' : '' ?>">
    <div class="hide-desktop">
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
        <?php include 'public/components/dashboard_menu.php'; ?>
    </nav>
</header>