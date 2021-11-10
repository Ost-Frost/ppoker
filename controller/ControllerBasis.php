<?php

    /**
     * base controller. All controllers have to extend this class
     */
    class ControllerBasis {

        /**
         * validates if given array of fields are not empty
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateFieldGroupNotEmpty($data, $method="POST") : bool {
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
        public function validateFieldNotEmpty($name, $method="POST") : bool {
            if ($method === "POST") {
                $checkArray = $_POST;
            } else if ($method === "GET") {
                $checkArray = $_GET;
            }
            if (isset($checkArray[$name]) && $checkArray[$name] != "") {
                return true;
            } else {
                return false;
            }
        }
    }

?>