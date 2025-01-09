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
        <div class="my-4 lg:my-8 mx-4 md:mx-8 lg:mx-16 xl:mx-32">
<?php
	if($loginError !== "") {
?>
	
		<div class="p-4 my-4 rounded bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700" role="alert"><?php echo $loginError; ?></div>
<?php
	}
?>
	<form action="login.php" method="POST">
        <div class="flex flex-row gap-2 md:gap-3 xl:gap-5 flex-wrap">
            <div class="my-1">
				<h1 class="text-l lg:text-xl font-semibold">Login</h2>
			</div>
		</div>
        <div class="flex flex-row gap-2 md:gap-3 xl:gap-5 flex-wrap">
            <div class="my-1">
                <div class="rounded-md border border-gray-200 flex flex-auto">
                    <label for="password" class="p-1 lg:p-2 rounded-l-sm lg:font-semibold bg-gray-200">Password:</label>
                    <input class="p-1 lg:p-2 flex-auto" id="password" name="password" placeholder="*****" type="text">
                </div>
			</div>
		</div>
        <div class="flex flex-row gap-2 md:gap-3 xl:gap-5 flex-wrap">
            <div class="my-1">
				<button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-2 focus:ring-blue-200 font-medium rounded-lg text-sm px-2 lg:px-3 py-0.5 lg:py-1.5 focus:ring-blue-800 disabled:cursor-not-allowed disabled:bg-gray-400 disabled:from-gray-400 disabled:shadow-gray-800">Sign in</button>
			</div>
		</div>
	</form>
</div>
<?php require 'views/footer.php'; ?>
