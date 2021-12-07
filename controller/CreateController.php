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

        public function validateDataExists($checkTaskName, $checkEpicName, $checkUserList) : bool {
            $valid = true;
            if ($checkEpicName && $this->creationMode === "create") {
                $this->customErrorStrings["floatingEpicName"] = '"Die gewünschte Epic existiert bereits."';
                $valid = false;
            }
            if ($checkTaskName) {
                $this->customErrorStrings["floatingStory"] = '"Die gewünschte Story existiert bereits."';
                $valid = false;
            }
            if (!$checkUserList) {
                $this->customErrorStrings["suche"] = '"Einige der angegebenen Benutzer existieren nicht."';
                $valid = false;
            }
            return $valid;
        }

        public function getCustomErrorStrings() {
            $errorString = "";
            foreach ($this->customErrorStrings as $field => $errorMessage) {
                $errorString .= "$field: $errorMessage,";
            }
            return $errorString;
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
                return "none";
            }
        }

        public function getUserList() {
            if ($this->validateFieldNotEmpty("userList")) {
                return $_POST["userList"];
            } else {
                return [];
            }
        }

        /**
         * generates the template Properties to render the create template by filling in the request data
         *
         * @return array the template properties for the create page
         */
        public function getCreateTemplateProperties() : array {

            $templateProperties = [];

            $allFields = ["gameTask", "gameDescription", "epicName", "epicDescription"];

            foreach ($allFields as $key => $field) {

                if (isset($_POST[$field]) && $_POST[$field] != "") {
                    $templateProperties[$field] = $_POST[$field];
                } else {
                    $templateProperties[$field] = "";
                }
            }

            return $templateProperties;
        }

        /**
         * generates the template Properties to render the createSuccess template by filling in the request data
         *
         * @return array the template properties for the create page
         */
        public function getCreateSuccessTemplateProperties() : array {

            $templateProperties = [];

            $url = "Create?";
            if ($this->creationMode === "select") {
                $url .= "epicName=" . $_POST["epicNameSelected"];
            } else {
                $url .= "epicName=" . $_POST["epicName"];
            }
            $url .= "&userList=" . json_encode($this->getUserList());

            $templateProperties["url"] = $url;
            return $templateProperties;
        }

        /**
         * generates additional JavaScript that requires PHP parameters in the GET request
         *
         * @return string script block as an html string
         */
        public function getGETRequestScript() : string{
            $isEpicNameSet = $this->validateFieldNotEmpty("epicName", "GET");
            $isUserListSet = $this->validateFieldNotEmpty("userList", "GET");
            $scriptString = "";

            if (!$isEpicNameSet && !$isUserListSet) {
                return $scriptString;
            }

            $scriptString .= "<script>";
            $scriptString .= "    document.addEventListener('DOMContentLoaded', async (event) => {";
            if ($isEpicNameSet) {
                $scriptString .= '    document.getElementById("sucheEpic").value = decodeHtml("'. $_GET["epicName"] . '");';
                $scriptString .= '    await addEpic();';
            }
            if ($isUserListSet) {
                $scriptString .= "    await addMultipleUser(" . htmlspecialchars_decode($_GET["userList"],ENT_QUOTES) . ");";
            }
            $scriptString .= "    });";
            $scriptString .= "</script>";

            return $scriptString;
        }
    }
?>