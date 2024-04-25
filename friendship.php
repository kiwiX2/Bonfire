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
        	echo "<p class='error'>User doesn't exist.</p>";
        }

        mysqli_close($link);
	}

	function DisplayPending() {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $link->prepare("SELECT user_one_id, user_two_id FROM friends WHERE (user_one_id = ? OR user_two_id = ?) AND pending = 1");
        $stmt->bind_param('ii', $_SESSION['user_id'], $_SESSION['user_id']);
        $stmt->execute();
        $stmt->bind_result($id_one, $id_two);
        $stmt->fetch();
	    $stmt->close();

        if ($id_one == $_SESSION['user_id']) {
        	$friendId = $id_two;
        } else {
        	$friendId = $id_one;
        }

        if ($id_one != null) {
	        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	        $stmt = $link->prepare("SELECT username FROM users WHERE id = $friendId");
	        $stmt->execute();
	        $stmt->bind_result($pendingFriendUsername);
	        $stmt->fetch();
		    $stmt->close();

	        echo "<p class='error'>" . $pendingFriendUsername . "</p>";
        }

	}
?>