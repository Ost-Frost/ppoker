<?php
    require("APIControllerBasis.php");

    class PlayCardController extends APIControllerBasis {

        public function apiCall($action, $model) : string {
            if ($action == "Play") {
                return $this->playCard($model);
            } // else if ($action == "Change") {
               // return $this->changeCard($model);
            // }
            return false;
        }

        /**
         * plays a card within the game
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function playCard($model) : string {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$this->validateFieldGroupNotEmpty(["card"])) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->playCard();
            foreach ($dbResponse as $response) {
                if (!$response) {
                    return $this->rejectAPICall(500); // Internal Server Error
                }
            }
            return $this->resolveAPICall("{}", 201); // Played
        }
    }
?>