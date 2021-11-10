<?php

    require("ModelBasis.php");

    /**
     * model for the Gameoverview page
     */
    class JoinModel extends ModelBasis {

        private $joinStructure = [];

        public function getJoinStructure() {
            $this->buildData();
            return $this->joinStructure;
        }

        /**
         * initializes all epics and
         */
        public function buildData() {
            $userID = $_SESSION['userID'];
            $sqlQueryGame = "SELECT SpielID, UserStatus FROM `spielkarte` WHERE UserID='$userID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQueryGame);
            $allGames = [];

            while($row=$result->fetch_assoc()) {
                $gameID = $row['SpielID'];
                $userStatus = $row['UserStatus'];
                if($userStatus !== 0) {
                    continue;
                }
                $sqlQueryGameID = "SELECT Task, Beschreibung, Einrichtungsdatum FROM `spiele` WHERE SpielID='$gameID'";
                $resultGame = $this->dbSQLQuery($sqlQueryGameID);
                if($gameFetch = $resultGame->fetch_assoc()) {
                    $gameData = [];
                    $gameData["Task"] = $gameFetch["Task"];
                    $gameData["Beschreibung"] = $gameFetch["Beschreibung"];
                    $gameData["date"] = $gameFetch["Einrichtungsdatum"];
                    array_push($allGames, $gameData);
                }
            }
            $this->joinStructure = $allGames;
        }
    }

?>