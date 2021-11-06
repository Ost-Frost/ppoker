<?php

    class ViewBasis {
        protected $model;
        protected $controller;

        public function __construct(ControllerBasis $controller, ModelBasis $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }

        public function openTemplate($fileLink, $templateProperties) {
            ob_start();
            require ($fileLink);
            $html=ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }

?>