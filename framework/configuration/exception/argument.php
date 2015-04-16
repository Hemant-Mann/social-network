<?php
namespace Framework\Configuration\Exception {
	class Argument extends \Framework\Core\Exception {
		public function __construct($message) {
			echo $message;
			$this->execute($this);
			set_exception_handler("execute");
		}

		private function execute($e) {
			return;
		}
	}
}
?>