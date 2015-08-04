<?php
// This is the installer file that needs to be ran to set up Nucleus on a PHP/MySQL server.
// This file should remove/disable itself after completing to prevent malicious usage.
class NucleusInstaller 
{
	private static $initialized = false;
	public static $TABLE_USER; 
	public static $TABLE_GENDER;

	private static function Initialize()
	{
		if (self::$initialized)
			return; // Our static class has been initialized and is ready to be used.
		else
		{
			self::$TABLE_USER = "n_User";
			self::$TABLE_GENDER = "n_Gender";

			define("SQL_CREATE_N_USER",
			"CREATE TABLE ".self::$TABLE_USER."
			(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				username VARCHAR(60) UNIQUE NOT NULL,
				password VARCHAR(200) NOT NULL,
				profile_name VARCHAR(60),
				profile_surname VARCHAR(60),
				gender_id INT(2) UNSIGNED NOT NULL
			) Engine=InnoDB;");

			define("SQL_CREATE_N_GENDER",
			"CREATE TABLE ".self::$TABLE_GENDER."
			(
				gender_id INT(2) UNSIGNED PRIMARY KEY,
				gender VARCHAR(10) NOT NULL UNIQUE
			) Engine=InnoDB;");

			self::$initialized = true; // Our static class has not yet been initialized, do so now.
		}
	}

	public static function InstallDatabase($_NucleusDatabaseObj)
	{
		self::Initialize();
		if ($_NucleusDatabaseObj->hasConnection())
		{
			$_NucleusDatabaseObj->Query("USE {$_NucleusDatabaseObj->getDatabaseName()};");
			NucleusUtility::Debug(__CLASS__."::".__LINE__." (".__FILE__.")", "Established connection with Database {$_NucleusDatabaseObj->getDatabaseName()}");
			if ($_NucleusDatabaseObj->TableExists(self::$TABLE_USER))
				$_NucleusDatabaseObj->Query("DROP TABLE ".self::$TABLE_USER);
			if ($_NucleusDatabaseObj->TableExists(self::$TABLE_GENDER))
				$_NucleusDatabaseObj->Query("DROP TABLE ".self::$TABLE_GENDER);
			$_NucleusDatabaseObj->Query(SQL_CREATE_N_USER);
			$_NucleusDatabaseObj->Query(SQL_CREATE_N_GENDER);
			NucleusUtility::Debug(__CLASS__."::".__LINE__." (".__FILE__.")", "Tables N_USER & N_GENDER created.");
			$_NucleusDatabaseObj->Query("INSERT INTO ".self::$TABLE_GENDER." (gender_id, gender) VALUES (0, 'MALE')");
			$_NucleusDatabaseObj->Query("INSERT INTO ".self::$TABLE_GENDER." (gender_id, gender) VALUES (1, 'FEMALE')");
			$_NucleusDatabaseObj->Query("INSERT INTO ".self::$TABLE_GENDER." (gender_id, gender) VALUES (2, 'OTHER')");
		}

	}
}
?>