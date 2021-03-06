<?php
/**
 * view/View.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once 'model/ModelA.inc.php';

abstract class View {

    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    private function top() {
        $s = sprintf("<!doctype html>
<html>
  <head>
    <meta charset='utf-8'/>
    <title>MVC Example (nml)</title>
    <link rel='stylesheet' href='./css/styles.css'/>
  </head>
  <body>\n
");
        return $s;
    }

    private function bottom() {
        $s = sprintf("
  </body>
</html>");
        return $s;
    }

    private function topmenu() {
        $s = sprintf("        <header>
            <h1>YaddaX3</h1>\n
            <ul id='menu'>\n
                <li><a href='%s'>Home</a></li>\n",
                $_SERVER['PHP_SELF']);
        if (Authentication::isAuthenticated()) {
            $s .= sprintf("               <li><a href='%s?function=S'>Settings</a></li>\n
                                          <li><a href='%s?function=Yadda'>Timeline</a></li>\n"
                , $_SERVER['PHP_SELF'], $_SERVER['PHP_SELF']);
        }

        if (!Authentication::isAuthenticated()) {
            $s .= sprintf("                <li><a href='%s?function=A'>Login</a></li>\n"
                    , $_SERVER['PHP_SELF']);
        } else {
            $s .= sprintf("                <li><a href='%s?function=U'>Admin</a></li>
                                           <li><a href='%s?function=Z'>Logout</a></li>\n"
                                            , $_SERVER['PHP_SELF'], $_SERVER['PHP_SELF']);
        }
        $s .= sprintf("             </ul>\n        </header>\n");

        if (Authentication::isAuthenticated()) {
            $s .= sprintf("%8s<div>Welcome %s</div>\n", " ", Authentication::getLoginId());
        }
        return $s;
    }

    public function output($s) {
        print($this->top());
        print($this->topmenu());
        printf("%s", $s);
        print($this->bottom());
    }
}
