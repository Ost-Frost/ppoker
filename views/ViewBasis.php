<?php

    class ViewBasis() {
        protected $model;
        protected $controller;

        public function __construct(ControllerBasis $controller, ModelBasis $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }
    }

?>