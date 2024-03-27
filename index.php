<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bonfire</title>
        <link rel="icon" href="style/favicon.ico">
        <meta name="description" content="Bonfire: a Discord-style messaging site">
        <link rel="stylesheet" href="style/shared.css">
        <script type="text/javascript" src="scripts/anime.min.js"></script>
        <script src="https://kit.fontawesome.com/7e7ddfc030.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
            ob_start();
            session_start();

            include('connection.php');
            include('defaultPage.php');
            include('friendship.php');

            if (isset($_SESSION['user_id'])) {
                $isLoggedIn = true;
                if (isset($_POST['add_button'])) { AddFriend(); }
                if (isset($_POST['rate_button'])) { RateTeacher(); }
                if (isset($_POST['friend_list_button'])) { DisplayFriendList(); }
                if (isset($_POST['edit_profile_button'])) { DisplayProfileEditor(); }
            } else {
                $isLoggedIn = false;
            }

            if (!$isLoggedIn) {
                ?>
                <link rel="stylesheet" href="style/formPage.css">
                <script type="text/javascript" src="scripts/loginPage.js" defer></script>
                <?php
                DisplayLogo();
                echo '<div id="formBox">';
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
                ?>
                <link rel="stylesheet" href="style/defaultPage.css">
                <?php
                DisplayDefaultPage();

                if (isset($_POST['add_button'])) {
                    //addFriend();
                }

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