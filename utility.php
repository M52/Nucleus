<?php
class NucleusUtility {
	private static $initialized = false;

	private static function Initialize()
	{
		if (self::$initialized)
		{
			// Our static class has been initialized and is ready to be used.
			return;
		} else {
			// Our static class has not yet been initialized, do so now.
			self::$initialized = true;
		}

	}

	public static function ShowError($msg)
	{
		// Every static method in this class needs to call self::Initialize();
		self::Initialize();
		echo "<center><div>".$msg."</div></center>";
		die("Error");
	}
}
?>