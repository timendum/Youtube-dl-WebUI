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
		<div class="my-4 lg:my-8 mx-4 md:mx-8 lg:mx-16 xl:mx-32">
			<h1 class="text-2xl lg:text-4xl font-semibold">Download</h1>
<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"p-4 my-4 rounded bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700\" role=\"alert\">$e</div>";
					}
				}

?>
			<form id="download-form" action="index.php" method="post">
				<div class="flex flex-row my-3 rounded-md border-2 border-gray-200">
					<label class="p-1 lg:px-3 lg:py-2 rounded-l-sm font-semibold bg-gray-200" for="url">URLs:</label>
					<input class="px-1 lg:px-4 lg:py-2 flex-auto" id="url" name="urls" placeholder="Link(s) separated by a space" type="text" aria-describedby="urls-addon" required/>
				</div>
				<div class="flex flex-row gap-2 md:gap-3 xl:gap-5 flex-wrap">
					<div class="my-1">
						<button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-2 focus:ring-blue-200 font-medium rounded-lg text-sm px-2 lg:px-3 py-0.5 lg:py-1.5 focus:ring-blue-800 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:from-gray-400 disabled:shadow-gray-800">Download</button>
					</div>
					<div class="my-1">
						<div class="lg:px-3 lg:py-1">
							<input type="checkbox" id="audioCheck" name="audio"/>
							<label class="form-check-label" for="audioCheck">Audio Only</label>
						</div>
					</div>
					<div class="rounded-md border border-gray-200 flex flex-auto">
						<label for="outfilename" class="p-1 lg:p-2 rounded-l-sm lg:font-semibold bg-gray-200">Filename:</label>
						<input class="p-1 lg:p-2 flex-auto" id="outfilename" name="outfilename" placeholder="Output filename template" type="text">
					</div>
					<div class="rounded-md border border-gray-200 flex flex-auto">
						<label for="vformat" class="p-1 lg:p-2 rounded-l-sm lg:font-semibold bg-gray-200">Format:</label>
						<input class="p-1 lg:p-2 flex-auto" id="vformat" name="vformat" placeholder="Video format code" type="text" />
					</div>
				</div>
			</form>
			<div class="flex gap-3 lg:gap-5 flex-wrap py-2">
				<div class="flex-auto rounded-md border border-gray-200 flex-col border-collapse">
					<div class="rounded-t-sm font-medium text-gray-800 bg-gray-100 p-1 lg:py-2 lg:px-3">Info</div>
					<div class="p-1 lg:py-2 lg:px-3 infotext">
						<p>Free space: <b><?php echo $file->free_space(); ?></b></p>
						<p>Used space: <b><?php echo $file->used_space(); ?></b></p>
						<p>Download folder: <code><?php echo $file->get_downloads_folder(); ?></code></p>
						<p>Youtube-dl version: <?php echo Downloader::get_youtubedl_version(); ?></p>
					</div>
				</div>
				<div class="flex-auto rounded-md border border-gray-200 flex-col">
					<div class="rounded-t-sm font-medium text-gray-800 bg-gray-100 p-1 lg:py-2 lg:px-3">Help</div>
					<div class="p-1 lg:py-2 lg:px-3 infotext">
						<p><b>How does it work ?</b></p>
						<p>Simply paste your video link in the field and click "Download"</p>
						<p><b>With which sites does it work?</b></p>
						<p><a href="https://github.com/yt-dlp/yt-dlp/blob/master/supportedsites.md" class="text-blue-600 hover:text-blue-800 active:text-blue-900 visited:text-purple-600 no-underline hover:underline">Here's</a> a list of the supported sites</p>
						<p><b>How can I download the video on my computer?</b></p>
						<p>Go to <a href="./list.php" class="text-blue-600 hover:text-blue-800 active:text-blue-900 visited:text-purple-600 no-underline hover:underline">List of files</a> -> choose one -> right click on the link -> "Save target as ..." </p>
						<p><b>What's Filename or Format field?</b></p>
						<p>They are optional, see the official documentation about <a href="https://github.com/yt-dlp/yt-dlp/blob/master/README.md#format-selection" class="text-blue-600 hover:text-blue-800 active:text-blue-900 visited:text-purple-600 no-underline hover:underline">Format selection</a> or <a href="https://github.com/yt-dlp/yt-dlp/blob/master/README.md#output-template" class="text-blue-600 hover:text-blue-800 active:text-blue-900 visited:text-purple-600 no-underline hover:underline">Output template</a> </p>
					</div>
				</div>
			</div>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>
