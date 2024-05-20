<?php
	function DisplayDefaultPage() {
		echo "<div id='siteContainer'>
			<div id='dmColumn'>
				<div id='dmList' class='globalStyle'>
					<h3>Direct Messages</h3>
					<hr>
					<form id='menuSelectorContainer' method='post'>
						<input type='submit' name='friend_list_button' value='Friend List'>
						<input type='submit' name='edit_profile_button' value='Edit Profile'>
					</form>
				</div>
				<div id='ownProfile' class='globalStyle'>
					<div id='peefpContainer'>
						<img id='ownImage' src='";
							if ($_SESSION['picture'] != null) {
								echo "" . $_SESSION['picture'] . "";
							} else {
								echo "style/defaultPfp.jpg";
							}
					echo "'/> </div>
						<p id='peefpName'>" . $_SESSION['username'] . "</p>";
						DisplayLogoutForm();
				echo "</div>
			</div>
			<div id='friendColumn'>
				<div id='addFriendContainer' class='globalStyle'>
					<form id='addFriendForm' method='post'>
            			<input type='submit' name='add_button' value='Add Friend' id='addFriendButton'>
						<input type='text' name='friend_request_name' placeholder='Add friends with their Bonfire username.' required id='addFriendText'>
					</form>
				</div>";
                
                if (isset($_POST['edit_profile_button'])) { 
                	DisplayProfileEditor(); 
                } else if (isset($_POST['DMSelector'])) {
                	$_SESSION['DMUsername'] = $_POST['DMSelector'];
                	DisplayDM();
                } else {
                	DisplayFriendList();
                }
			echo "</div>
		</div>";
	}

	function DisplayDM() {
		$username = $_SESSION['username'];
		echo "<div id='messageChannel' class='globalStyle'>
			<h2>$username</h3>
			<hr>";

			//FETCH ALL MESSAGES AND DISPLAY THEM HERE

			echo "<form id='sendMessage' method='post'>
				<input type='text' name='message' placeholder='Message $username'>
			</form>
		</div>";
	}

	function DisplayFriendList() {
		echo "<div id='friendList' class='globalStyle'>
			<h3>Friends</h3>
			<hr>
			<div id='filterFriends'>
				<form class='filterForm' method='post'>
					<input type='submit' name='all_filter' value='All Friends' class='filterFormInput'>
				</form>
				<form class='filterForm' method='post'>
					<input type='submit' name='pending_filter' value='Pending' class='filterFormInput'>
				</form>
			</div>";

			if (isset($_POST['pending_filter'])) { 
				DisplayFriends($pending = 1);
			} else {
				DisplayFriends($pending = 0);
			}
		echo "</div>";
	}

	function DisplayProfileEditor() {
		echo "<div id='profileEditor' class='globalStyle'>
			<h3>Edit User Profile</h3>
			<hr>
			<form id='profileForm' method='post' onsubmit='UpdateUsername()'>
				<p>Username</p>
				<input type='text' name='username_value' placeholder='John Name'>
				<p>Profile Color</p>
				<input type='text' name='color_value' placeholder='#000000'>
				<input type='submit' name='submit_changes_button' value='Save Changes'>
			</form>
		</div>";
	}

	function SendMessage() {
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$username = $_SESSION['DMUsername'];

		$stmt = $link->prepare("SELECT id FROM users WHERE username = ?");
	    $stmt->bind_param('s', $username);
	    $stmt->execute();
	    $stmt->bind_result($thisFriendId);
	    $stmt->fetch();
	    $stmt->close();

	    $friendId = $thisFriendId;
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
?>