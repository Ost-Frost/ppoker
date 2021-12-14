<?php

    require("ModelBasis.php");

    /**
     * model for the create page
     */
    class CreateModel extends ModelBasis {

        /**
         * adds new game to the database
         * invites a list of users
         *
         * @param string $epicCreationMode determines if a new epic should be created and if the game should be added to an epic:
         *                  - "create": creates new epic and adds game to newly created epic
         *                  - "select": adds game to an existing epic
         *                  - "none": adds game to no epic
         * @param array $invitations a list of userName strings that should be invited to the game
         * @return boolean true if all database operations where successful, false otherwise
         */
        public function createNewGame($epicCreationMode, $invitations) {

            $responses = [];
            $this->dbConnect();

            $epicID = false;
            if ($epicCreationMode === "create") {
                $epicName = $_POST["epicName"];
                $epicDescription = $_POST["epicDescription"];
                $date = date("Y-m-d");
                $epicID = uniqid();
                $sqlQuery = "INSERT INTO `epic` (`EpicID`, `Name`, `Beschreibung`, `Einrichtungsdatum`) ";
                $sqlQuery .= "VALUES ('$epicID', '$epicName', '$epicDescription', '$date')";
                $response = $this->dbSQLQuery($sqlQuery);
                array_push($responses, $response);
            } else if ($epicCreationMode === "select"){
                $epicName = $_POST["epicNameSelected"];
                $userID = $_SESSION["userID"];
                $sqlQuery = "SELECT e.EpicID FROM epic e INNER JOIN epicspiel es ON e.EpicID = es.EpicID INNER JOIN spiele s ON es.SpielID = s.SpielID ";
                $sqlQuery .= "INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID WHERE sk.UserID='$userID' AND e.Name='$epicName'";
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

            if ($epicID) {
                $sqlQuery = "INSERT INTO `epicspiel` (`SpielID`, `EpicID`) ";
                $sqlQuery .= "VALUES ('$gameID', '$epicID')";
                $response = $this->dbSQLQuery($sqlQuery);
                array_push($responses, $response);
            }

            $userID = $_SESSION["userID"];
            $sqlQuery = "INSERT INTO `spielkarte` (`SpielID`, `UserID`, `Karte`, `UserStatus`, `Akzeptiert`) ";
            $sqlQuery .= "VALUES ('$gameID', '$userID', '0', '1', '0')";
            $response = $this->dbSQLQuery($sqlQuery);
            array_push($responses, $response);

            if (!$this->checkEpicUserExists($userID, $epicID) && $epicID) {
                $sqlQuery = "INSERT INTO `epicuser` (`EpicID`, `UserID`, `UserStatus`) ";
                $sqlQuery .= "VALUES ('$epicID', '$userID', '1')";
                $response = $this->dbSQLQuery($sqlQuery);
                array_push($responses, $response);
            }

            foreach($invitations as $userName) {
                $sqlQueryUserID = "SELECT UserID FROM user WHERE Username='$userName'";
                $response = $this->dbSQLQuery($sqlQueryUserID);
                if($row = $response->fetch_assoc()) {
                    $uID = $row["UserID"];
                    if ($uID === $_SESSION["userID"]) {
                        continue;
                    }
                    $sqlQueryGameUser = "INSERT INTO `spielkarte` (`UserID`, `SpielID`, `Karte`, `UserStatus`, `Akzeptiert`)";
                    $sqlQueryGameUser .= "VALUE ('$uID', '$gameID', '0', '0', '0') ";
                    $response = $this->dbSQLQuery($sqlQueryGameUser);
                    array_push($responses, $response);

                    if (!$this->checkEpicUserExists($uID, $epicID) && $epicID) {
                        $sqlQueryEpicUser = "INSERT INTO `epicuser` (`EpicID`, `UserID`, `UserStatus`) ";
                        $sqlQueryEpicUser .= "VALUES ('$epicID', '$uID', '0')";
                        $response = $this->dbSQLQuery($sqlQueryEpicUser);
                        array_push($responses, $response);
                    }
                }
            }
            $this->dbClose();

            $successful = true;
            foreach($responses as $key => $response) {
                if (!$response) {
                    $successful = false;
                }
            }
            return $successful;
        }

        /**
         * checks if the epic with given epicName and with currently logged in user already exists in the database
         *
         * @return boolean true the epic exists, false otherwise
         */
        public function checkEpicName() {
            if (!isset($_POST["epicName"]) || $_POST["epicName"] === "") {
                return false;
            }
            $userID = $_SESSION["userID"];
            $epicName = $_POST["epicName"];
            $sqlQuery = "SELECT e.EpicID FROM epic e INNER JOIN epicuser u ON e.EpicID = u.EpicID WHERE u.UserID='$userID' AND e.Name='$epicName' AND u.UserStatus='1'";
            return $this->checkSqlQuery($sqlQuery);
        }

        /**
         * checks if the task with given taskName and with currently logged in user already exists in the database
         *
         * @param string $creationMode the epic creationMode. used to determine whether to search the game in an epic or not
         * @return boolean true the task exists, false otherwise
         */
        public function checkTaskName($creationMode) {
            if ($creationMode === "create") {
                $epicName = $_POST["epicName"];
            } else if ($creationMode === "select") {
                $epicName = $_POST["epicNameSelected"];
            } else {

                // Query for Game without Epic

                // get all games with current task name
                $taskName = $_POST["gameTask"];
                $userID = $_SESSION["userID"];
                $sqlQuery = "SELECT s.SpielID FROM spiele s INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID";
                $sqlQuery .= " WHERE sk.UserID='$userID' AND s.Task='$taskName'";
                $this->dbConnect();
                $result = $this->dbSQLQuery($sqlQuery);

                // build query that selects all epics that are connected to found games
                $possibleGames = [];
                $epicCheckSQLQuery = "SELECT SpielID FROM epicspiel WHERE ";
                $first = true;
                while ($row=$result->fetch_assoc()) {
                    if ($first) {
                        $epicCheckSQLQuery .= "SpielID='". $row["SpielID"] ."'";
                        $first = false;
                    } else {
                        $epicCheckSQLQuery .= " OR SpielID='". $row["SpielID"] ."'";
                    }
                    array_push($possibleGames, $row["SpielID"]);
                }
                $epicGamesResult = $this->dbSQLQuery($epicCheckSQLQuery);

                // check if there is an game that was found with the task name but is not in an epic
                $gamesInEpic = [];
                while ($row = $result->fetch_assoc()) {
                    array_push($gamesInEpic, $row["SpielID"]);
                }

                $taskAlreadyExists = false;
                foreach ($possibleGames as $curPossibleGame) {
                    foreach ($gamesInEpic as $curGameInEpic) {
                        if ($curPossibleGame === $curPossibleGame) {
                            continue 2;
                        }
                    }
                    $taskAlreadyExists = true;
                }


                $this->dbClose();

                return $taskAlreadyExists;
            }

            // Query for Game with Epic
            $taskName = $_POST["gameTask"];
            $userID = $_SESSION["userID"];
            $sqlQuery = "SELECT s.Task FROM epic e INNER JOIN epicspiel es ON e.EpicID = es.EpicID INNER JOIN spiele s ON es.SpielID = s.SpielID INNER JOIN epicuser u ON e.EpicID = u.EpicID";
            $sqlQuery .= " WHERE Task='$taskName' AND e.Name='$epicName' AND u.UserID='$userID' AND u.UserStatus='1'";
            return $this->checkSqlQuery($sqlQuery);
        }

        /**
         * checks if the given lists of userNames are registered users in the database
         *
         * @param array list of userName strings
         * @return boolean true all users exists, false otherwise
         */
        public function checkUserList($userList) {
            foreach ($userList as $user) {
                $sqlQuery = "SELECT Username FROM user WHERE Username='$user'";
                if (!$this->checkSqlQuery($sqlQuery)) {
                    return false;
                }
            }
            return true;
        }

        /**
         * checks if the user is already added to epic
         *
         * @param string $userID id of the user to check
         * @param string $epicID id of th epic to check
         * @return boolean true the epic exists, false otherwise
         */
        private function checkEpicUserExists($userID, $epicID) {
            $sqlQuery = "SELECT UserID FROM epicuser WHERE UserID='$userID' AND EpicID='$epicID'";
            return $this->checkSQLQuery($sqlQuery, false);
        }


    }
?>