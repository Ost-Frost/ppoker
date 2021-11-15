<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class CreateModel extends ModelBasis {

        public function createNewGame($createNewEpic) {

            $responses = [];
            $this->dbConnect();

            $epicID;
            if ($createNewEpic) {
                $epicName = $_POST["epicName"];
                $epicDescription = $_POST["epicDescription"];
                $date = date("Y-m-d");
                $epicID = uniqid();
                $sqlQuery = "INSERT INTO `epic` (`EpicID`, `Name`, `Beschreibung`, `Einrichtungsdatum`) ";
                $sqlQuery .= "VALUES ('$epicID', '$epicName', '$epicDescription', '$date')";
                $response = $this->dbSQLQuery($sqlQuery);
                array_push($responses, $response);
            } else {
                $epicName = $_POST["epicNameSelected"];
                $sqlQuery = "SELECT EpicID FROM epic WHERE Name='$epicName'";
                $response = $this->dbSQLQuery($sqlQuery);
                array_push($responses, $response);
                $epicID = $response->fetch_assoc()["EpicID"];
            }

            $gameTask = $_POST["gameTask"];
            $gameDescription = $_POST["gameDescription"];
            $date = date("Y-m-d");
            $gameID = uniqid();
            $sqlQuery = "INSERT INTO `spiele` (`SpielID`, `Task`, `Beschreibung`, `Einrichtungsdatum`) ";
            $sqlQuery .= "VALUES ('$gameID', '$gameTask', '$gameDescription', '$date')";
            $response = $this->dbSQLQuery($sqlQuery);
            array_push($responses, $response);

            $sqlQuery = "INSERT INTO `epicspiel` (`SpielID`, `EpicID`) ";
            $sqlQuery .= "VALUES ('$gameID', '$epicID')";
            $response = $this->dbSQLQuery($sqlQuery);
            if (!$response) {
                echo $sqlQuery;
            }
            array_push($responses, $response);

            $userID = $_SESSION["userID"];
            $sqlQuery = "INSERT INTO `spielkarte` (`SpielID`, `UserID`, `Karte`, `Akzeptiert`) ";
            $sqlQuery .= "VALUES ('$gameID', '$userID', '0', '1')";
            $response = $this->dbSQLQuery($sqlQuery);
            array_push($responses, $response);
            $this->dbClose();

            $successful = true;
            foreach($responses as $key => $response) {
                if (!$response) {
                    $successful = false;
                }
            }
            return $successful;
        }

        public function checkEpicName() {
            if (!isset($_POST["epicName"]) || $_POST["epicName"] === "") {
                return false;
            }
            $epicName = $_POST["epicName"];
            $sqlQuery = "SELECT Name FROM epic WHERE Name='$epicName'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            $epicExists = true;
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $epicExists = false;
            }
            return $epicExists;
        }

        public function checkTaskName() {
            $taskName = $_POST["gameTask"];
            $sqlQuery = "SELECT Task FROM spiele WHERE Task='$taskName'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            $taskExists = true;
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $taskExists = false;
            }
            return $taskExists;
        }
    }
?>