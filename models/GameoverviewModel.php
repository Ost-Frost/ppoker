<?php

    require("ModelBasis.php");

    /**
     * model for the Gameoverview page
     */
    class GameoverviewModel extends ModelBasis {

        public function gameStructure() {
            $gameStructure = $this->getGameStructure();
            return $this->buildData($gameStructure);
        }

        /**
         * initializes all epics and
         */
        public function buildData($gameStructure) {

            $userID = $_SESSION["userID"];
            $gamesWOEpic = $gameStructure["gamesWOEpic"];
            $allEpic = $gameStructure["allEpic"];

            $epics = [];
            foreach($allEpic as $epic) {
                $games = $epic["games"];
                $epicGame = [];
                $epicGame["games"] = [];
                foreach($games as $game) {
                    $users = $game["user"];
                    $gameUser = [];
                    $gameUser["user"] = [];
                    $delGame = false;
                    foreach($users as $user) {
                        $gameInfo = [];
                        if($user["UserID"] == $userID) {
                            if($user["Userstatus"] == 1) {
                                $epicGame["host"] = $user["Username"];
                                $gameInfo["Username"] = $user["Username"];
                                $gameInfo["Karte"] = $user["Karte"];
                                $gameInfo["Userstatus"] = $user["Userstatus"];
                                array_push($gameUser["user"], $gameInfo);
                            } else if($user["Userstatus"] == 2) {
                                $gameInfo["Username"] = $user["Username"];
                                $gameInfo["Karte"] = $user["Karte"];
                                $gameInfo["Userstatus"] = $user["Userstatus"];
                                array_push($gameUser["user"], $gameInfo);
                            } else {
                                $delGame = true;
                                break;
                            }
                        } else {
                            if($user["Userstatus"] == 1) {
                                $epicGame["host"] = $user["Username"];
                                $gameInfo["Username"] = $user["Username"];
                                $gameInfo["Karte"] = $user["Karte"];
                                $gameInfo["Userstatus"] = $user["Userstatus"];
                                array_push($gameUser["user"], $gameInfo);
                            } else {
                                $gameInfo["Username"] = $user["Username"];
                                $gameInfo["Karte"] = $user["Karte"];
                                $gameInfo["Userstatus"] = $user["Userstatus"];
                                array_push($gameUser["user"], $gameInfo);
                            }
                        }
                    }
                    $gameUser["Task"] = $game["Task"];
                    $gameUser["SpielID"] = $game["SpielID"];
                    $gameUser["Beschreibung"] = $game["Beschreibung"];
                    $gameUser["Aufwand"] = $game["Aufwand"];
                    $gameUser["Einrichtungsdatum"] = $game["Einrichtungsdatum"];
                    if(!$delGame){
                        array_push($epicGame["games"], $gameUser);
                    }
                }
                $epicGame["Name"] = $epic["Name"];
                $epicGame["Beschreibung"] = $epic["Beschreibung"];
                $epicGame["Aufwand"] = $epic["Aufwand"];
                $epicGame["Einrichtungsdatum"] = $epic["Einrichtungsdatum"];
                $epicGame["EpicID"] = $epic["EpicID"];
                $epicGame["currentUserValue"] = $this->userEpicValues($epic["EpicID"]);
                if(sizeof($epicGame["games"]) != 0) {
                    array_push($epics, $epicGame);
                }
            }

            $gWOETemp = [];
            foreach($gamesWOEpic as $game) {
                $users = $game["user"];
                $gameUser = [];
                $gameUser["user"] = [];
                $delGame = false;
                foreach($users as $user) {
                    $gameInfo = [];
                    if($user["UserID"] == $userID) {
                        if($user["Userstatus"] == 1) {
                            $epicGame["host"] = $user["Username"];
                            $gameInfo["Username"] = $user["Username"];
                            $gameInfo["Karte"] = $user["Karte"];
                            $gameInfo["Userstatus"] = $user["Userstatus"];
                            array_push($gameUser["user"], $gameInfo);
                        } else if($user["Userstatus"] == 2) {
                            $gameInfo["Username"] = $user["Username"];
                            $gameInfo["Karte"] = $user["Karte"];
                            $gameInfo["Userstatus"] = $user["Userstatus"];
                            array_push($gameUser["user"], $gameInfo);
                        } else {
                            $delGame = true;
                            break;
                        }
                    } else {
                        if($user["Userstatus"] == 1) {
                            $epicGame["host"] = $user["Username"];
                            $gameInfo["Username"] = $user["Username"];
                            $gameInfo["Karte"] = $user["Karte"];
                            $gameInfo["Userstatus"] = $user["Userstatus"];
                            array_push($gameUser["user"], $gameInfo);
                        } else {
                            $gameInfo["Username"] = $user["Username"];
                            $gameInfo["Karte"] = $user["Karte"];
                            $gameInfo["Userstatus"] = $user["Userstatus"];
                            array_push($gameUser["user"], $gameInfo);
                        }
                    }
                }
                $gameUser["Task"] = $game["Task"];
                $gameUser["Beschreibung"] = $game["Beschreibung"];
                $gameUser["Aufwand"] = $game["Aufwand"];
                $gameUser["Einrichtungsdatum"] = $game["Einrichtungsdatum"];
                $gameUser["host"] = $game["host"];
                $gameUser["SpielID"] = $game["SpielID"];
                if(!$delGame){
                    array_push($gWOETemp, $gameUser);
                }
            }

            $gameStructure["allEpic"] = $epics;
            $gameStructure["gamesWOEpic"] = $gWOETemp;
            return $gameStructure;
        }

        public function getUserName() {
            $userID = $_SESSION["userID"];

            $sqlQuery = "SELECT Username FROM user WHERE UserID='$userID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $userName = false;
            if ($row = mysqli_fetch_assoc($result)) {
                $userName = $row["Username"];
            }
            $this->dbClose();
            return $userName;
        }

        /**
         * returns all specific user values of epics
         *
         * @return mixed in case of success array with all needed data, otherwise boolean value false
         */
        public function userEpicValues($epicID) {

            $userID = $_SESSION["userID"];
            $userValue = 0;

            $sqlQueryGameIDs = "SELECT SpielID FROM `epicspiel` WHERE EpicID='$epicID'";
            $this->dbConnect();
            $gameIDs = $this->dbSQLQuery($sqlQueryGameIDs);

            while($gID = $gameIDs->fetch_assoc()) {
                $gameID = $gID["SpielID"];
                $sqlQueryCardValue = "SELECT s.Aufwand FROM spielkarte sk INNER JOIN spiele s ON s.SpielID = sk.SpielID WHERE sk.SpielID='$gameID' AND sk.UserID='$userID' AND (sk.UserStatus = '1' OR sk.UserStatus = '2')";
                $cardValues = $this->dbSQLQuery($sqlQueryCardValue);

                if($card = $cardValues->fetch_assoc()) {
                    $userValue += $card["Aufwand"];
                }
            }

            $this->dbClose();
                return $userValue;
        }
    }

?>
