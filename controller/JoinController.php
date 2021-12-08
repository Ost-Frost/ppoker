<?php

    require("APIControllerBasis.php");

    /**
     * controller for the Join page
     */
    class JoinController extends APIControllerBasis {

        /**
         * redirects an api action to the corresponding method
         *
         * @param string action string
         * @param ModelBasis corresponding data model for database actions
         *
         * @return string response string of the API call
         */
        public function apicall($action, $model) : string {
            if ($action === "Accept") {
                return $this->acceptGame($model);
            } else if ($action === "Decline") {
                return $this->declineGame($model);
            }
            return false;
        }

        /**
         * accepts the invitation to the game with given gameID
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        private function acceptGame($model) : string {
            if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$this->validateFieldNotEmpty("gameID")) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->acceptGame();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }

        /**
         * declines the invitation to the game with given gameID
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        private function declineGame($model) {
            if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$this->validateFieldNotEmpty("gameID")) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->declineGame();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }
    }

?>