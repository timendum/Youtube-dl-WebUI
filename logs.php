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

	$files = $file->listLogs();

	if($session->is_logged_in() && isset($_GET["delete"]))
	{
		$file->deleteLog($_GET["delete"]);
		header("Location: logs.php");
	}

	require 'views/header.php';
?>
		<div class="my-4 lg:my-8 mx-4 md:mx-8 lg:mx-16 xl:mx-32">
<?php
			if(!empty($files))
			{
		?>
			<h1 class="text-l lg:text-xl font-semibold">List logs:</h1>
			<table class="min-w-full divide-y divide-gray-200 table-auto filelist my-2">
				<thead class="border-b border-gray-300 text-left">
					<tr>
						<th>Timestamp</th>
						<th>Ended?</th>
						<th>Ok?</th>
						<th>Size</th>
						<th>Delete link</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200 border-b border-gray-300">
<?php

				foreach($files as $f)
				{
					echo "\t\t\t\t\t<tr class=\"odd:bg-gray-100 hover:bg-gray-300\">";
					if ($file->get_relative_log_folder())
					{
						echo "<td class=\"max-w-md lg:max-w-screen-md xl:max-w-screen-lg text-ellipsis overflow-hidden\"><a class=\"lg:line-clamp-1 text-blue-600 hover:text-blue-800 active:text-blue-900 visited:text-purple-600 underline hover:decoration-transparent\" href=\"".rawurlencode($file->get_relative_log_folder()).'/'.rawurlencode($f["name"])."\" download title=\"".htmlspecialchars($f["name"])."\">".htmlspecialchars($f["name"])."</a></td>";
					}
					else
					{
						echo "<td><div>".$f["name"]."</div><div>".$f["lastline"]."</div></td>";
					}
					echo "<td>".($f["ended"] ? '&#10003;' : '')."</td>";
					echo "<td>".($f["100"] ? '&#10003;' : '')."</td>";
					echo "<td>".$f["size"]."</td>";
					echo "<td><a href=\"./logs.php?delete=".sha1($f["name"])."\" class=\"btn-delete\">Delete</a></td>";
					echo "</tr>\n";
				}
			?>
				</tbody>
			</table>
		<?php
			}
			else
			{
				echo "<div class=\"p-4 my-4 rounded bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700\" role=\"alert\">No logs!</div>";
			}
		?>
		</div>
<?php
	require 'views/footer.php';
?>

