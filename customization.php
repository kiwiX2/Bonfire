<script type="text/javascript" src="scripts/script.js" defer></script>

<?php 
	$error_message = "";

	function ChangeName() {
		global $error_message;
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $username_value = $_POST["username_value"];

        if (!empty($username_value) && !NameIsDuplicate($username_value)) {
	        $stmt = $link->prepare("UPDATE users SET username=? WHERE id=?");
	        $stmt->bind_param("si", $username_value, $_SESSION['user_id']);

	        $stmt->execute();
			$stmt->close();
        	mysqli_close($link);
        } else {
        	$error_message .= "Please enter a unique username. ";
        }

	}

	function ChangeColor() {
		global $error_message;
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $color_value = $_POST["color_value"];

        if (!empty($color_value)) {
	        $stmt = $link->prepare("UPDATE users SET color=? WHERE id=?");
	        $stmt->bind_param("si", $color_value, $_SESSION['user_id']);

	        $stmt->execute();
			$stmt->close();
        	mysqli_close($link);
        } else {
        	$error_message .= "Please enter a hexcode. ";
        }
        
        if (strlen($error_message) > 0) {
        	echo "<p class='error'>" . $error_message . "<p>";
        }
	}
?>
