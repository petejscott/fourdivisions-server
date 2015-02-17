<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Game</title>
</head>
<body>
	
	<div>
		
		<h1>Game <?php echo($this->GetModel()->Id); ?></h1>

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
	
		<ul>
		<?php
		foreach($this->GetModel()->Plys as $ply)
		{
			echo "<li>$ply</li>";
		}
		?>
		</ul>
		
	</div>
</body>