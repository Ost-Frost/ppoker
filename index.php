<?php

    session_start();

    /**
     * a list of all available pages. every new page has to be added here in the form:
     * urlName => needsValidation
     *
     * urlName string:  the name of the URL to access this page. The corresponding Controller, Model and View have to be named the exact same way:
     *                  Controller: urlNameController
     *                  Model: urlNameModel
     *                  View: urlName
     * needsValidation boolean: if true the page can only be reached when logged in. if false the page can only be reached when logged out
     */
    $pages = [
        "Login" => false,
        "Logout" => true,
        "Home" => true,
        "Game" => true,
        "Create" => true,
        "Register" => false
    ];

    /**
     * this page will be reached when the user is logged out and enters the url of a page where he needs to be logged in
     * or a page that does not exist
     */
    $standardPageLogOut = "Login";

    /**
     * this page will be reached when the user is logged in and enters the url of a page where he needs to be logged out
     * or a page that does not exist
     */
    $standardPageLogIn = "Home";

    /**
     * validates if the user is logged in by checking the sessionData
     *
     * @return boolean true if the user is logged in, false otherwise
     */
    function validateUser() {
        if (!isset($_SESSION["userID"])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * renders a page by creating the corresponding model, controller and view and calling the render method of the view
     *
     * @param string page that should be rendered
     *
     * @return string rendered html string
     */
    function renderPage($page) : string {
        require("controller/" . $page . "Controller.php");
        require("models/" . $page . "Model.php");
        require("views/" . $page . ".php");

        $controller = new ($page . "Controller");
        $model = new ($page . "Model");
        $view = new $page($controller, $model);
        return $view->render();
    }

    /**
     * checks if the request is an API call
     *
     * @return bool true if the request is an API Call, false otherwise
     */
    function isAPICall() : bool {
        if (isset($_REQUEST["action"]) && $_REQUEST["action"] !== "") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * redirects the user to another page and ends the script
     * if the call was an API call response with 404 and empty JSON
     *
     * @param string the page the user should be redirectd to
     */
    function redirect($page) {

        if (isAPICall()) {
            http_response_code(404);
            echo "{}";
            exit;
        } else {
            header("Location: " . $page);
            exit;
        }
    }

    // remove special chars in POST requests to prevent cross side scripting and sql injection
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
    foreach ($_GET as $key => $value) {
        $_GET[$key] = htmlspecialchars($value, ENT_QUOTES);
    }

    // check if the requested page is valid.
    // If not redirect the user to the corresponding standard page or send 404 if the request is an apiCall.
    $renderPage = "";
    foreach ($pages as $testpage => $needsValidation) {
        if (strtolower($testpage) == strtolower($_REQUEST["page"])) {
            if ($needsValidation) {
                if (validateUser()) {
                    $renderPage = $testpage;
                } else {
                    redirect($standardPageLogOut);
                }
            } else {
                if (validateUser()) {
                    redirect($standardPageLogIn);
                } else {
                    $renderPage = $testpage;
                }
            }
        }
    }
    if ($renderPage === "") {
        if (validateUser()) {
            redirect($standardPageLogIn);
        } else {
            redirect($standardPageLogOut);
        }
    }

    // handle API calls
    if (isAPICall()) {
        require("controller/" . $renderPage . "Controller.php");
        require("models/" . $renderPage . "Model.php");

        $controller = new ($renderPage . "Controller");
        $model = new ($renderPage . "Model");

        $response = $controller->apiCall($_REQUEST["action"], $model);
        if ($response) {
            echo $response;
        } else {
            http_response_code(404);
            echo "{}";
        }

    // handle page requests
    } else {

        // render the valid page
        echo renderPage($renderPage);
    }

?>