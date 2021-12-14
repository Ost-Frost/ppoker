<?php

    require("ModelBasis.php");

    /**
     * model for the Gameoverview page
     */
    class GameoverviewModel extends ModelBasis {

        private $gameStructure = [];

        public function gameStructure() {
            $this->gameStructure = $this->getGameStructure();
            $this->buildData();
            return $this->gameStructure;
        }

        /**
         * initializes all epics and
         */
        public function buildData() {

            $userID = $_SESSION["userID"];
            $gamesWOEpic = $this->gameStructure["gamesWOEpic"];
            $allEpic = $this->gameStructure["allEpic"];

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
                            } else if($user["Userstatus"] == 2) {
                                $gameInfo["Username"] = $user["Username"];
                                $gameInfo["Karte"] = $user["Karte"];
                                $gameInfo["Userstatus"] = $user["Userstatus"];
                                array_push($gameUser["user"], $gameInfo);
                            } else {
                                continue;
                            }
                        }
                    }
                    $gameUser["Task"] = $game["Task"];
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
                        } else if($user["Userstatus"] == 2) {
                            $gameInfo["Username"] = $user["Username"];
                            $gameInfo["Karte"] = $user["Karte"];
                            $gameInfo["Userstatus"] = $user["Userstatus"];
                            array_push($gameUser["user"], $gameInfo);
                        } else {
                            continue;
                        }
                    }
                }
                $gameUser["Task"] = $game["Task"];
                $gameUser["Beschreibung"] = $game["Beschreibung"];
                $gameUser["Aufwand"] = $game["Aufwand"];
                $gameUser["Einrichtungsdatum"] = $game["Einrichtungsdatum"];
                if(!$delGame){
                    array_push($gamesWOEpic, $gameUser);
                }
            }

            $this->gameStructure["allEpic"] = $epics;
            $this->gameStructure["gamesWOEpic"] = $gWOETemp;
        }
    }

?>