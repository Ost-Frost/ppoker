<?php

    /**
     * the base class for a view. All views have to extend this class
     */
    class ViewBasis {

        protected $model;
        protected $controller;

        /**
         * @param ControllerBasis the corresponding controller object
         * @param ModelBasis the corresponding model object
         */
        public function __construct(ControllerBasis $controller, ModelBasis $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }

        /**
         * loads a template and returns the rendered html string
         *
         * @param string the path to the template file
         * @param array properties for the template. the template file can access the properties via $templateProperties
         *
         * @return string the rendered html string
         */
        public function openTemplate($fileLink, $templateProperties) : string {
            ob_start();
            require ($fileLink);
            $html=ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }

?>