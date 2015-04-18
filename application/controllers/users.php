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
                        "deleted = ?" => false
                    ));

                if (!empty($user)) {
                    $session = Registry::get("session");
                    $session->set("user", serialize($user));
                    
                    header("Location: /social-network/user/profile");
                    exit();
                } else {
                    $view->set("password_error", "Email address and/or password are incorrect");
                }
            }
        }
    }

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

    public function settings() {
        $session = Registry::get("session");        
        $person = unserialize($session->get("user"));
        $view = $this->getActionView();
        
        if (RequestMethods::post("update")) {
            $updateUser = new User([
                "id" => $person->id,
                "created" => $person->created,
                "notes" => $person->notes,
                "deleted" => $person->deleted,
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
                $session->set("user", serialize($person));
                $view->set("success", true);
            } else {
                $view->set("errors", $updateUser->getErrors());
            }
        } else {
            $view->set("errors", NULL);
        }
        $view->set("person", $person);
    }

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
                "deleted = ?" => false
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

        header("Location: /social-network/user/login");
        exit();
    }
}
?>
