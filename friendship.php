<?php
	function AddFriend() {
		$friendUsername = $_POST['friend_request_name'];
		$currentUserId = $_SESSION['user_id'];

		//Get the friends ID
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $link->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $friendUsername);
        $stmt->execute();
        $stmt->bind_result($friendId);
        $stmt->fetch();
	    $stmt->close();

        if ($friendId != null && $friendId != $currentUserId) {
	        //Add friendship to friends table as pending
	        $stmt = $link->prepare("INSERT INTO friends (user_one_id, user_two_id) VALUES (?, ?)");
		    $stmt->bind_param('ii', $currentUserId, $friendId);
		    $stmt->execute();
	    	$stmt->close();
        } else {
        	echo "User doesn't exist.";
        }

        mysqli_close($link);
	}
?>