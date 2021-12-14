<?php

    require("APIControllerBasis.php");

    /**
     * controller for the Join page
     */
    class JoinController extends ControllerBasis {

        /**
         * filters games from the gamestructure so that only invitations are shown
         *
         * @param array $gameStructure complete game structure
         * @return array gameStructure with filtered games
         */
        public function filterGames($gameStructure) {
            $gameStructure["gamesWOEpic"] = array_filter($gameStructure["gamesWOEpic"], array($this, "checkGame"));
            $gameStructure["allEpic"] = array_map(array($this, "filterEpicGames"), $gameStructure["allEpic"]);
            $gameStructure["allEpic"] = array_filter($gameStructure["allEpic"], array($this, "checkEpic"));

            return $gameStructure;
        }


        /**
         * checks if a game is an invitation
         *
         * @param array $game to check
         * @return boolean filtered list of games
         */
        private function checkGame($game) {
            $userID = $_SESSION["userID"];

            foreach ($game["user"] as $userKey => $curUser) {
                if ($curUser["UserID"] === $userID) {
                    if ($curUser["Userstatus"] !== "0") {
                        return false;
                    }
                }
            }

            return true;
        }

        private function filterEpicGames($epic) {
            $epic["games"] = array_filter($epic["games"], array($this, "checkGame"));
            return $epic;
        }

        private function checkEpic($epic) {
            if (count($epic["games"]) === 0) {
                return false;
            } else {
                return true;
            }
        }
    }

?>