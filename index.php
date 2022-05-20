<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
		exit;
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;
			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$outfilename = False;
			if(isset($_POST['outfilename']) && !empty($_POST['outfilename']))
			{
				$outfilename = $_POST['outfilename'];
			}

			$vformat = False;
			if(isset($_POST['vformat']) && !empty($_POST['vformat']))
			{
				$vformat = $_POST['vformat'];
			}

			$downloader = new Downloader($_POST['urls']);
			$downloader->download($audio_only, $outfilename, $vformat);

			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
				exit;
			}
		}
	}

	require 'views/header.php';
?>
		<div class="container">
			<h1>Download</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" action="index.php" method="post">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" id="urls-addon">URLs:</span>
						<input class="form-control" id="url" name="urls" placeholder="Link(s) separated by a space" type="text" aria-describedby="urls-addon" required/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary">Download</button>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="audio" /> Audio Only
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon" id="outfilename-addon">Filename:</span>
							<input class="form-control" id="outfilename" name="outfilename" placeholder="Output filename template" type="text" aria-describedby="outfilename-addon" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon" id="vformat-addon">Format:</span>
							<input class="form-control" id="vformat" name="vformat" placeholder="Video format code" type="text" aria-describedby="vformat-addon" />
						</div>
					</div>
				</div>

			</form>
			<br>
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">Info</h3></div>
						<div class="panel-body">
							<p>Free space : <?php echo $file->free_space(); ?></b></p>
							<p>Used space : <?php echo $file->used_space(); ?></b></p>
							<p>Download folder : <?php echo $file->get_downloads_folder(); ?></p>
							<p>Youtube-dl version : <?php echo Downloader::get_youtubedl_version(); ?></p>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="panel panel-info">
						<div class="panel-heading"><h3 class="panel-title">Help</h3></div>
						<div class="panel-body">
							<p><b>How does it work ?</b></p>
							<p>Simply paste your video link in the field and click "Download"</p>
							<p><b>With which sites does it work?</b></p>
							<p><a href="https://ytdl-org.github.io/youtube-dl/supportedsites.html">Here's</a> a list of the supported sites</p>
							<p><b>How can I download the video on my computer?</b></p>
							<p>Go to <a href="./list.php">List of files</a> -> choose one -> right click on the link -> "Save target as ..." </p>
							<p><b>What's Filename or Format field?</b></p>
							<p>They are optional, see the official documentation about <a href="https://github.com/ytdl-org/youtube-dl/blob/master/README.md#format-selection">Format selection</a> or <a href="https://github.com/ytdl-org/youtube-dl/blob/master/README.md#output-template">Output template</a> </p>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
