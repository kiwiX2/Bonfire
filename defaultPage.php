<?php
	function DisplayDefaultPage() {
		echo "
			<div id='siteContainer'>
				<div id='dmColumn'>
					<div id='dmList' class='globalStyle'></div>
					<div id='ownProfile' class='globalStyle'>
						<div id='peefpContainer'>";
							// Profile pic fetch from database!
						echo "</div>
						<p id='peefpName'>";  
							// Peefp name fetch from database!
						echo "</p>";
						DisplayLogoutForm();
					echo "</div>
				</div>
				<div id='friendColumn'>
					<div id='addFriendContainer' class='globalStyle'>
						<form id='addFriendForm' method='post'>
                			<input type='submit' name='add_button' value='Add Friend' id='addFriendButton'>
							<input type='text' name='friend_request_name' placeholder='Add friends with their Bonfire username.' required id='addFriendText'>
						</form>
					</div>
					<div id='friendList' class='globalStyle'>
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
						<div>
					</div>
				</div>
			</div>
		";
	}
?>