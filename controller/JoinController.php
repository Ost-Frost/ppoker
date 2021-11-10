<?php

    require("APIControllerBasis.php");

    /**
     * controller for the Gameoverview page
     */
    class JoinController extends APIControllerBasis {

        /**
         * builds array with all games involved
         */
        public function apicall($action, $model) : string {
            if($action === "getInvitation") {
                return $this->getInvitation();
            }
            return false;
        }

        private function getInvitation() {
            if (!$_SERVER["REQUEST_METHOD"] === "GET") {
                return $this->rejectAPICall(405); // Method not allowed
            }
            $dbResponse = $model->getJoinStructure();
            if (!$dbResponse) {
                return $this->rejectAPICall(500); // Internal Server Error
            }
            return $this->resolveAPICall(json_encode($dbResponse)); // OK
        }
    }

?>