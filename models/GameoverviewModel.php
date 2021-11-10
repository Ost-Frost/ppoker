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
            $sqlQuery = "SELECT SpielID FROM `spielkarte` WHERE UserID='$userID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $epicTemp = [];
            $gamesTemp = [];

            while($row=$result->fetch_assoc()) {
                $searchRow = $row["SpielID"];
                $sqlQuery = "SELECT Task, Beschreibung FROM `spiele` WHERE SpielID='$searchRow'";
                $resultGameID = $this->dbSQLQuery($sqlQuery);
                $sqlQuery = "SELECT EpicID FROM `epicspiel` WHERE SpielID='$searchRow'";
                $resultEpicID = $this->dbSQLQuery($sqlQuery);
                if($rowGame = $resultGameID->fetch_assoc()) {
                    $gameDB["SpielID"] = $searchRow;
                    $gameDB["Task"] = $rowGame["Task"];
                    $gameDB["Beschreibung"] = $rowGame["Beschreibung"];
                    if($egTemp = $resultEpicID->fetch_assoc()) {
                        if($egTemp["EpicID"] !== "") {
                            $gameDB["EpicID"] = $egTemp["EpicID"];
                        }
                    } else {
                        $gameDB["EpicID"] = "";
                    }
                    array_push($gamesTemp, $gameDB);
                }
                foreach ($resultEpicID as $rEID) {
                    $epicSearch = $rEID["EpicID"];
                    $sqlQuery = "SELECT Name, Beschreibung, Aufwand FROM `epic` WHERE EpicID='$epicSearch'";
                    $resultEpic = $this->dbSQLQuery($sqlQuery);
                    $rowEpic = $resultEpic->fetch_assoc();
                    if(!$this->checkID($epicTemp, $epicSearch)) {
                        $epicData["EpicID"] = $epicSearch;
                        $epicData["Name"] = $rowEpic["Name"];
                        $epicData["Beschreibung"] = $rowEpic["Beschreibung"];
                        $epicData["Aufwand"] = $rowEpic["Aufwand"];
                        $epicData["games"] = [];
                        array_push($epicTemp, $epicData);
                    }
                }
            }
            $this->dbClose();

            foreach ($epicTemp as $epic => $valueE) {
                $epicgames = [];
                foreach($gamesTemp as $game => $valueG) {
                    if($valueE["EpicID"] == $valueG["EpicID"]) {
                        unset($valueG["EpicID"]);
                        array_push($epicgames, $valueG);
                        $gamesTemp[$game]["EpicID"] = "NULL";
                    }
                }
                $epicTemp[$epic]["games"] = $epicgames;
            }
            $gamesWOEpic = [];
            foreach($gamesTemp as $game => $value) {
                if($gamesTemp[$game]["EpicID"] !== "NULL") {
                    unset($value["EpicID"]);
                    array_push($gamesWOEpic, $value);
                }
            }
            $this->gameStructure["gamesWOEpic"] = $gamesWOEpic;
            $this->gameStructure["allEpic"] = $epicTemp;
            $this->gameStructure = json_encode($this->gameStructure);
        }

        private function checkID($array, $id) : bool {
            foreach($array as $check) {
                if(isset($check["EpicID"]) && $check["EpicID"] === $id) {
                    return true;
                }
            }
            return false;
        }
    }

?>