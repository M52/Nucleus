<div class="row">
	<div class="large-8 large-offset-2 columns">
		<h4>Login</h4>
		<form name="login" method="post" action="">
			<label for="username">Username</label>
			<input type="text" name="username">
			<label for="password">Password</label>
			<input type="password" name="password">
			<input type="submit" value="Log in">	
		</form>
		<?php
		if (isset($_POST))
		{
			print_r($_POST);
		}
		?>
	</div>
	<div class="large-offset-2 columns"></div>
</div>