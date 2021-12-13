<?php

    require("ModelBasis.php");

    /**
     * model for the login page
     */
    class LoginModel extends ModelBasis {

        /**
         * gets the registered userData of given userName
         *
         * @return mixed returns an array with the userID and the password of the user or false if the user does not exist
         */
        public function getUserData() {
            $userName = $_POST['userName'];
            $sql = "SELECT Passwort, UserID FROM user WHERE Username='$userName' OR Mail='$userName'";
            $query = $this->dbSQLQuery($sql);
            if (!$query) {
                return false;
            }
            $userData = mysqli_fetch_assoc($query);
            if (!$userData) {
                return false;
            }
            return [
                "userID" => $userData["UserID"],
                "password" => $userData["Passwort"]
            ];
        }
    }

?>