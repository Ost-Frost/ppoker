<?php

    require("ControllerBasis.php");

    /**
     * controller for the login page
     */
    class LoginController extends ControllerBasis {


        /**
         * validates the password of the user
         *
         * @return boolean true if password and user combination is correct, false otherwise
         */
        public function validateUserPassword($userPassword) {
            if (password_verify($_POST["password"], $userPassword)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * logs in the user
         */
        public function logInUser($userID) {
            $_SESSION["userID"] = $userID;
        }
    }

?>