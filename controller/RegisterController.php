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

        private $fieldMaxLength = [
            "userName" => 20,
            "preName" => 50,
            "lastName" => 50,
            "email" => 100,
            "password" => 50
        ];

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

        private function validateEmail() : bool {
            return filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) !== false;
        }

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

        public function hashPassword() {
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        public function getCustomErrorStrings() {
            $errorString = "";
            foreach ($this->customErrorStrings as $field => $errorMessage) {
                $errorString .= "$field: $errorMessage,";
            }
            return $errorString;
        }
    }

?>