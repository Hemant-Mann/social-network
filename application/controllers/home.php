<?php

use Framework\Controller as Controller;

class Home extends Controller {
    public function index() {
        $user = $this->getUser();
        $view = $this->getActionView();

        if($user) {
        	$friends = Friend::all([
	        		"user = ?" => $user->id,
	        		"live = ?" => true,
	        		"deleted = ?" => false
        		],
        		["friend"]
        	);

        	$ids = [];
        	foreach ($friends as $friend) {
        		$ids[] = $friend->friend;
        	}

        	$messages = Message::all([
	        		"user in ?" => $ids,
	        		"live = ?" => true,
	        		"deleted = ?" => false
        		],[
        			"*",
        			"(SELECT CONCAT(first, \"\", last) FROM user WHERE user.id = message.user)" => "user_name"
        		], "created", "asc"
        	);
        }
    }
}
?>