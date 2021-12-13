<?php

    require("ModelBasis.php");

    /**
     * model for the Game page
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
            $sqlQuery = "SELECT Username, UserID FROM user WHERE (Username LIKE '$userName%' OR Mail LIKE '$userName%') ORDER BY Username ASC";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            while ($row = mysqli_fetch_assoc($result)) {
                $foundUserName = $row["Username"];
                if ($row["UserID"] === $_SESSION["userID"]) {
                    continue;
                }
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
                $sqlQueryEpics = "SELECT Name FROM epic WHERE (Name LIKE '$epicName%') AND EpicID='$epicID' ORDER BY Name ASC";
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
         * deletes the game with the requested gameID
         *
         * @return mixed SQL query response
         */
        public function deleteGame() : mixed {
            $gameID = $_POST["gameid"];

            $this->dbConnect();
            $gameEpic = false;
            $gameEpicSQLQuery = "SELECT EpicID FROM `epicspiel` WHERE SpielID = '$gameID'";
            $gameEpicResponse = $this->dbSQLQuery($gameEpicSQLQuery);
            $gameEpicResponse = $gameEpicResponse->fetch_assoc();
            if ($gameEpicResponse) {
                $gameEpic = $gameEpicResponse["EpicID"];
            }

            $sqlQuery = "DELETE FROM `spiele` WHERE `spiele`.`SpielID` = $gameID";
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            return $response;
        }

        /**
         * writes in the database that the logged in user left the given game
         *
         * @return boolean true if the database operation was successful, false otherwise
         */
        public function leaveGame() {
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "UPDATE spielkarte SET UserStatus='4' WHERE UserID='$userID' AND SpielID='$gameID'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            return $response;
        }

        /**
         * writes in the database that the logged in user accepted the given game
         *
         * @return boolean true if the database operation was successful, false otherwise
         */
        public function acceptGame() {
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "UPDATE spielkarte SET UserStatus='2' WHERE UserID='$userID' AND SpielID='$gameID'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            return $response;
        }

        /**
         * writes in the database that the logged in user declined the given game
         *
         * @return boolean true if the database operation was successful, false otherwise
         */
        public function declineGame() {
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "UPDATE spielkarte SET UserStatus='4' WHERE UserID='$userID' AND SpielID='$gameID'";
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();
            return $response;
        }

        /**
         * checks if the logged in user is the host of the game with given gameID
         *
         * @return boolean true the the user is the host, false otherwise
         */
        public function checkGameHost() : mixed {
            $gameID = $_POST["gameid"];
            $userID = $_SESSION["userID"];

            $sqlQuery = "SELECT * FROM `spielkarte` WHERE SpielID = '$gameID' AND UserID = '$userID' AND UserStatus = '1'";

            return $this->checkSQLQuery($sqlQuery);
        }

        /**
         * gets data for the search API and returns it as an array by searching for every userName or eMail that starts with the requested string
         *
         * @return mixed if at least one user was found the method returns an array with all users, otherwise it returns false
         */
        public function playCard() {
            $value = $_REQUEST["value"];
            $gameID = $_REQUEST["gameID"];
            $userID = $_SESSION['userID'];

            $sqlQuery = "UPDATE `spielkarte` SET Karte='$value' Akzeptiert='2' WHERE UserID='$userID' AND SpielID='$gameID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            if($row = $response->fetch_assoc()) {
                if($row == 0) {
                    return false;
                }
                return true;
            }
            return false;
        }

        /**
         * checks if the given gameID exists
         *
         * @return boolean true the gameID exists, false otherwise
         */
        public function checkGameID() {
            if (!isset($_POST["gameID"]) || $_POST["gameID"] === "") {
                return false;
            }
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "SELECT s.SpielID FROM spiele s INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID ";
            $sqlQuery .= "WHERE sk.UserID='$userID' AND s.SpielID='$gameID' AND sk.UserStatus='0'";
            return $this->checkSqlQuery($sqlQuery);
        }
    }

?>