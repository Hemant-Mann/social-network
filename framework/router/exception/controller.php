<?php
namespace Framework\Router\Exception {
	class Controller extends \Exception {
		public function __construct($message) {
			echo $message;
		}
	}
}

?>