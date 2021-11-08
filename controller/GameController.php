<?php

    require("APIControllerBasis.php");

    class GameController extends APIControllerBasis {

        public function apiCall($action, $model) : mixed {
            if ($action == "Create") {
                return $this->createGame($model);
            } else if ($action == "Delete") {
                return $this->deleteGame($model);
            } else if ($action == "Search") {
                return $this->search($model);
            }
            return false;
        }

        /**
         * searches the database for userNames that start with requested username string or email string
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function search($model) : string {
            if (!$_SERVER["REQUEST_METHOD"] === "GET") {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if ($this->validateFieldNotEmpty("userName", "GET")) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->search();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }

        /**
         * creates a new game with the requst data
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function createGame($model) : string {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if ($this->validateFieldGroupNotEmpty(["task", "description"])) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->createGame();
            foreach ($dbResponse as $response) {
                if (!$response) {
                    return $this->rejectAPICall(500); // Internal Server Error
                }
            }
            return $this->resolveAPICall("{}", 201); // Created
        }

        /**
         * deletes the game with the requested game idea
         *
         * @param ModelBasis corresponding model
         *
         * @return string response string
         */
        public function deleteGame($model) : string {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405); // Method not allowed
            }
            if ($this->validateFieldNotEmpty("gameid")) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->deleteGame();
            if (!$response) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(); // OK
        }
    }
?>