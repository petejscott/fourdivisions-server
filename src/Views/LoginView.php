<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Login</title>
</head>
<body>
	
	<div>
		
		<h1>Login</h1>

		<?php  
		if (count($this->GetModel()->GetErrors()) > 0)
		{
			echo '<ul style="color:#800">';
			foreach($this->GetModel()->GetErrors() as $err)
			{
				echo "<p>$err</p>";
			}
			echo '</ul>';
		}
		?>
	
		<form method="POST" action="?controller=Auth&action=Auth">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" placeholder="bob@example.com" />
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			<input type="submit" value="Log In" />
		</form>
		
	</div>
</body>