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
		<div class="my-4 lg:my-8 mx-4 md:mx-8 lg:mx-16 xl:mx-32">
			<h1 class="text-2xl lg:text-4xl font-semibold">JSON Info</h1>
<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"p-4 my-4 rounded bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="info-form" action="info.php" method="post">
				<div class="flex flex-row my-3 rounded-md border-2 border-gray-200">
					<label class="p-1 lg:px-3 lg:py-2 rounded-l-sm font-semibold bg-gray-200" for="url">URLs:</label>
					<input class="px-1 lg:px-4 lg:py-2 flex-auto" id="url" name="urls" placeholder="Link(s) separated by a space" type="text" aria-describedby="urls-addon" required/>
				</div>
				<div class="flex flex-row gap-2 md:gap-3 xl:gap-5 flex-wrap">
					<div class="my-1">
						<button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-2 focus:ring-blue-200 font-medium rounded-lg text-sm px-2 lg:px-3 py-0.5 lg:py-1.5 focus:ring-blue-800 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:from-gray-400 disabled:shadow-gray-800">Query</button>
					</div>
				</div>

			</form>
			<div class="my-2">
			<?php
				if ($json)
				{
				?>
				<div class="rounded-md border border-gray-200">
					<div class="rounded-t-sm font-medium text-gray-800 bg-gray-100 p-1 lg:py-2 lg:px-3">Info</div>
					<div>
						<textarea rows="50" class="w-full p-1"><?php echo $json ?></textarea>
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
