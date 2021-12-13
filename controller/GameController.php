<?php

    require("APIControllerBasis.php");

    /**
     * controller for the game api
     */
    class GameController extends APIControllerBasis {

        /**
         * redirects an api action to the corresponding method
         *
         * @param string action string
         * @param ModelBasis corresponding data model for database actions
         *
         * @return string response string of the API call
         */
        public function apiCall($action, $model) : string {
            if ($action == "Delete") {
                return $this->deleteGame($model);
            } else if ($action == "Search") {
                return $this->search($model);
            } else if ($action == "Play") {
                return $this->playCard($model);
            } else if ($action == "Accept") {
                return $this->acceptGame($model);
            } else if ($action == "Decline") {
                return $this->declineGame($model);
            } else if ($action == "Leave") {
                return $this->leaveGame($model);
            } else if($action === "getGames") {
                return $this->getGames($model);
            }
            return false;
        }

        /**
         * searches the database for userNames that start with requested username string or email string
         * or for epicNames that start with requested epicName string
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function search($model) : string {
            if (!($_SERVER["REQUEST_METHOD"] === "GET")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$this->validateFieldNotEmpty("userName", "GET") || !$this->validateFieldNotEmpty("epicName", "GET")) {
                if(!$this->validateFieldNotEmpty("userName", "GET") && !$this->validateFieldNotEmpty("epicName", "GET")){
                    return $this->rejectAPICall(400); // Bad Request, no Parameter initialized
                } else if($this->validateFieldNotEmpty("userName", "GET")) {
                    $dbResponse = $model->searchUser();
                } else if($this->validateFieldNotEmpty("epicName", "GET")) {
                    $dbResponse = $model->searchEpic();
                }
            } else {
                return $this->rejectAPICall(400); // Bad Request, too many parameters initialized
            }
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }

        /**
         * deletes the game with the requested game idea
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function deleteGame($model) : string {
            if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkGameHost()) {
                return $this->rejectAPICall(401); // Unauthorized
            }
            $dbResponse = $model->deleteGame();
            if (!$response) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(); // OK
        }

        /**
         * plays a card within the game
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function playCard($model) : string {
            if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
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
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkUserStatus(0)) {
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
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkUserStatus(0)) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->declineGame();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }

        /**
         * leaves the game with given gameID
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        private function leaveGame($model) {
            if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if (!$model->checkGameID()) {
                return $this->rejectAPICall(400); // Bad Request
            }
            if (!$model->checkUserStatus(2)) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->leaveGame();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }

        /**
         * gets Games with Session UserID
         *
         * @param ModelBasis corresponding model
         *
         * @return array
         */
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
