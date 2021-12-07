<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class Join extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * If the user data is invalid the register page is returned with a script that shows the user the wrong data.
         *
         * @return string rendered html string
         */
        public function render() : string {

            $gameStructure = $this->model->getGameStructure();
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

        private function renderGame($gameData) {
            $templateProperties = [];
            $templateProperties["hostName"] = "Test";//$gameData["HostName"];
            $templateProperties["gameTask"] = $gameData["Task"];
            $templateProperties["gameID"] = $gameData["gameID"];
            $templateProperties["gameDescription"] = ($gameData["Beschreibung"] !== "") ? $gameData["Beschreibung"] : "-";
            return $this->openTemplate("templates/join/gameTemplate.php", $templateProperties);
        }

    }

?>