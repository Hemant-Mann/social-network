<?php
namespace Framework\Router\Exception {
	class Implementation extends \Exception {
		public function __construct($message) {
			echo $message;
		}
	}
}

?>