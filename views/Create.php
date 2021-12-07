<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Create page
     */
    class Create extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * If the user data is invalid the register page is returned with a script that shows the user the wrong data.
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->controller->determineRequestParameters();
                if ($this->controller->validateData()) {
                    $checkEpicName = $this->model->checkEpicName();
                    $checkTaskName = $this->model->checkTaskName($this->controller->determineEpicCreationMode());
                    $checkUserList = $this->model->checkUserList($this->controller->getUserList());
                    if (!$this->controller->validateDataExists($checkTaskName, $checkEpicName, $checkUserList)) {
                        return $this->renderPOSTInvalidData();
                    }
                    if (!$this->model->createNewGame($this->controller->determineEpicCreationMode(), $this->controller->getUserList())) {
                        return $this->renderPOSTUnknownFailure();
                    }
                    return $this->renderPOSTSuccess();
                } else {
                    return $this->renderPOSTInvalidData();
                }
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                return $this->renderGET();
            } else {
                http_response_code(405); // Invalid method
                return "{}";
            }
        }

        /**
         * renders the page after a GET Request
         *
         * @return string rendered html string
         */
        private function renderGET() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $createTemplateProperties = $this->controller->getCreateTemplateProperties();
            $templateProperties["content"] = $this->openTemplate("templates/create/create.php", $createTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/create.js'></script>";
            $templateProperties["script"] .= $this->controller->getGETRequestScript();
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and a successful registration of the user
         *
         * @return string rendered html string
         */
        private function renderPOSTSuccess() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $createSuccessTemplateProperties = $this->controller->getCreateSuccessTemplateProperties();
            $templateProperties["content"] = $this->openTemplate("templates/create/createSuccess.php", $createSuccessTemplateProperties);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

        /**
         * renders the pager after a POST request and the user inserted invalid data
         *
         * @return string rendered html string
         */
        private function renderPOSTInvalidData() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $createTemplateProperties = $this->controller->getCreateTemplateProperties();
            $templateProperties["content"] = $this->openTemplate("templates/create/create.php", $createTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/create.js'></script>";
            $templateProperties["script"] .= "<script>";
            $templateProperties["script"] .= '    customErrorMessages = {' . $this->controller->getCustomErrorStrings() . '};';
            $templateProperties["script"] .= "    document.addEventListener('DOMContentLoaded', async (event) => {";
            if ($this->controller->determineEpicCreationMode() === "create") {
                $templateProperties["script"] .= '    await switchEpic("Create");';
            } else if ($this->controller->determineEpicCreationMode() === "select") {
                $templateProperties["script"] .= '    document.getElementById("sucheEpic").value = decodeHtml("'. $_POST["epicNameSelected"] . '");';
                $templateProperties["script"] .= '    await addEpic();';
            }
            $templateProperties["script"] .= "        validateAll(event);";
            $templateProperties["script"] .= "        await addMultipleUser(" . json_encode($this->controller->getUserList()) . ");";
            $templateProperties["script"] .= "    });";
            $templateProperties["script"] .= "</script>";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and an error occured in the registration process
         *
         * @return string rendered html string
         */
        private function renderPOSTUnknownFailure() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/create/createFailure.php", []);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>