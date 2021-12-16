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
            $sqlQueryEpics = "SELECT e.Name FROM epic e INNER JOIN epicuser u ON e.EpicID = u.EpicID WHERE u.UserID='$userID' AND u.UserStatus='1' AND (e.Name LIKE '$epicName%') ORDER BY e.Name ASC";
            $this->dbConnect();
            $results = $this->dbSQLQuery($sqlQueryEpics);
            while ($row = mysqli_fetch_assoc($results)) {
                array_push($response, $row["Name"]);
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
            $gameID = $_POST["gameID"];

            $this->dbConnect();
            $gameEpic = false;
            $gameEpicSQLQuery = "SELECT EpicID FROM `epicspiel` WHERE SpielID = '$gameID'";
            $gameEpicResponse = $this->dbSQLQuery($gameEpicSQLQuery);
            $gameEpicResponse = $gameEpicResponse->fetch_assoc();
            if ($gameEpicResponse) {
                $gameEpic = $gameEpicResponse["EpicID"];
            }
            $this->dbClose();

            $sqlQuery = "DELETE FROM `spiele` WHERE SpielID = '$gameID'";

            $gameStructure = $this->getGameStructure();
            $sqlQueryEpic = false;
            foreach ($gameStructure["allEpic"] as $epic) {
                if ($epic["EpicID"] == $gameEpic) {
                    if (count($epic["games"])) {
                        $sqlQueryEpic = "DELETE FROM `epic` WHERE EpicID = '$gameEpic'";
                    }
                }
            }

            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            $response2 = true;
            if ($sqlQueryEpic) {
                $response2 = $this->dbSQLQuery($sqlQueryEpic);
            }
            $this->dbClose();

            if ($response) {
                if ($response2) {
                    return true;
                }
            }
            return false;
        }

        /**
         * writes in the database that the logged in user left the given game
         *
         * @return boolean true if the database operation was successful, false otherwise
         */
        public function leaveGame() {
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "UPDATE spielkarte SET UserStatus='3' WHERE UserID='$userID' AND SpielID='$gameID'";
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
         * checks if logged in user has given userstatus in game with given gameid
         *
         * @param int $userStatus user Status to check for
         * @return boolean true if he has the userstatus, false otherwise
         */
        public function checkUserStatus($userStatus) {
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "SELECT UserStatus FROM spielkarte WHERE UserID='$userID' AND SpielID='$gameID' AND UserStatus='$userStatus'";
            return $this->checkSQLQuery($sqlQuery);
        }

        /**
         * checks if the logged in user is the host of the game with given gameID
         *
         * @return boolean true the the user is the host, false otherwise
         */
        public function checkGameHost() : mixed {
            $gameID = $_POST["gameID"];
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
            $value = $_POST["value"];
            $gameID = $_POST["gameID"];
            $userID = $_SESSION['userID'];
            $epicID = "";

            $sqlQuery = "UPDATE `spielkarte` SET `Karte`='$value', `Akzeptiert`=2 WHERE UserID='$userID' AND SpielID='$gameID'";
            $sqlQueryEpicID = "SELECT EpicID FROM `epicspiel` WHERE SpielID='$gameID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $epicIDResult = $this->dbSQLQuery($sqlQueryEpicID);

            if($epicResult = $epicIDResult->fetch_assoc()) {
                $epicID = $epicResult["EpicID"];
            }
            $this->dbClose();

            if(!$result) {
                return false;
            }
            $gameUpdated = $this->valueUpdateGame($gameID);
            $epicUpdated = $this->valueUpdateEpic($epicID);
            return true;
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
            $sqlQuery = "SELECT SpielID FROM spielkarte WHERE SpielID='$gameID' AND UserID='$userID'";
            return $this->checkSqlQuery($sqlQuery);
        }

        /**
         * Updates value of all cards for a games
         *
         * @return boolean in case of successful update true, otherwise false
         */
        public function valueUpdateGame($gameID) {

            $this->dbConnect();

            $sqlQueryCardValue = "SELECT Karte FROM `spielkarte` WHERE SpielID='$gameID'";
            $allCards = $this->dbSQLQuery($sqlQueryCardValue);

            $valueAll = 0;
            while($card = $allCards->fetch_assoc()) {
                $valueAll = $valueAll + $card["Karte"];
            }
            $sqlQuery = "UPDATE `spiele` SET Aufwand='$valueAll' WHERE SpielID='$gameID'";
            $result = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            if($result) {
                return true;
            }
            return false;
        }

        /**
         * Updates value of all cards for an Epic
         *
         * @return boolean in case of successful update true, otherwise false
         */
        public function valueUpdateEpic($epicID) {

            $this->dbConnect();

            $sqlQueryGameID = "SELECT SpielID FROM `epicspiel` WHERE EpicID='$epicID'";
            $allGames = $this->dbSQLQuery($sqlQueryGameID);

            $value = 0;
            while($game = $allGames->fetch_assoc()) {
                $gameID = $game["SpielID"];
                $sqlQueryValue = "SELECT Aufwand FROM `spiele` WHERE SpielID='$gameID'";
                $allValues = $this->dbSQLQuery($sqlQueryValue);
                if($values = $allValues->fetch_assoc()) {
                    $value = $value + $values["Aufwand"];
                }
            }
            $sqlQuery = "UPDATE `epic` SET Aufwand='$value' WHERE EpicID='$epicID'";
            $result = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            if($result) {
                return true;
            }
            return false;
        }
    }

?>