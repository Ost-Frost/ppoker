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
            $sqlQuery = "INSERT INTO `user` (`UserID`, `Vorname`, `Nachname`, `Mail`, `Passwort`, `Registrierungsdatum`) ";
            $sqlQuery .= "VALUES ('126', '$preName', '$lastName', '$email', '$password', '$date')";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            return $response;
        }

    }

?>