<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Create page
     */
    class Create extends ViewBasis implements ViewInterface {
        public function render() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/create/create.php");
            $templateProperties["script"] = "<script src='JS/create.js'></script>";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

    }

?>