<?php 
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

	    $stmt = $link->prepare("SELECT id, password FROM users WHERE username= ?");
	    $stmt->bind_param("s", $login_name);

	    $stmt->execute();
	    $stmt->bind_result($user_id, $hashed_password);

	    $result = $stmt->fetch();

		if (password_verify($login_password, $hashed_password)) {
			$_SESSION['user_id'] = $user_id;
		}

	    mysqli_close($link);
	}
?>
