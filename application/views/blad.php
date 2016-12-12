<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<meta charset="UTF-8">
	<?php echo link_tag('assets/bootstrap/css/bootstrap.min.css');?>
	<title>BŁĄD!</title>
	<style>
	h1{
		position:relative;
		top:50vh;
		transform:translateY(-50%);
		text-align:center;
		color:red;
	}
	</style>
</head>
<body>
	<h1><?php echo $komunikat; ?></p>
</body>
</html>