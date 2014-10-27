<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 23.10.2014
 * Time: 14:09
 */

class UserModel extends AbsModel {
    public function addUser(User $user) {
        $this->database->execute("Insert into users (username, password) VALUES ('$user->Name', '$user->Password')");
    }

    public function updateUserById($id, User $user) {
        $this->database->execute("Update users set username='$user->Name', password='$user->Password' where iduser=$id");
    }

    public function deleteUserById($id) {
        $this->database->execute("delete from users where iduser=$id");
    }

    public function getUserById($id) {
        $result = $this->database->executeWithResult("select iduser, username, password from users where iduser=$id");
        $user = new User();

        if (count($result) == 1) {
            $user->Id = $result[0][User::$ID];
            $user->Name = $result[0][User::$USERNAME];
            $user->Password = $result[0][User::$PASSWORD];
        }

        return $user;
    }
} 