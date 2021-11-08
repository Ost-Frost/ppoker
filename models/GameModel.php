<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class GameModel extends ModelBasis {

        public function createGame() : array {

            $task = $_POST["task"];
            $description = $_POST["description"];
            $date = date("Y-m-d");

            $userID = $_SESSION["userID"];
            $gameID = uniqid();

            $sqlQuery = "INSERT INTO `spiele` (`SpielID`, `Einrichtungsdatum`, `Task`, `Beschreibung`) ";
            $sqlQuery .= "VALUES ('$gameID', '$date', '$task', '$description')";
            $sqlQuery2 = "INSERT INTO `spielkarte` (`SpielID`, `UserID`)";
            $sqlQuery2 .= "VALUE ('$gameID', '$userID') ";
            $this->dbConnect();
            $responseGame[0] = $this->dbSQLQuery($sqlQuery);
            $responseCard[1] = $this->dbSQLQuery($sqlQuery2);
            $this->dbClose();
            $response = [$responseGame, $responseCard];
            return $response;
        }

        public function deleteGame() {
            $gameID = $_POST["gameid"];

            $sqlQuery = "DELETE FROM `spiele` WHERE `spiele`.`SpielID` = $gameID";

            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            return $response;
        }

    }

?>