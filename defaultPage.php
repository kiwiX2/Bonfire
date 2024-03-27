<?php
	function DisplayDefaultPage() {
		echo "<div id='siteContainer'>
			<div id='dmColumn'>
				<div id='dmList' class='globalStyle'>
					<h3>Direct Messages</h3>
					<hr>
					<!-- Friends fetch from database! -->
					<form id='menuSelectorContainer'>
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
				//DisplayFriendList();
				DisplayProfileEditor();
			echo "</div>
		</div>";
	}

	function DisplayFriendList() {
		echo "<div id='friendList' class='globalStyle'>
			<h3>Friends</h3>
			<hr>
			<div id='filterFriends'>
				<form class='filterForm' method='post'>
					<input type='submit' name='online_filter' value='Online' class='filterFormInput'>
				</form>
				<form class='filterForm' method='post'>
					<input type='submit' name='all_filter' value='All' class='filterFormInput'>
				</form>
				<form class='filterForm' method='post'>
					<input type='submit' name='pending_filter' value='Pending' class='filterFormInput'>
				</form>
				<form class='filterForm' method='post'>
					<input type='submit' name='blocked_filter' value='Blocked' class='filterFormInput'>
				</form>
			</div>
		</div>";
	}

	function DisplayProfileEditor() {
		echo "<div id='profileEditor' class='globalStyle'>
			<h3>Edit User Profile</h3>
			<form id='profileForm'>
				<p>Username</p>
				<input type='text' name='username' value='John Name'>
				<p>Profile Color</p>
				<input type='text' name='color' value='#000000'>
			</form>
		</div>";
	}
?>