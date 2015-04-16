<?php
namespace Framework\Router\Exception {
	class Exception extends \Exception {
		public function __construct($message) {
			echo $message;
		}
	}
}

?>