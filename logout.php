<?php
	function DisplayLogoutForm() {
		echo "
			<form id='logoutButton' method='post'>
				<span class='icon-input-btn'>
					<input type='submit' name='logout_button' value=''>
					<i class='fa-solid fa-arrow-right-from-bracket'></i>
				</span>
			</form>
		";
	}
?>