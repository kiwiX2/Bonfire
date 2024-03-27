<?php 
    // Config
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "bonfire_db");

    // Register
    function DisplayRegisterForm() {
        echo "
            <form id='registerForm' method='post'>
                <p>Register an account</p>
                <input type='text' name='name' placeholder='Username' required><br>
                <input type='password' name='password' placeholder='Password' required><br>
                <input type='submit' name='register_button' value='Register'>
            </form>
        ";
    }

    function Register() {    
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $username = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $link->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();
        $stmt->close();

        mysqli_close($link);
    }

    // Login
    function DisplayLogo() {
        echo '<div id="bigBonfire">
            <span class="bonFireLetters">B</span>
            <span class="bonFireLetters">o</span>
            <span class="bonFireLetters">n</span>
            <span class="bonFireLetters">f</span>
            <span class="bonFireLetters">i</span>
            <span class="bonFireLetters">r</span>
            <span class="bonFireLetters">e</span>
        </div>';
    }

    function DisplayLoginForm() {
        echo "
            <form id='loginForm' method='post'>
                <p>Log in to your account</p>
                <input type='text' name='login_name' placeholder='Username' required><br>
                <input type='password' name='login_password' placeholder='Password'required><br>
                <input type='submit' name='login_button' value='Log in'>
            </form>
        ";
    }

    function Login() {  
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $login_name = $_POST["login_name"];
        $login_password = $_POST["login_password"];

        $stmt = $link->prepare("SELECT id, password, picture FROM users WHERE username= ?");
        $stmt->bind_param("s", $login_name);

        $stmt->execute();
        $stmt->bind_result($user_id, $hashed_password, $picture);

        $result = $stmt->fetch();

        if (password_verify($login_password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $login_name;
            $_SESSION['picture'] = $picture;
        }

        mysqli_close($link);
    }

    // Logout
    function DisplayLogoutForm() {
        echo "
            <form id='logoutButton' method='post'>
                <span class='icon-input-btn'>
                    <input type='submit' name='logout_button' value=''>
                    <i class='fa-solid fa-arrow-right-from-bracket'></i>
                </span>
            </form>
        ";
    }
?>
