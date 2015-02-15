<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Auth</title>
</head>
<body>
	<div style="color:#800;">
		<?php  
		foreach($this->GetErrors() as $err)
		{
			echo "<p>$err</p>";
		}
		?>
	</div>
	<div>
		<?php echo $this->GetContent(); ?>
	</div>
</body>