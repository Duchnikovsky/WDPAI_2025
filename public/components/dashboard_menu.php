<ul class="menu">
    <li class="<?= ($_SERVER['REQUEST_URI'] === '/dashboard') ? 'active' : '' ?>">
        <a href="/dashboard"><i class="fas fa-book"></i> Books List</a>
    </li>
    <li class="<?= ($_SERVER['REQUEST_URI'] === '/dashboard/categories') ? 'active' : '' ?>">
        <a href="/dashboard/categories"><i class="fas fa-list"></i> Categories</a>
    </li>
    <li class="<?= ($_SERVER['REQUEST_URI'] === '/dashboard/bestsellers') ? 'active' : '' ?>">
        <a href="/dashboard/bestsellers"><i class="fas fa-ranking-star"></i> Bestsellers</a>
    </li>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'ADMIN') : ?>
        <li class="<?= ($_SERVER['REQUEST_URI'] === '/dashboard/manage') ? 'active' : '' ?>">
            <a href="/dashboard/manage"><i class="fas fa-gear"></i> Books Management</a>
        </li>
    <?php endif; ?>
</ul>
<ul class="menu logout">
    <li><a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
</ul>