<?php

use Shared\Controller as Controller;
use Framework\Registry as Registry;
use Framework\RequestMethods as RequestMethods;

class Users extends Controller {

    public function register() {
        $view = $this->getActionView();

        if (RequestMethods::post("register")) {
            $user = new User([
                "first" => RequestMethods::post("first"),
                "last" => RequestMethods::post("last"),
                "email" => RequestMethods::post("email"),
                "password" => RequestMethods::post("password")
            ]);

            if ($user->validate()) {
                $user->save();
                $this->_upload("photo", $user->id);
                $view->set("success", true);
            } else {
                $view->set("errors", $user->getErrors());
            }
        } else {
            $view->set("errors", NULL);
        }   
    }
    
    public function login() {
        if (RequestMethods::post("login")) {
            $email = RequestMethods::post("email");
            $password = RequestMethods::post("password");

            $view = $this->getActionView();
            $error = false;

            if (empty($email)) {
                $view->set("email_error", "Email not provided");
                $error = true;
            }

            if (empty($password)) {
                $view->set("password_error", "Password not provided");
                $error = true;
            }

            if (!$error) {
                $user = User::first(array(
                        "email = ?" => $email,
                        "password = ?" => $password,
                        "live = ?" => true,
                    ));

                if (!empty($user)) {
                    $session = Registry::get("session");
                    $session->set("user", serialize($user));
                    
                    header("Location: /social-network/profile");
                    exit();
                } else {
                    $view->set("password_error", "Email address and/or password are incorrect");
                }
            }
        }
    }

    /**
    * @before _secure
    */
    public function profile() {
        $session = Registry::get("session");        
        $person = unserialize($session->get("user"));
        
        if (empty($person)) {
            $person = new StdClass();
            $person->first = "Mr.";
            $person->last = "Smith";
        }
        
        $this->getActionView()->set("person", $person);
    }

    /**
    * @before _secure
    */
    public function settings() {
        $session = Registry::get("session");        
        $person = unserialize($session->get("user"));
        $view = $this->getActionView();
        $view->set("errors", NULL);

        if (RequestMethods::post("update")) {
            $updateUser = new User([
                "id" => $person->id,
                "created" => $person->created,
                "notes" => $person->notes,
                "live" => true,
                "first" => RequestMethods::post("first", $person->first),
                "last" => RequestMethods::post("last", $person->last),
                "email" => RequestMethods::post("email", $person->email),
                "password" => RequestMethods::post("password", $person->password)
            ]);

            if ($updateUser->validate()) {
                $updateUser->save();
                $person->first = $updateUser->first;
                $person->last = $updateUser->last;
                $person->email = $updateUser->email;
                $person->password = $updateUser->password;
                $this->_upload("photo", $person->id);
                $session->set("user", serialize($person));
                $view->set("success", true);
            } else {
                $view->set("errors", $updateUser->getErrors());
            }
        }
        
        $view->set("person", $person);
    }

    /**
    * @before _secure
    */
    public function search() {
        $view = $this->getActionView();

        $query = RequestMethods::post("query");
        $order = RequestMethods::post("order", "modified");
        $direction = RequestMethods::post("direction", "desc");
        $page = RequestMethods::post("page", 1);
        $limit = RequestMethods::post("limit", 10);

        $count = 0;
        $users = false;

        if (RequestMethods::post("search")) {
            $where = [
                "SOUNDEX(first) = SOUNDEX(?)" => $query,
                "live = ?" => true,
            ];

            $fields = [
                "id", "first", "last"
            ];

            $count = User::count($where);
            $users = User::all($where, $fields, $order, $direction, $limit, $page);
        }

        $view
                ->set("query", $query)
                ->set("order", $order)
                ->set("direction", $direction)
                ->set("page", $page)
                ->set("limit", $limit)
                ->set("count", $count)
                ->set("users", $users);
    }

    public function logout() {
        $this->setUser(false);
        $session = Registry::get("session");
        $session->erase("user");

        header("Location: /social-network/login");
        exit();
    }

    /**
    * @before _secure
    */
    public function friend($id) {
        $user = $this->getUser();

        // Check if the person was unfriended before
        $friend = Friend::first([
            "user = ?" => $user->id,
            "friend = ?" => $id,
            "deleted = ?" => true
        ]);

        // If not then add a new entry in friend's table
        if(!$friend) {
            $friend = new Friend([
                "user" => $user->id,
                "friend" => $id
            ]);
        } else {
            // set the deleted to false
            $friend->deleted = false;
        }

        $friend->save();    // save the entry whether UPDATE/INSERT in the db
        header("Location: /social-network/search");
        exit();
    }

    /**
    * @before _secure
    */
    public function unfriend($id) {
        $user = $this->getUser();

        $friend = Friend::first([
            "user = ?" => $user->id,
            "friend = ?" => $id,
            "live = ?" => true
        ]);

        if ($friend) {
            // Just set the deleted attribute of the friend to false
            $friend->deleted = true;
            $friend->save();
        }
        header("Location: /social-network/search");
        exit();
    }

    /**
    * @protected
    */
    public function _secure() {
        $user = $this->getUser();
        if(!$user) {
            header("Location: /social-network/login");
            exit();
        }
    }

    protected function _upload($name, $user) {
        if (isset($_FILES[$name]) && !empty($_FILES[$name]['name'])) {
            $file = $_FILES[$name];
            $path = APP_PATH."/public/uploads/";

            $time = time();
            $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
            $filename = "{$user}-{$time}.{$extension}";

            if (move_uploaded_file($file["tmp_name"], $path.$filename)) {
                $meta = getimagesize($path.$filename);

                if ($meta) {
                    $width = $meta[0];
                    $height = $meta[1];

                    $findFile = File::first([
                            "user" => $user,
                            "live" => true
                        ]);

                    // If pic is found then set deleted attribute to true
                    if($findFile) {
                        $findFile->deleted = true;
                        $findFile->save();
                    }

                    $newFile = new File([
                        "name" => $filename,
                        "mime" => $file["type"],
                        "size" => $file["size"],
                        "width" => $width,
                        "height" => $height,
                        "user" => $user
                    ]);
                    $newFile->save();
                }
            } else {
                throw new Exception("Error in moving uploaded file", 1);  
            }
        }
    }
}
?>
