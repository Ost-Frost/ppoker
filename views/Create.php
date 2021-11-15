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
                    $checkTaskName = $this->model->checkTaskName();
                    if (!$this->controller->validateGameOrEpicExists($checkTaskName, $checkEpicName)) {
                        return $this->renderPOSTInvalidData();
                    }
                    $createNewEpic = ($this->controller->determineEpicCreationMode() === "create");
                    if (!$this->model->createNewGame($createNewEpic)) {
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
            $templateProperties["content"] = $this->openTemplate("templates/create/create.php");
            $templateProperties["script"] = "<script src='JS/create.js'></script>";
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
            $templateProperties["content"] = $this->openTemplate("templates/register/registerSuccess.php", []);
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
            $templateProperties["content"] = $this->openTemplate("templates/register/registerFailure.php", []);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and an error occured in the registration process
         *
         * @return string rendered html string
         */
        private function renderPOSTUnknownFailure() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/register/registerFailure.php", []);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>