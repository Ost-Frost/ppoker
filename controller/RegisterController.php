<?php

    require("ControllerBasis.php");

    /**
     * controller for the register page
     */
    class RegisterController extends ControllerBasis {

        /**
         * a list of fields that are needed to register a new user
         */
        private $fields = [
            "userName",
            "preName",
            "lastName",
            "email",
            "emailRepeat",
            "password",
            "passwordRepeat"
        ];

        /**
         * validates the user request data.
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateData() : bool {

            foreach ($this->fields as $key => $field) {
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

        /**
         * generates the template Properties to render the register template by filling in the request data
         *
         * @return array the template properties for the register page
         */
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

        public function hashPassword() {
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }
    }

?>