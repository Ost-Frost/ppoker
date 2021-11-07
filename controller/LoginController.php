<?php

    require("ControllerBasis.php");

    /**
     * controller for the login page
     */
    class LoginController extends ControllerBasis {


        public function validateUserPassword($userPassword) {
            if (password_verify($_POST["password"], $userPassword)) {
                return true;
            } else {
                return false;
            }
        }

        public function logInUser($userID) {
            $_SESSION["userID"] = $userID;
        }
    }

?>