<?php

class Session
{
	private $config = [];

	private static $_instance;

	public function __construct()
	{
		if (!file_exists(dirname(__DIR__).'/config/config.php')) {
			copy(dirname(__DIR__).'/config/config.php.TEMPLATE', dirname(__DIR__).'/config/config.php');
		}

		$this->config = require dirname(__DIR__).'/config/config.php';
		$session_expire = min(2147483647 - time() - 1, max($this->config["session_lifetime"], 86400));
		$session_name = "ydlw_sid";

		if ((!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off')) || $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			ini_set("session.cookie_secure", true);
		}

		ini_set("session.gc_probability", 75);
		ini_set("session.name", $session_name);
		ini_set("session.use_only_cookies", true);
		ini_set("session.gc_maxlifetime", $session_expire);
		ini_set("session.cookie_lifetime", min(0, $this->config["session_lifetime"]));
		session_start();

		if($this->config["security"])
		{
			if(!isset($_SESSION["logged_in"]))
			{
				$_SESSION["logged_in"] = false;
			}
		}
		else
		{
			$_SESSION["logged_in"] = true;
		}
	}

	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Session();
		}

		return self::$_instance;
	}

	public function login($password)
	{
		if($this->config["password"] === md5($password))
		{
			$_SESSION["logged_in"] = true;
			return true;
		}
		else
		{
			$_SESSION["logged_in"] = false;
			return false;
		}
	}

	public function is_logged_in()
	{
		return $_SESSION["logged_in"];
	}

	public function logout()
	{
		$_SESSION = array();
		session_destroy();
	}
}

?>
