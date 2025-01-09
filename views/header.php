<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Youtube-dl WebUI</title>
		<link rel="stylesheet" href="./css/output.css">
		<link rel="Shortcut Icon" href="./favicon_144.png" type="image/x-icon">
	</head>
	<body>
		<nav class="bg-gray-100 px-2 lg:px-4 py-1 lg:py-3">
			<div class="flex justify-between">
				<!-- Left elements -->
				<ul class="flex gap-1 md:gap-2 lg:gap-3 xl:gap-5 nav-menu">
					<li class="hidden md:inline-block xl:text-xl font-bold">Youtube-dl WebUI</li>
<?php
						if($session->is_logged_in() && isset($file))
					{
						?>
						<li><a href="./">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/></svg></span>
							<span>Download</span>
						</a></li>
						<li><a href="./info.php">							
							<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg></span>
							<span>JSON Info</span>
						</a></li>
						<li><a href="./list.php">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg></span>
							<span><?php
						// List of files
						$filesCount = count($file->listFiles());
						if ($filesCount < 1) {
							echo '							List of files';
						} else {
							echo '							<b>List of files</b> ('.($filesCount).')';
						}
						unset($filesCount);
							?></span>
						</a></li>
<?php
						// Logs
						if ($file->is_log_enabled()) {
							?>
						<li><a href="./logs.php">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16"><path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/><path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/></svg></span>
							<span><?php
							$filesCount = $file->countLogs();
							if ($filesCount < 1) {
								echo 'Logs';
							} else {
								echo '<b>Logs</b> ('.($filesCount).')';
							}
							unset($filesCount);
							?></span>
						</a></li>
<?php
						}
					?>
						<li>
							<div class="relative inline-block text-left dropdown">
								<button class="inline-flex" type="button" aria-haspopup="true" aria-expanded="true">
									<span>
										<?php if(Downloader::background_jobs() > 0) echo "<b>"; ?>Jobs: <?php echo Downloader::background_jobs()." / ".Downloader::max_background_jobs(); if(Downloader::background_jobs() > 0) echo "</b>"; ?>
									</span>
								</button>
								<div class="hidden dropdown-menu">
									<div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" role="menu">
<?php
								if(Downloader::get_current_background_jobs() != null)
								{
?>
										<div>
<?php
									foreach(Downloader::get_current_background_jobs() as $key)
									{
										echo "\t\t\t\t\t\t\t\t\t\t\t<div class=\"text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left\"  role=\"menuitem\" title=\"".htmlspecialchars($key['cmd'])."\">Elapsed time: ".$key['time']."</div>";
									}
?>

										</div>
										<div class="py-1">
											<a class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"  role="menuitem" href="./index.php?kill=all">Kill all downloads</a>
										</div>
<?php
								}
								else {
?>
										<div class="py-1">
											<div class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"  role="menuitem" href="./index.php?kill=all">No downloads</div>
										</div>
<?php
								}

?>
                                    </div>
                                </div>
                            </div>
                        </li>
					<?php
						}
					?>
					</ul>
					<!-- Right elements -->
					<ul class="flex gap-2 md:gap-3 xl:gap-5 nav-menu">
<?php
						if($session->is_logged_in())
						{
?>
						<li><a href="./logout.php">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg></span>
							<span>Logout</span>
						</a></li>
<?php
						}
?>
				</ul>
			</div>
		</nav>
