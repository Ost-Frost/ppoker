<?php

    require("ControllerBasis.php");

    class CreateGameController extends ControllerBasis {

        private $data = [
            "task",
            "description"
        ];

        /**
         * validates the user request data.
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateData() : bool {
            foreach ($this->data as $key => $ndata) {
                if (!$this->validateFieldNotEmpty(ndata)) {
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

        public function getCreateGameTemplate() : array {
            $templateData = [];

            foreach ($this->data as $key => $ndata) {
                if(isset($_POST[$ndata]) && $_POST[$ndata] !== "") {
                    $templateData[$ndata] = $_POST[$ndata];
                } else {
                    $templateData[$ndata] = "";
                }
            }
            return $templateData;
        }
    }
?>