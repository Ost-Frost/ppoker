<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class CreateModel extends ModelBasis {

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
                $sqlQuery = "INSERT INTO `epicuser` (`EpicID`, `UserID`) ";
                $sqlQuery .= "VALUES ('$epicID', '$userID')";
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
                        $sqlQueryEpicUser = "INSERT INTO `epicuser` (`EpicID`, `UserID`) ";
                        $sqlQueryEpicUser .= "VALUES ('$epicID', '$uID')";
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

        public function checkEpicName() {
            if (!isset($_POST["epicName"]) || $_POST["epicName"] === "") {
                return false;
            }
            $userID = $_SESSION["userID"];
            $epicName = $_POST["epicName"];
            $sqlQuery = "SELECT e.EpicID FROM epic e INNER JOIN epicspiel es ON e.EpicID = es.EpicID INNER JOIN spiele s ON es.SpielID = s.SpielID ";
            $sqlQuery .= "INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID WHERE sk.UserID='$userID' AND e.Name='$epicName'";
            return $this->checkSqlQuery($sqlQuery);
        }

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
            $sqlQuery = "SELECT s.Task FROM epic e INNER JOIN epicspiel es ON e.EpicID = es.EpicID INNER JOIN spiele s ON es.SpielID = s.SpielID ";
            $sqlQuery .= " WHERE Task='$taskName' AND e.Name='$epicName'";
            return $this->checkSqlQuery($sqlQuery);
        }

        public function checkUserList($userList) {
            foreach ($userList as $user) {
                $sqlQuery = "SELECT Username FROM user WHERE Username='$user'";
                if (!$this->checkSqlQuery($sqlQuery)) {
                    return false;
                }
            }
            return true;
        }

        private function checkEpicUserExists($userID, $epicID) {
            $sqlQuery = "SELECT UserID FROM epicuser WHERE UserID='$userID' AND EpicID='$epicID'";
            return $this->checkSQLQuery($sqlQuery, false);
        }


    }
?>