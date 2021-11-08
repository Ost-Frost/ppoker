<?php
    require("ControllerBasis.php");
    /**
     * base controller. All controllers have to extend this class
     */
    abstract class APIControllerBasis extends ControllerBasis {

        abstract public function apiCall($action, $model) : mixed;

        public function rejectAPICall($error) : string {
            http_response_code($error);
            return "{}";
        }

        public function resolveAPICall($status, $response="{}") : string {
            http_response_code($status);
            return $response;
        }
    }

?>