<?php
namespace Framework\Router\Exception {
	class Action extends \Exception {
		public function __construct($message) {
			echo $message;
		}
	}
}
?>