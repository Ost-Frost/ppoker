<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class RegisterModel extends ModelBasis {

        public function addUser() {
            $preName = $_POST["preName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $userName = $_POST["userName"];
            $date = date("Y-m-d");
            $userid = uniqid();
            $sqlQuery = "INSERT INTO `user` (`UserID`, `Username`, `Vorname`, `Nachname`, `Mail`, `Passwort`, `Registrierungsdatum`) ";
            $sqlQuery .= "VALUES ('$userid', '$userName', '$preName', '$lastName', '$email', '$password', '$date')";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            return $response;
        }

        public function checkUserName() {
            $userName = $_POST["userName"];
            $sqlQuery = "SELECT Username FROM user WHERE Username='$userName'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            $userExists = true;
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $userExists = false;
            }
            return $userExists;
        }

        public function checkEmail() {
            $email = $_POST["email"];
            $sqlQuery = "SELECT Mail FROM user WHERE Mail='$email'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            $userExists = true;
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $userExists = false;
            }
            return $userExists;
        }

    }

?>