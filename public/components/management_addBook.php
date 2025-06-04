<form class="form-management" action="addBook" method="POST">
    <h2>Add New Book</h2>
    <?php if (isset($addError)) : ?>
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?php echo $addError; ?></span>
    <?php endif; ?>
    <div class="management-input">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" required placeholder="Insert title">
    </div>
    <div class="management-input">
        <label for="author">Author</label>
        <input id="author" type="text" name="author" required placeholder="Insert author">
    </div>
    <div class="management-input">
        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="" disabled selected>Select a category</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="management-input">
        <label for="quantity">Quantity</label>
        <input id="quantity" type="number" name="quantity" required placeholder="Insert quantity">
    </div>
    <div class="management-input">
        <label for="library">Library</label>
        <select id="library" name="library" required>
            <option value="" disabled selected>Select a library</option>
            <?php foreach ($libraries as $library) : ?>
                <option value="<?php echo $library['id']; ?>"><?php echo $library['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="flex-row-center-center"><i class="fas fa-address-book"></i>Add book</button>
</form>