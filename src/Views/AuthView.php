<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Auth</title>
</head>
<body>
	<div style="color:#800;">
		<?php  
		foreach($this->GetModel()->GetErrors() as $err)
		{
			echo "<p>$err</p>";
		}
		?>
	</div>
	<div>
		<?php print_r($this->GetModel()); ?>
	</div>
</body>