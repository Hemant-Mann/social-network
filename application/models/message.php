<?php
class Message extends Shared\Model {
	/**
	* @column
	* @readwrite
	* @type text
	* @length 256
	*
	* @validate required
	* @label body
	*/
	protected $_body;
	
	/**
	* @column
	* @readwrite
	* @type integer
	*/
	protected $_message;
	
	/**
	* @column
	* @readwrite
	* @type integer
	*/
	protected $_user;

	public function getReplies() {
		return self::all([
				"message = ?" => $this->getId(),
				"live = ?" => true,
				"deleted = ?" => false,
			], ["*"], "created", "desc"
		);
	}

	public static function fetchReplies($id) {
		$message = new Message([
				"id" => $id
			]
		);
		return $message->getReplies();
	}
}

?>