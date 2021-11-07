<?php

    /**
     * base controller. All controllers have to extend this class
     */
    class ControllerBasis {

        protected $apiActions = [];

        public function apiCall($action, $model) : mixed {
            if (isset($this->apiActions[$action])) {
                return $this->apiActions[$action]($model);
            } else {
                return false;
            }
        }
    }

?>