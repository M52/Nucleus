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
}
?>