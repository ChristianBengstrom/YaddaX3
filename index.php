<?php
/**
 * index.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
    session_start();
    // Model
    require_once './model/ModelA.inc.php';
    require_once './model/ModelB.inc.php';
    require_once './model/ModelUser.inc.php';
    require_once './model/ModelYadda.inc.php';
    // View
    require_once './view/ViewUser.inc.php';
    require_once './view/ViewLogin.inc.php';
    require_once './view/ViewYadda.inc.php';
    require_once './view/ViewOneYadda.inc.php';
    require_once './view/ViewUserUpdated.inc.php';
    //Controller
    require_once './controller/Controller.inc.php';
    //Other Inc's

    $controller = new Controller($_GET);
    $controller->doSomething();
?>
