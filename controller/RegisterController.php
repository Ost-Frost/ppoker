<?php

    require("ControllerBasis.php");

    class RegisterController extends ControllerBasis {

        private $fields = [
            "userName",
            "preName",
            "lastName",
            "email",
            "emailRepeat",
            "password",
            "passwordRepeat"
        ];

        public function validateData() : bool {

            foreach ($this->fields as $key => $field) {
                if (!$this->validateFieldNotEmpty($field)) {
                    return false;
                }
            }

            return true;
        }

        private function validateFieldNotEmpty($name) : bool {
            if (isset($_POST[$name]) && $_POST[$name] != "") {
                return true;
            } else {
                return false;
            }
        }

        public function getRegisterTemplateProperties() : array {

            $templateProperties = [];

            foreach ($this->fields as $key => $field) {

                if (isset($_POST[$field]) && $_POST[$field] != "") {
                    $templateProperties[$field] = $_POST[$field];
                } else {
                    $templateProperties[$field] = "";
                }
            }

            return $templateProperties;
        }
    }

?>