<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Home page
     */
    class MissingPage extends ViewBasis implements ViewInterface {
        public function render() : string {
            http_response_code(404); // page not found
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/missingPage/missingPage.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>