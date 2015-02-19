<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Welcome</title>
</head>
<body>
	
	<div>
		
		<h1>Welcome, <?php echo $this->GetModel()->Email; ?></h1>

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
	
		<p>Your APIKey is currently <?php echo $this->GetModel()->APIKey; ?></p>
		<p>Provide a list of games, some password reset junk, etc.</p>
		
	</div>
</body>