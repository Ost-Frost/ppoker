<?php

    require("ControllerBasis.php");

    class CreateController extends ControllerBasis {

        private $fields = [
            "gameTask"
        ];

        private $fieldMaxLength = [
            "epicNameSelected" => 100,
            "epicName" => 100,
            "gameTask" => 100,
            "epicDescription" => 500,
            "gameDescription" => 500
        ];

        private $creationMode = false;

        private $customErrorStrings = [];

        /**
         * validates the user request data.
         *
         * @return boolean true if all given data is correct, false otherwise
         */
        public function validateData() : bool {
            if (!$this->creationMode) {
                return false;
            }
            if (!$this->validateFieldGroupNotEmpty($this->fields, "POST")) {
                return false;
            }
            $checkMaxLengthFields = [];
            foreach ($this->fields as $key => $curField) {
                if (isset($this->fieldMaxLength[$curField])) {
                    $checkMaxLengthFields[$curField] = $this->fieldMaxLength[$curField];
                }
            }
            if (!$this->validateFieldGroupLength($checkMaxLengthFields)) {
                return false;
            }
            return true;
        }

        public function validateGameOrEpicExists($checkTaskName, $checkEpicName) : bool {
            $valid = true;
            if ($checkEpicName && $this->creationMode === "create") {
                $this->customErrorStrings["floatingEpicName"] = '"Die gewünschte Epic existiert bereits"';
                $valid = false;
            }
            if ($checkTaskName) {
                $this->customErrorStrings["floatingStory"] = '"Die gewünschte Story existiert bereits"';
                $valid = false;
            }
            return $valid;
        }

        public function determineRequestParameters() {
            $this->creationMode = $this->determineEpicCreationMode();
            if ($this->creationMode === "select") {
                array_push($this->fields, "epicNameSelected");
            } else if ($this->creationMode === "create") {
                array_push($this->fields, "epicName");
                if ($this->validateFieldNotEmpty("epicDescription")) {
                    array_push($this->fields, "epicDescription");
                }
            }
            if ($this->validateFieldNotEmpty("gameDescription")) {
                array_push($this->fields, "gameDescription");
            }
        }

        public function determineEpicCreationMode() {
            if ($this->validateFieldNotEmpty("epicNameSelected")) {
                return "select";
            } else if ($this->validateFieldNotEmpty("epicName")) {
                return "create";
            } else {
                return false;
            }
        }

        public function getUserList() {
            if ($this->validateFieldNotEmpty("userList")) {
                return $_POST["userList"];
            } else {
                return [];
            }
        }
    }
?>