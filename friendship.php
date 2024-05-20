<?php
	function FriendRequest() {
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
	        //Add friendship or friend request to table
	        ReplaceFriendship($currentUserId, $friendId);
        } else {
        	echo "<p class='error'>User doesn't exist.</p>";
        }

        mysqli_close($link);
	}

	function ReplaceFriendship($currentUserId, $friendId) {
	    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    
	    //Check if a pending friendship already exists
	    $stmt = $link->prepare("SELECT * FROM friends WHERE ((user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)) AND pending = 1");
	    $stmt->bind_param('iiii', $currentUserId, $friendId, $friendId, $currentUserId);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    $exists = $result->num_rows > 0;
	    $stmt->close();

	    if ($exists) {
	        //Update to not pending
	        $stmt = $link->prepare("UPDATE friends SET pending = 0 WHERE ((user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)) AND pending = 1");
	        $stmt->bind_param('iiii', $currentUserId, $friendId, $friendId, $currentUserId);
	        $stmt->execute();
	        $stmt->close();
	    } else {
	        //Add a friend as pending
	        $pending = 1;
	        $null = NULL;
	        $stmt = $link->prepare("INSERT INTO friends (user_one_id, user_two_id, pending, messages) VALUES (?, ?, ?, ?)");
	        $stmt->bind_param('iiis', $currentUserId, $friendId, $pending, $null);
	        $stmt->execute();
	        $stmt->close();
	    }

	    mysqli_close($link);
	}

	function DisplayFriends($pending) {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $link->prepare("SELECT user_one_id, user_two_id FROM friends WHERE (user_one_id = ? OR user_two_id = ?) AND pending = ?");
        $stmt->bind_param('iii', $_SESSION['user_id'], $_SESSION['user_id'], $pending);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
	    $stmt->close();

        foreach ($rows as $row) {
        	$friendId = ($row['user_one_id'] == $_SESSION['user_id']) 
        		? $row['user_two_id'] 
        		: $row['user_one_id'];

        	$_SESSION['friend_id'] = $friendId;
		
	        $stmt2 = $link->prepare("SELECT username FROM users WHERE id = ?");
	        $stmt2->bind_param('i', $friendId);
	        $stmt2->execute();
	        $stmt2->bind_result($thisFriendUsername);
	        $stmt2->fetch();
		    $stmt2->close();

	        echo "<form class='DMSelector' method='post'>
					<input type='submit' name='DMSelector' value='$thisFriendUsername' class=''>
			</form>";
        }
	    
        mysqli_close($link);
	}

	function GetFriendId($username) {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$stmt = $link->prepare("SELECT id FROM users WHERE username = ?");
	    $stmt->bind_param('s', $username);
	    $stmt->execute();
	    $stmt->bind_result($thisFriendId);
	    $stmt->fetch();
	    $stmt->close();

	    return $friendId = $thisFriendId;
	}

		function SendMessage() {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$username = $_SESSION['DMUsername'];

		$friendId = GetFriendId($username);
		$senderId = $_SESSION['user_id'];

		$newMessage = [
			'message' => $_POST['message'],
			'senderId' => $senderId
		];

		$stmt = $link->prepare("SELECT messages FROM friends WHERE (user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)");
		$stmt->bind_param('iiii', $senderId, $friendId, $friendId, $senderId);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();

		$messages = isset($result['messages'])? json_decode($result['messages'], true) : [];
		$messages[] = $newMessage;
		$updatedMessages = json_encode($messages);

		$stmt = $link->prepare("UPDATE friends SET messages = ? WHERE (user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)");
		$stmt->bind_param('siiii', $updatedMessages, $senderId, $friendId, $friendId, $senderId);
		$stmt->execute();

	    mysqli_close($link);
	}

	function DisplayAllMessages() {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		$username = $_SESSION['DMUsername'];
		$friendId = GetFriendId($username);
		$myId = $_SESSION['user_id'];

		$stmt = $link->prepare("SELECT messages FROM friends WHERE (user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)");
		$stmt->bind_param('iiii', $myId, $friendId, $friendId, $myId);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$messageArray = json_decode($row['messages'], true);
			if ($messageArray) {		
				foreach ($messageArray as $message) {
					$stmt2 = $link->prepare("SELECT username FROM users WHERE id = ?");
					$stmt2->bind_param('i', $message['senderId']);
					$stmt2->execute();
					$senderUsername = $stmt2->get_result()->fetch_assoc()['username'];

					echo $senderUsername . "<br>" . $message['message']	. "<br> <br>";
				}
			}
		}
	    
	    mysqli_close($link);
	}
?>