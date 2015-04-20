<?php
use Shared\Controller as Controller;
use Framework\ArrayMethods as ArrayMethods;
use Framework\Registry as Registry;
use Framework\StringMethods as StringMethods;

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

        	$findMessages = Message::all([
	        		"user in ?" => $ids,
	        		"live = ?" => true,
	        		"deleted = ?" => false
        		],["*"], "created", "asc"
        	);

            $messages = [];
            foreach ($findMessages as $msg) {
                 $user = User::first([
                        "id = ?" => $msg->user
                    ], ["first", "last"]
                );

                 $messages[] = [
                    "id" => $msg->id,
                    "user" => $msg->user,
                    "by" => $user->first. " ". $user->last,
                    "body" => $msg->body,
                    "created" => $msg->created,
                    "modified" => $msg->modified
                 ];
            }

            $view->set("messages", ArrayMethods::toObject($messages));
        }
    }
}
?>