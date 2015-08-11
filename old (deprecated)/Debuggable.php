<?php
class Debuggable {
	protected $debugger;

	public function RegisterDebugger($_debugger_)
	{
		$debugger = $_debugger_;
	}
}
?>