<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

    <link href="public/styles/main.css" rel="stylesheet">
    <link href="public/styles/auth.css" rel="stylesheet">
    <link href="public/styles/fonts.css" rel="stylesheet">

    <title>Sign In | Bookly</title>
</head>

<body id="auth-page" class="flex-row-center-center">
    <img src="public/assets/images/logo.png" alt="logo" class="logo">
    <div class="flex-column-center-center">
        <h1>Sign In</h1>
        <form class="flex-column-center-center" action="login" method="POST">
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
            <button type="submit" class="flex-row-center-center"><i class="fa-solid fa-right-to-bracket"></i>Sign In</button>
        </form>
        <p class="auth-subtext">Don't have an account? <a href="signup">Sign Up</a></p>
    </div>

</body>

</html>