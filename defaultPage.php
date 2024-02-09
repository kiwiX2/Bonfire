<?php
	function DisplayDefaultPage() {
		echo "
			<div id='siteContainer'>
				<div id='dmColumn'>
					<div id='dmList' class='globalStyle'></div>
					<div id='ownProfile' class='globalStyle'></div>
				</div>
				<div id='friendColumn'>
					<div id='addFriendContainer' class='globalStyle'>
						<form id='addFriendForm' method='post'>
                			<input type='submit' name='add_button' value='Add Friend'>
							<input type='text' name='friend_request_name' placeholder='Add friends with their Bonfire username.' required>
						</form>
					</div>
					<div id='friendList' class='globalStyle'></div>
				</div>
			</div>
		";
	}
?>