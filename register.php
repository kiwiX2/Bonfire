<?php 
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
?>
