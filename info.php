<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
		exit;
	}
	else
	{
		$json = False;

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$downloader = new Downloader($_POST['urls']);
			$json = $downloader->info();
		}
	}
?>
		<div class="container my-4">
			<h1>JSON Info</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="info-form" action="info.php" method="post">
				<div class="row my-3">
					<div class="input-group">
						<div class="input-group-text" id="urls-addon">URLs:</div>
						<input class="form-control" id="url" name="urls" placeholder="Link(s) separated by a space" type="text" aria-describedby="urls-addon" required/>
					</div>
				</div>
				<div class="row mt-3 align-items-center">
					<div class="col-auto">
						<button type="submit" class="btn btn-primary">Query</button>
					</div>
				</div>

			</form>
			<br>
			<div class="row">
			<?php
				if ($json)
				{
				?>
				<div class="panel panel-info">
					<div class="panel-heading"><h3 class="panel-title">Info</h3></div>
					<div class="panel-body">
						<textarea rows="50" class="form-control"><?php echo $json ?></textarea>
					</div>
				</div>
				<?php
				}
			?>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
