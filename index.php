<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bonfire</title>
        <link rel="icon" href="/bonfire/favicon.ico">
        <meta name="description" content="Bonfire: a Discord-style messaging site">
        <link rel="stylesheet" href="shared.css">
        <link rel="stylesheet" href="formPage.css">
        <script type="text/javascript" src="anime.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
            ob_start();
            session_start();

            include('config.php');
            include('register.php');
            include('login.php');
            include('logout.php');

            if (isset($_SESSION['user_id'])) {
                $isLoggedIn = true;

                if (isset($_POST['rate_button'])) {
                    RateTeacher(); 
                }
            } else {
                $isLoggedIn = false;
            }

            if (!$isLoggedIn) {
                ?>
                <script type="text/javascript" src="loginPage.js" defer></script>
                <?php
                echo '
                <div id="bigBonfire">
                    <span class="bonFireLetters">B</span>
                    <span class="bonFireLetters">o</span>
                    <span class="bonFireLetters">n</span>
                    <span class="bonFireLetters">f</span>
                    <span class="bonFireLetters">i</span>
                    <span class="bonFireLetters">r</span>
                    <span class="bonFireLetters">e</span>
                </div>

                <div id="formBox">';
                    DisplayLoginForm();
                    DisplayRegisterForm();
                echo '</div>';

                if (isset($_POST['login_button'])) {
                    Login();

                    if (isset($_SESSION['user_id'])) {
                        header('Refresh:0');
                    } else {
                        echo "Login failed...";
                    }
                }

                if (isset($_POST['register_button'])) {
                    Register();
                }
            } else {
                DisplayLogoutForm();

                if (isset($_POST['logout_button'])) {
                    session_destroy();
                    unset($_SESSION['user_id']);
                    header('Refresh:0');
                }
            }

            ob_end_flush();
        ?>
    </body>
</html>