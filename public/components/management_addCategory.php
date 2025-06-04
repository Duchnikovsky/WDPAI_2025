<form class="form-management" action="addCategory" method="POST">
    <h2>Add New Category</h2>
    <?php if (isset($addError)) : ?>
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?php echo $addError; ?></span>
    <?php endif; ?>
    <div class="management-input">
        <label for="name">Category name</label>
        <input id="name" type="text" name="name" required placeholder="Insert category name">
    </div>
    <div class="management-input">
        <label for="icon">Font Awesome icon</label>
        <input id="icon" type="text" name="icon" required placeholder="Insert icon name">
    </div>
    <button type="submit" class="flex-row-center-center"><i class="fas fa-list"></i>Add category</button>
</form>