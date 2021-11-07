<?php

    /**
     * a collection of methods the view has to implement
     */
    interface ViewInterface {

        /**
         * renders the html string of the page
         *
         * @return string html string of the rendered page
         */
        public function render() : string;

    }

?>