<?php

    require("ControllerBasis.php");

    /**
     * controller for the Logout page
     */
    class LogOutController extends ControllerBasis {

        /**
         * unsets userID in Session to log out
         */
        public function logOut() {
            unset($_SESSION["userID"]);
        }
    }

?>