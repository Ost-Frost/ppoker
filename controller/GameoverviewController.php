<?php

    require("APIControllerBasis.php");

    /**
     * controller for the Gameoverview page
     */
    class GameoverviewController extends APIControllerBasis {

        /**
         * builds array with all games involved
         */
        public function apicall($action, $model) : string {
            if($action === "getGames") {
                return $this->getGames($model);
            }
            return false;
        }

        private function getGames($model) {
            if (!($_SERVER["REQUEST_METHOD"] === "GET")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            $dbResponse = $model->getGameStructure();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }
    }

?>