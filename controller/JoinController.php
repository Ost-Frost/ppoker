<?php

    require("APIControllerBasis.php");

    /**
     * controller for the Join page
     */
    class JoinController extends APIControllerBasis {

        public function apicall($action, $model) : string {
            if ($action === "Accept") {
                return $this->acceptGame($model);
            } else if ($action === "Decline") {
                return $this->declineGame($model);
            }
            return false;
        }

        private function acceptGame($model) {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405); // Method not allowed
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

        private function declineGame($model) {
            if (!$_SERVER["REQUEST_METHOD"] === "POST") {
                return $this->rejectAPICall(405); // Method not allowed
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