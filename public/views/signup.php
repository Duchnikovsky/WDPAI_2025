<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

    <link href="public/styles/main.css" rel="stylesheet">
    <link href="public/styles/auth.css" rel="stylesheet">
    <link href="public/styles/fonts.css" rel="stylesheet">

    <title>Sign Up | Bookly</title>
</head>

<body id="auth-page" class="flex-row-center-center">
    <img src="public/assets/images/logo.png" alt="logo" class="logo">
    <div class="flex-column-center-center">
        <h1>Sign Up</h1>
        <form class="flex-column-center-center" action="register" method="POST">
            <div class="error-output">
                <?php if (isset($error)) : ?>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo $error; ?></span>
                <?php endif; ?>
            </div>
            <div class="auth-input">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required placeholder="Insert your email address">
            </div>
            <div class="auth-input">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="Insert your password">
            </div>
            <div class="auth-input">
                <label for="accescode">Access code</label>
                <input id="accescode" type="text" name="accescode" required placeholder="Insert your access code">
            </div>
            <button type="submit" class="flex-row-center-center"><i class="fa-solid fa-right-to-bracket"></i>Sign Up</button>
        </form>
        <p class="auth-subtext">Already have an account? <a href="login">Sign In</a></p>
    </div>
</body>

</html>