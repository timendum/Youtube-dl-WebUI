<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';

	$session = Session::getInstance();
	$loginError = "";

	if(isset($_POST["password"]))
	{
		if($session->login($_POST["password"]))
		{
			header("Location: index.php");
			exit;
		}
		else
		{
			$loginError = "Wrong password !";
		}
	}
?>

<?php require 'views/header.php'; ?>
<div class="container my-4">
	<?php
		if($loginError !== "")
		{
	?>
	<div class="alert alert-danger" role="alert"><?php echo $loginError; ?></div>
	<?php
		}
	?>
	<div class="row my-3">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h2>Login:</h2>
		</div>
		<div class="col-md-4"></div>
	</div>
	<form class="form-horizontal" action="login.php" method="POST">
		<div class="input-group my-3">
			<div class="col-lg-4"></div>
				<div class="col-lg-4">
					<input class="form-control" id="password" name="password" placeholder="Password" type="password" />
				</div>
			<div class="col-lg-4"></div>
		</div>
		<div class="input-group my-3">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<button type="submit" class="btn btn-primary">Sign in</button>
			</div>
			<div class="col-lg-4"></div>
		</div>
	</form>
</div>
<?php require 'views/footer.php'; ?>
