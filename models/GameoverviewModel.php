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
                $gameUser["host"] = $game["host"];
                $gameUser["SpielID"] = $game["SpielID"];
                if(!$delGame){
                    array_push($gWOETemp, $gameUser);
                }
            }

            $this->dbClose();
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
    }

?>
