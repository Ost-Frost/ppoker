<?php

    $pages = [
        "Login",
        "Home",
        "Game",
        "Register"
    ];

    function renderPage($page) {
        require("controller/" . $page . "Controller.php");
        require("models/" . $page . "Model.php");
        require("views/" . $page . ".php");

        $controller = new ($page . "Controller");
        $model = new ($page . "Model");
        $view = new $page($controller, $model);
        return $view->render();
    }

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
    }

    foreach ($pages as $testpage) {
        if (strtolower($testpage) == strtolower($_REQUEST["page"])) {
            echo renderPage($testpage);
        }
    }

?>