<?php
class NucleusUtility {
	private static $initialized = false;

	private static function Initialize()
	{
		if (self::$initialized)
			return; // Our static class has been initialized and is ready to be used.
		else
			self::$initialized = true; // Our static class has not yet been initialized, do so now.
	}

	public static function Error($msg)
	{
		// Every static method in this class needs to call self::Initialize();
		self::Initialize();
		echo "<center><div>".$msg."</div></center>";
	}

	public static function Debug($header, $msg)
	{
		self::Initialize();
		echo "<center><div style='width:400px;height:auto;background:#aeaeae;border:1px solid black;font-family:Tahoma;'><h4>".$header."
		</h4><p style='color:#1f1f1f;'>".$msg."</p></div></center>";
	}

// REFACTOR ME
	public static function EncryptPassword($_password)
	{
		self::Initialize();
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		echo "<br />";
		$hash = crypt($_password, $salt);
		echo "<br />Hash: " . $hash . "<br />";
	}
}
?>