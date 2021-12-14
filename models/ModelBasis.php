<?php

    /**
     * base model class. all models have to extend this class
     */
    class ModelBasis {

        /**
         * link to the connected database
         */
        protected $dbLink;

        /**
         * Structure for Epics and Games, that you are member of
         */
        private $gameStructure = [];

        /**
         * Build up for $gameStructure
         *
         * @return array
         */
        public function getGameStructure() {
            $userID = $_SESSION['userID'];
            $sqlQueryGame = "SELECT SpielID FROM `spielkarte` WHERE UserID='$userID'";
            $sqlQueryEpic = "SELECT EpicID, UserStatus FROM `epicuser` WHERE UserID='$userID'";
            $this->dbConnect();
            $resultGame = $this->dbSQLQuery($sqlQueryGame);
            $resultEpic = $this->dbSQLQuery($sqlQueryEpic);
            $allEpic = [];

            while($row=$resultEpic->fetch_assoc()) {
                $epicIDTemp = $row["EpicID"];
                $sqlQueryHost = "SELECT UserID FROM `epicuser` WHERE EpicID='$epicIDTemp' AND UserStatus='1'";
                $hostID = $this->dbSQLQuery($sqlQueryHost);
                $host = "";
                $hostname = "";
                if($hostIDName=$hostID->fetch_assoc()) {
                    $host = $hostIDName["UserID"];
                    $sqlQueryHostname = "SELECT Username FROM `user` WHERE UserID='$host'";
                    $hostnameValue = $this->dbSQLQuery($sqlQueryHostname);
                    if($hostedBy=$hostnameValue->fetch_assoc()) {
                        $hostname = $hostedBy["Username"];
                    }
                }
                $sqlQueryEpic = "SELECT EpicID, Name, Beschreibung, Aufwand, Einrichtungsdatum FROM `epic` WHERE EpicID='$epicIDTemp'";
                $epicgames = $this->dbSQLQuery($sqlQueryEpic);
                if($allEpicGames=$epicgames->fetch_assoc()) {
                    $epic = [];
                    $epic["Name"] = $allEpicGames["Name"];
                    $epic["Beschreibung"] = $allEpicGames["Beschreibung"];
                    $epic["Aufwand"] = $allEpicGames["Aufwand"];
                    $epic["Einrichtungsdatum"] = $allEpicGames["Einrichtungsdatum"];
                    $epic["EpicID"] = $allEpicGames["EpicID"];
                    $epic["hostID"] = $host;
                    $epic["host"] = $hostname;
                    $epic["games"] = [];
                    array_push($allEpic, $epic);
                }
            }
            $games = [];
            while($row=$resultGame->fetch_assoc()) {
                $gameIDTemp = $row["SpielID"];
                $sqlQueryGame = "SELECT Task, Beschreibung, Aufwand, Einrichtungsdatum, SpielID FROM `spiele` WHERE SpielID='$gameIDTemp'";
                $sqlQueryUser = "SELECT UserID, Karte, UserStatus FROM `spielkarte` WHERE SpielID='$gameIDTemp'";
                $resultUsers = $this->dbSQLQuery($sqlQueryUser);
                $resultGameInfo = $this->dbSQLQuery($sqlQueryGame);
                $usersList = [];
                while($users=$resultUsers->fetch_assoc()) {
                    $userInfos = [];
                    $ID = $users["UserID"];
                    $sqlQueryUserInfo = "SELECT Username, UserID FROM `user` WHERE UserID='$ID'";
                    $resultUserInfo = $this->dbSQLQuery($sqlQueryUserInfo);
                    if($uInfo=$resultUserInfo->fetch_assoc()) {
                        $userInfos["Username"] = $uInfo["Username"];
                        $userInfos["Karte"] = $users["Karte"];
                        $userInfos["Userstatus"] = $users["UserStatus"];
                        $userInfos["UserID"] = $uInfo["UserID"];
                        array_push($usersList, $userInfos);
                    }
                }
                if($gameInfo = $resultGameInfo->fetch_assoc()) {
                    $game = [];
                    $game["Task"] = $gameInfo["Task"];
                    $game["Beschreibung"] = $gameInfo["Beschreibung"];
                    $game["Aufwand"] = $gameInfo["Aufwand"];
                    $game["Einrichtungsdatum"] = $gameInfo["Einrichtungsdatum"];
                    $game["SpielID"] = $gameInfo["SpielID"];
                    $game["user"] = $usersList;
                    array_push($games, $game);
                }
            }
            $gamesWOEpic = [];
            foreach($games as $ga) {
                $gameID = $ga["SpielID"];
                $sqlQueryWOE = "SELECT EpicID FROM `epicspiel` WHERE SpielID='$gameID'";
                $gamesWEO = $this->dbSQLQuery($sqlQueryWOE);
                if($epiC = $gamesWEO->fetch_assoc()) {
                    foreach($allEpic as $index => $singleEpic) {
                        if($allEpic[$index]["EpicID"] == $epiC["EpicID"]) {
                            array_push($allEpic[$index]["games"], $ga);
                        }
                    }
                } else {
                    array_push($gamesWOEpic, $ga);
                }
            }

            $this->dbClose();
            $this->gameStructure["gamesWOEpic"] = $gamesWOEpic;
            $this->gameStructure["allEpic"] = $allEpic;
            $this->gameStructure = $this->gameStructure;
            return $this->gameStructure;
        }

        /**
         * builds up a connection to the database
         */
        public function dbConnect() {
            if (is_null($this->dbLink)) {
                $this->dbLink = mysqli_connect("localhost", "root", "", "ppoker") or die("database connection failed");
            }
        }

        /**
         * closes an existing connection to the database
         */
        public function dbClose() {
            if ($this->dbCheckConnection()) {
                mysqli_close($this->dbLink);
                $this->dbLink = null;
            }
        }

        /**
         * executes an sql query and returns the response. Needs an existing database connection
         *
         * @param string sql query to resolve
         *
         * @return array resolved query
         */
        public function dbSQLQuery(string $sql) {
            if ($this->dbCheckConnection()) {
                return mysqli_query($this->dbLink, $sql);
            } else {
                return false;
            }
        }

        /**
         * checks if the connection to the database works
         *
         * @return boolean true if the connection works, false otherwise
         */
        public function dbCheckConnection() {
            if (is_null($this->dbLink)) {
                return false;
            } else if (!$this->dbLink) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * checks if the sql query is valid and returns data
         *
         * @return boolean true if the sql query is valid and returns data, false otherwise
         */
        public function checkSQLQuery($sqlQuery, $closeDBConnection=true) {
            $sqlQueryExists = true;
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            if ($closeDBConnection) {
                $this->dbClose();
            }
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $sqlQueryExists = false;
            }
            return $sqlQueryExists;
        }
    }

?>