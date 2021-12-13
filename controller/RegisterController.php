<?php

    require("ControllerBasis.php");

    /**
     * controller for the register page
     */
    class RegisterController extends ControllerBasis {

        /**
         * stores names of fields that should be validated before rendering the page
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
         * stores the maximum amount of characters that should be in one field
         *
         * fieldName => maxLength of the field
         */
        private $fieldMaxLength = [
            "userName" => 20,
            "preName" => 50,
            "lastName" => 50,
            "email" => 100,
            "password" => 50
        ];

        /**
         * stores error messages that should be returned to the user after rendering the page
         */
        private $customErrorStrings = [];

        /**
         * validates the user request data.
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateData() : bool {

            if (!$this->validateFieldGroupNotEmpty($this->fields, "POST")) {
                return false;
            }
            if (!$this->validateFieldGroupLength($this->fieldMaxLength)) {
                return false;
            }
            if (!$this->validateEmail()) {
                return false;
            }
            return true;
        }

        /**
         * validates the email adress to be a correct e-mail
         *
         * @return boolean true if the email is valid, false otherwise
         */
        private function validateEmail() : bool {
            return filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) !== false;
        }

        /**
         * adds the corresponding error messages if the the input parameters are false
         *
         * @param boolean $checkUserName the result of the database query to check if the userName already exists
         * @param boolean $checkEmail the result of the database query to check if the e-mail already exists
         *
         * @return boolean true if both input parameters are true, false otherwise
         */
        public function validateUserExists($checkUserName, $checkEmail) : bool {
            $valid = true;
            if ($checkUserName) {
                $this->customErrorStrings["floatingUserName"] = '"Der gewünschte Benutzername wurde bereits verwendet."';
                $valid = false;
            }
            if ($checkEmail) {
                $this->customErrorStrings["floatingEmail"] = '"Die gewünschte Email Adresse wurde bereits verwendet."';
                $valid = false;
            }
            return $valid;
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

        /**
         * hashes the password in $_POST["password"]
         */
        public function hashPassword() {
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        /**
         * returns the stored error strings in the form
         * "field1: errormessage1, field2: errormessage2, ..."
         *
         * @return string string with all errormessages and according field seperated by commatas.
         */
        public function getCustomErrorStrings() {
            $errorString = "";
            foreach ($this->customErrorStrings as $field => $errorMessage) {
                $errorString .= "$field: $errorMessage,";
            }
            return $errorString;
        }
    }

?>