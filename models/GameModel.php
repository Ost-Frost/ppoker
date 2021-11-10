<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class GameModel extends ModelBasis {

        /**
         * gets data for the search API and returns it as an array by searching for every userName or eMail that starts with the requested string
         *
         * @return mixed if at least one user was found the method returns an array with all users, otherwise it returns false
         */
        public function searchUser() : mixed {

            $userName = $_GET["userName"];
            $response = [];
            $sqlQuery = "SELECT Username FROM user WHERE (Username LIKE '$userName%' OR Mail LIKE '$userName%')";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            while ($row = mysqli_fetch_assoc($result)) {
                $foundUserName = $row["Username"];
                array_push($response, $foundUserName);
            }
            $this->dbClose();
            if (count($response) === 0) {
                return false;
            }
            return $response;
        }

        /**
         * gets data for the search API and returns it as an array by searching for every epicName that starts with the requested string
         *
         * @return mixed if at least one user was found the method returns an array with all epics, otherwise it returns false
         */
        public function searchEpic() : mixed {
            $epicName = $_GET["epicName"];
            $userID = $_SESSION["userID"];
            $response = [];
            $allEpics = [];
            $foundEpicName = [];
            $sqlQueryGameID = "SELECT SpielID FROM spielkarte WHERE UserID='$userID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQueryGameID);
            while ($row = mysqli_fetch_assoc($result)) {
                $gameID = $row["SpielID"];
                $sqlQueryEpics = "SELECT EpicID FROM epicspiel WHERE SpielID='$gameID'";
                $resultEpic = $this->dbSQLQuery($sqlQueryEpics);
                if($epics=$resultEpic->fetch_assoc()) {
                    array_push($allEpics, $epics["EpicID"]);
                } else {
                    continue;
                }
            }
            $allEpics = $this->checkDouble($allEpics);
            foreach($allEpics as $row) {
                $sqlQuerySearch = "SELECT Name FROM epic WHERE (Name LIKE '$epicName%') AND EpicID='$row'";
                $resultSearch = $this->dbSQLQuery($sqlQuerySearch);
                if($search=$resultSearch->fetch_assoc()) {
                    array_push($foundEpicName, $search["Name"]);
                } else {
                    continue;
                }
            }
            $response = $foundEpicName;
            $this->dbClose();
            if (count($response) === 0) {
                return false;
            }
            return $response;
        }

        /**
         * checks array for double values
         *
         * @return array with all doubled values removed
         */
        private function checkDouble($array) : array {
            $addV = true;
            $uniqueArray = [];
            foreach($array as $field => $value) {
                foreach($uniqueArray as $doubleField => $doubleValue) {
                    if($value == $doubleValue) {
                        $addV = false;
                        break;
                    }
                }
                if($addV) {
                    array_push($uniqueArray, $value);
                }
            }
            return $uniqueArray;
        }

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