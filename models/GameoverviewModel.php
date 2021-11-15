<?php

    require("ModelBasis.php");

    /**
     * model for the Gameoverview page
     */
    class GameoverviewModel extends ModelBasis {

        private $gameStructure = [];

        public function getGameStructure() {
            $this->buildData();
            return $this->gameStructure;
        }

        /**
         * initializes all epics and
         */
        public function buildData() {

            $userID = $_SESSION['userID'];
            $sqlQuery = "SELECT SpielID, UserStatus FROM `spielkarte` WHERE UserID='$userID'";
            $sqlQueryEpic = "SELECT EpicID FROM `epicuser` WHERE UserID='$userID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $resultEpic = $this->dbSQLQuery($sqlQueryEpic);
            $allUserEpic = [];
            $allUserGame = [];

            while($row=$resultEpic->fetch_assoc()) {
                $epicIDTemp = $row["EpicID"];
                $sqlQueryEpic = "SELECT Name, Beschreibung, Aufwand, EpicID, Einrichtungsdatum FROM `epic` WHERE EpicID='$epicIDTemp'";
                $epicResult = $this->dbSQLQuery($sqlQueryEpic);
                if($rowEpic=$epicResult->fetch_assoc()) {
                    $allUserEpicTemp = [];
                    $allUserEpicTemp["Name"] = $rowEpic["Name"];
                    $allUserEpicTemp["Beschreibung"] = $rowEpic["Beschreibung"];
                    $allUserEpicTemp["Aufwand"] = $rowEpic["Aufwand"];
                    $allUserEpicTemp["EpicID"] = $rowEpic["EpicID"];
                    $allUserEpicTemp["date"] = $rowEpic["Einrichtungsdatum"];
                    array_push($allUserEpic, $allUserEpicTemp);
                }
            }
            while($row=$result->fetch_assoc()) {
                if($row["UserStatus"] == 1) {
                    $gameIDTemp = $row["SpielID"];
                    $sqlQueryGame = "SELECT Task, Beschreibung, Einrichtungsdatum, Aufwand, SpielID FROM `spiele` WHERE SpielID='$gameIDTemp'";
                    $gameResult = $this->dbSQLQuery($sqlQueryGame);
                    if($rowGame=$gameResult->fetch_assoc()) {
                        $allUserGameTemp = [];
                        $allUserGameTemp["Task"] = $rowGame["Task"];
                        $allUserGameTemp["Beschreibung"] = $rowGame["Beschreibung"];
                        $allUserGameTemp["Einrichtungsdatum"] = $rowGame["Einrichtungsdatum"];
                        $allUserGameTemp["Aufwand"] = $rowGame["Aufwand"];
                        $allUserGameTemp["gameID"] = $rowGame["SpielID"];
                        array_push($allUserGame, $allUserGameTemp);
                    }
                }
            }
            echo sizeof($allUserGame);
            foreach($allUserEpic as $epicID => $epic) {
                $epicIDTemp = $epic["EpicID"];
                $sqlQueryEpic = "SELECT SpielID FROM `epicspiel` WHERE EpicID='$epicIDTemp'";
                $epicResult = $this->dbSQLQuery($sqlQueryEpic);
                $gamesInEpic = [];
                while($row=$epicResult->fetch_assoc()) {
                    $searchGame = $row["SpielID"];
                    foreach($allUserGame as $gameID => $game) {
                        $gameIDTemp = $game["gameID"];
                        if($gameIDTemp == $searchGame) {
                            array_push($gamesInEpic, $game);
                            $allUserGame[$gameID]["gameID"] = "";
                        }
                    }
                }
                $allUserEpic[$epicID]["games"] = $gamesInEpic;
                unset($allUserEpic[$epicID]["EpicID"]);
            }
            $this->dbClose();
            $gamesWOEpic = [];
            foreach($allUserGame as $gameID => $game) {
                if($game["gameID"] == "") {
                    unset($allUserGame[$gameID]["gameID"]);
                    array_push($gamesWOEpic, $game);
                }
            }
            $this->gameStructure["gamesWOEpic"] = $gamesWOEpic;
            $this->gameStructure["allEpic"] = $allUserEpic;
            $this->gameStructure = json_encode($this->gameStructure);
        }
    }

?>