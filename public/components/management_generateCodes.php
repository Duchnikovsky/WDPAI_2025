<form class="form-management" action="generateCodes" method="POST">
    <h2>Generate access codes</h2>
    <?php if (isset($codeError)) : ?>
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?php echo $codeError; ?></span>
    <?php endif; ?>
    <div class="management-input">
        <label for="quantity">Number of codes</label>
        <input id="quantity" type="number" name="quantity" max="100" required placeholder="Insert number of codes">
    </div>
    <button type="submit" class="flex-row-center-center"><i class="fas fa-lock-open"></i>Generate codes</button>
    <?php if (isset($generatedCodes) && !empty($generatedCodes)) : ?>
        <div class="management-input">
            <label for="generated-codes">Generated Codes</label>
            <textarea id="generated-codes" name="generated-codes" rows="10" readonly><?php echo htmlspecialchars(implode("\n", $generatedCodes)); ?></textarea>
            <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('generated-codes').value)">Copy All</button>
        </div>
    <?php endif; ?>
</form>