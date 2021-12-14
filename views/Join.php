<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the join page
     */
    class Join extends ViewBasis implements ViewInterface {

        /**
         * render method for the join page. a GET request returns the join page
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                http_response_code(405); // Invalid method
                return "{}";
            }
            $gameStructure = $this->model->getGameStructure();
            $gameStructure = $this->controller->filterGames($gameStructure);
            $allEpics = $gameStructure["allEpic"];
            $gamesWOEpic = $gameStructure["gamesWOEpic"];
            $gamesContent = "";

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
                $gamesContent .= $this->openTemplate("templates/join/epicTemplate.php", $templateProperties);
            }

            $joinTemplateProperties = [];
            $joinTemplateProperties["content"] = $gamesContent;

            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/join/join.php", $joinTemplateProperties);
            $templateProperties["script"] = "<script src='JS/join.js'></script>";
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
            $templateProperties["epicSpiele"] = $renderedGames;
            return $this->openTemplate("templates/join/epicTemplate.php", $templateProperties);
        }

        /**
         * renders the dynamic html for the game data
         *
         * @param array $gameData data for the to be rendered game
         * @return string rendered html string
         */
        private function renderGame($gameData) {
            $templateProperties = [];
            $templateProperties["hostName"] = "Test";//$gameData["HostName"];
            $templateProperties["gameTask"] = $gameData["Task"];
            $templateProperties["gameID"] = $gameData["SpielID"];
            $templateProperties["gameDescription"] = ($gameData["Beschreibung"] !== "") ? $gameData["Beschreibung"] : "-";
            return $this->openTemplate("templates/join/gameTemplate.php", $templateProperties);
        }

    }

?>