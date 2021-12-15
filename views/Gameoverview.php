<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the gameoverview page
     */
    class Gameoverview extends ViewBasis implements ViewInterface {

        /**
         * render method for the gameoverview page. a GET request returns the gameoverview page
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                http_response_code(405); // Invalid method
                return "{}";
            }
            $gameStructure = $this->model->getGameStructure();
            $allEpics = $gameStructure["allEpic"];
            $gamesWOEpic = $gameStructure["gamesWOEpic"];
            $gamesContent = "";

            if (count($allEpics) === 0 && count($gamesWOEpic) === 0) {
                return $this->renderNoGames();
            }
            // create Epics
            foreach ($allEpics as $curEpic) {
                $gamesContent .= $this->renderEpic($curEpic);
            }

            // create Dropdown for games without epics
            if (count($gamesWOEpic) > 0) {
                $renderedGames = "";

                // create Games
                foreach ($gamesWOEpic as $curGame) {
                    $renderedGames .= $this->renderGame($curGame);
                }
                $templateProperties = [];
                $templateProperties["epicID"] = "gamesWOEpic";
                $templateProperties["epicName"] = "Spiele ohne Epic";
                $templateProperties["epicSpiele"] = $renderedGames;
                $templateProperties["epicHost"] = "";
                $gamesContent .= $this->openTemplate("templates/gameOverview/epicTemplate.php", $templateProperties);
            }

            $joinTemplateProperties = [];
            $joinTemplateProperties["content"] = $gamesContent;

            $templateProperties = [];
            $templateProperties["header"] = "<link href='./CSS/gameOverview.css' rel='stylesheet'>";
            $templateProperties["content"] = $this->openTemplate("templates/gameOverview/gameOverview.php", $joinTemplateProperties);
            $templateProperties["script"] = "<script src='JS/gameOverview.js'></script>";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

        /**
         * renders the dynamic html for the epic data
         *
         * @param array $epicData data for the to be rendered epic
         * @return string rendered html string
         */
        private function renderEpic($epicData) {

            $games = $epicData["games"];
            $renderedGames = "";

            // create Games
            foreach ($games as $curGame) {
                $renderedGames .= $this->renderGame($curGame);
            }
            $templateProperties = [];
            $templateProperties["epicID"] = $epicData["EpicID"];
            $templateProperties["epicName"] = $epicData["Name"];
            $templateProperties["epicHost"] = "(" . $epicData["host"] . ")";
            $templateProperties["epicDescription"] = ($epicData["Beschreibung"] !== "") ? $epicData["Beschreibung"] : "-";
            $templateProperties["epicSpiele"] = $renderedGames;
            return $this->openTemplate("templates/gameOverview/epicTemplate.php", $templateProperties);
        }

        /**
         * renders the dynamic html for the game data
         *
         * @param array $gameData data for the to be rendered game
         * @return string rendered html string
         */
        private function renderGame($gameData) {
            $templateProperties = [];
            $templateProperties["gameTask"] = $gameData["Task"];
            $templateProperties["gameID"] = $gameData["SpielID"];
            $templateProperties["gameHost"] = (isset($gameData["host"])) ? "(" . $gameData["host"] . ")" : "";
            $isGameHost = false;
            foreach ($gameData["user"] as $curUser) {
                if ($curUser["Userstatus"] == "1" && $curUser["UserID"] == $_SESSION["userID"]) {
                    $isGameHost = true;
                }
            }
            $templateProperties["isHost"] = $isGameHost;
            $templateProperties["gameDescription"] = ($gameData["Beschreibung"] !== "") ? $gameData["Beschreibung"] : "-";
            return $this->openTemplate("templates/gameOverview/gameTemplate.php", $templateProperties);
        }

        /**
         * renders the gameOverview page if there are no games for the logged in user
         *
         * @return string rendered html string
         */
        private function renderNoGames() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/gameOverview/noGames.php");
            $templateProperties["script"] = "<script src='JS/gameOverview.js'></script>";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

    }

?>