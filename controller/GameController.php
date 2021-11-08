<?php

    require("ControllerBasis.php");

    class CreateGameController extends ControllerBasis {

        public function __construct() {
            $this->apiActions = [
                "CreateNewGame" => $this->createGame,
                "DeleteGame" => $this->deleteGame
            ]
        }

        /**
         * validates the user request data.
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateData($data) : bool {
            foreach ($data as $key => $field) {
                if (!$this->validateFieldNotEmpty($field)) {
                    return false;
                }
            }
            return true;
        }

        /**
         * validates if a given field has a value
         *
         * @return boolean true if it has a value and that value is not the empty string, false otherwise.
         */
        private function validateFieldNotEmpty($name) : bool {
            if (isset($_POST[$name]) && $_POST[$name] != "") {
                return true;
            } else {
                return false;
            }
        }

        public function createGame($model) {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405) // Method not allowed
            }
            if (!$this->validateData(["task", "description"])) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->createGame();
            foreach ($dbResponse as $response) {
                if (!$response) {
                    return $this->rejectAPICall(500); // Internal Server Error
                }
            }
            return $this->resolveAPICall(201); // Created
        }

        public function deleteGame($model) {
            if (!$_SERVER["REQUEST_METHOD"] === "DELETE") {
                return $this->rejectAPICall(405) // Method not allowed
            }
            if (!(isset($_DELETE["gameid"]) && $_DELETE["gameid"] != "")) {
                return $this->rejectAPICall(400); // Bad Request
            }
            $dbResponse = $model->deleteGame();
            if (!$response) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(200); // OK
        }
    }
?>