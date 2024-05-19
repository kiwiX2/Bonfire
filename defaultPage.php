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
                	$username = $_POST['DMSelector'];
                	DisplayDM($username);
                } else {
                	DisplayFriendList();
                }
			echo "</div>
		</div>";
	}

	function DisplayDM($username) {
		echo "<div id='messageChannel' class='globalStyle'>
			<h2>$username</h3>
			<hr>";

			//FETCH ALL MESSAGES AND DISPLAY THEM HERE


			echo "<form id='sendMessage' method='post'>
				<input type='text' name='message' placeholder='Message $username'>
			</form>"; 

			if (isset($_POST['message'])) {
                $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $stmt = $link->prepare("INSERT INTO messages (sender_id, receiver_id, pending, message) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('iis', 8, 9, 0, "yo");
                $stmt->execute();

                mysqli_close($link);
            }
		echo "</div>";
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
?>