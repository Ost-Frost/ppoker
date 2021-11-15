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
            $userName = str_replace("%", "\%", $userName);
            $userName = str_replace("_", "\_", $userName);
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
            $epicName = str_replace("%", "\%", $epicName);
            $epicName = str_replace("_", "\_", $epicName);
            $userID = $_SESSION["userID"];
            $response = [];
            $sqlQueryEpicID = "SELECT e.EpicID FROM epicspiel e INNER JOIN spiele s ON e.SpielID = s.SpielID INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID WHERE sk.UserID='$userID'";
            $this->dbConnect();
            $resultID = $this->dbSQLQuery($sqlQueryEpicID);
            while ($row = mysqli_fetch_assoc($resultID)) {
                $epicID = $row["EpicID"];
                $sqlQueryEpics = "SELECT Name FROM epic WHERE (Name LIKE '$epicName%') AND EpicID='$epicID'";
                $resultEpic = $this->dbSQLQuery($sqlQueryEpics);
                if($epics=$resultEpic->fetch_assoc()) {
                    $alreadyFound = false;
                    foreach ($response as $foundEpicName) {
                        if ($foundEpicName === $epics["Name"]) {
                            $alreadyFound = true;
                        }
                    }
                    if (!$alreadyFound) {
                        array_push($response, $epics["Name"]);
                    }
                } else {
                    continue;
                }
            }
            $this->dbClose();
            if (count($response) === 0) {
                return [];
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
            $createEpic = false;
            $epicName = "";
            $taskEpic = "";
            $descriptionEpic = "";
            $invitations = [];

            $date = date("Y-m-d");
            $userID = $_SESSION["userID"];
            $epicID = "";
            $gameID = uniqid();

            if(isset($_POST["epicName"])) {
                $epicName = $_POST["epicName"];
                $sqlQueryEpicID = "SELECT EpicID FROM epic WHERE Name='$epicName'";
                $resultEpicID = $this->dbSQLQuery($sqlQueryUserID);
                if($id = $resultEpicID->fetch_assoc()) {
                    $epicID = $id["EpicID"];
                } else {
                    return false; // maybe other error return value for case: Epic Task not saved in db yet
                }
            } else {
                $taskEpic = $_POST["taskEpic"];
                $descriptionEpic = $_POST["descriptionEpic"];
                $sqlQueryEpicID = "SELECT EpicID FROM epic WHERE Name='$taskEpic'";
                $resultEpicID = $this->dbSQLQuery($sqlQueryUserID);
                if($id = $resultEpicID->fetch_assoc()) {
                    $epicID = $id["EpicID"];
                    $createEpic = true;
                    $epicID = uniqid();
                } else {
                    return false; // maybe other error return value for case: Epic Task already taken
                }
            }
            if(isset($_POST["invitations"])) {
                $invitations = $_POST["invitations"];
            }

            $sqlQueryGame = "INSERT INTO `spiele` (`SpielID`, `Einrichtungsdatum`, `Task`, `Beschreibung`) ";
            $sqlQueryGame .= "VALUES ('$gameID', '$date', '$task', '$description')";
            $sqlQueryGameUser = "INSERT INTO `spielkarte` (`UserID`, `SpielID`)";
            $sqlQueryGameUser .= "VALUE ('$userID', '$gameID') ";

            if($createEpic) {
                $sqlQueryEpic = "INSERT INTO `epic` (`EpicID`, `Name`, `Beschreibung`, `Einrichtungsdatum`)";
                $sqlQueryEpic .= "VALUE ('$epicID', '$taskEpic', '$descriptionEpic', '$date') ";
                $sqlQueryEpicUser = "INSERT INTO `epicuser` (`EpicID`, `UserID`)";
                $sqlQueryEpicUser .= "VALUE ('$epicID', '$userID') ";
            }

            $sqlQueryEpicGame = "INSERT INTO `epicspiel` (`EpicID`, `SpielID`)";
            $sqlQueryEpicGame .= "VALUE ('$epicID', '$gameID') ";

            $this->dbConnect();

            $result0 = $this->dbSQLQuery($sqlQueryGame);
            $result1 = $this->dbSQLQuery($sqlQueryEpic);
            $result2 = $this->dbSQLQuery($sqlQueryEpicGame);
            $result3 = $this->dbSQLQuery($sqlQueryEpicUser);
            $result4 = $this->dbSQLQuery($sqlQueryGameUser);

            foreach($invitations as $members => $member) {
                $sqlQueryUserID = "SELECT UserID FROM user WHERE Username='$member'";
                $resultID = $this->dbSQLQuery($sqlQueryUserID);
                if($uID = $resultID->fetch_assoc()) {
                    $uIDTemp = $uID["UserID"];
                    $sqlQueryEpicUser = "INSERT INTO `epicuser` (`EpicID`, `UserID`)";
                    $sqlQueryEpicUser .= "VALUE ('$epicID', '$uIDTemp') ";
                    $sqlQueryGameUser = "INSERT INTO `spielkarte` (`UserID`, `SpielID`)";
                    $sqlQueryGameUser .= "VALUE ('$uIDTemp', '$gameID') ";
                    $result5 = $this->dbSQLQuery($sqlQueryEpicUser);
                    $result6 = $this->dbSQLQuery($sqlQueryGameUser);
                }
            }
            $this->dbClose();
            $response = $epicName;
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