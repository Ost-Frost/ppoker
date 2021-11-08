<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class GameModel extends ModelBasis {

        /**
         * initalizes a new game in the database, by adding a new game to the spiele table
         * and adding a relation to the user that created the game in the spielkarte tabe.
         *
         * @return array returns an array with the SQL responses.
         *               Index 0: the response of the new entry in spiele table
         *               Index 1: the response of the new entry in spielkarte table
         */
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

        /**
         * deletes the game with the requested gameID
         *
         * @return mixed SQL query response
         */
        public function deleteGame() : mixed {
            $gameID = $_POST["gameid"];

            $sqlQuery = "DELETE FROM `spiele` WHERE `spiele`.`SpielID` = $gameID";

            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            return $response;
        }

    }

?>