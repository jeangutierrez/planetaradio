<?

session_start();

if (isset($_SESSION['admin'])) {
  header("Location: splash.php");
} else {
  if (isset($_POST['password']) && $_POST['password'] == "lavozdecalderas993") {
    $_SESSION['admin'] = "admin";
    header("Location: splash.php");
  }

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="HandheldFriendly" content="True">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
<title>ADMIN</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container">
<div class="row">
    <div class="col-sm-4 col-md-offset-3">
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Iniciar sesion</h4>
			</div>
			<div class="panel-body">
            	<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            	<input type="password" class="form-control" name="password"><br>
            	<input type="submit" class="btn btn-primary" value="Entrar" name="entrar"></p>
            	</form>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</body>
</html>
<?

}

?>