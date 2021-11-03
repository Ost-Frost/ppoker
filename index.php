<?php

    $pages = [

    ];

    function renderPage($page) {
        require("controller/" . $page . "Controller.php");
        require("model/" . $page . "Model.php");
        require("view/" . $page . ".php");

        $controller = new $page . "Controller";
        $model = new $page . "Model";
        $view = new $page($controller, $model);
        return $view->render();
    }

    foreach ($pages as $testpage) {
        if (strtolower($testpage) == strtolower($_REQUEST["page"])) {
            echo renderPage($testpage);
        }
    }

?>