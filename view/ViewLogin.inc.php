<?php
/**
 * view/ViewLogin.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */

require_once 'view/View.inc.php';

class LoginView extends View {

    public function __construct($model) {
        parent::__construct($model);
    }

    private function loginForm() {
        $s = sprintf("\n
            <form action='%s' method='post'>\n
            <table id='login'>\n
                <caption>Login</caption>\n
                <tr>\n
                    <td>Userid:</td><td><input type='text' name='uid'/></td>\n
                </tr>\n
                <tr>\n
                    <td>Pwd: </td><td><input type='password' name='pwd'/></td>\n
                </tr>\n
                <tr>\n
                    <td></td>\n
                    <td>
                        <p>
                        <input type='submit' value='OK'/>&nbsp;&nbsp;&nbsp;
                        <button onclick='window.location=./index.php?f=A'>I Surrender</button>
                        </p>
                    </td>\n
                </tr>\n", $_SERVER['PHP_SELF']);

        if (!Model::areCookiesEnabled()) {
            $s .= "<tr><td colspan='2' class='err'>Cookies
            from this domain must be
                      enabled before attempting login.</td></tr>";
        }
        $s .= "          </table>\n";
        $s .= "          </form>\n";
        return $s;
    }

    private function registerForm() {                                           // forDEBUG http://x15.dk/hitme.php
        $s = sprintf("
            <form action='%s?function=T' method='post' enctype='multipart/form-data'>\n
            <div class='gets'>\n
                <h3>Create User</h3>\n
                <p>\n
                    Usename:<br/>
                    <input type='text' name='uid' required/>\n
                </p>\n
                <p>\n
                    Firstname:<br/>
                    <input type='text' name='fname' required/>\n
                </p>\n
                <p>\n
                    Lastname:<br/>
                    <input type='text' name='lname' required/>\n
                </p>\n
                <p>\n
                    Email:<br/>
                    <input type='text' name='email' required/>\n
                </p>\n
                <p>\n
                    Prifile Image:<br/>
                    <input type='hidden' name='MAX_FILE_SIZE' value='131072'/>  <!-- Remember max file size! -->
                    <input type='file' id='bild' name='img' required/>
                </p>\n
                <p>\n
                    Pwd:<br/>
                    <input type='password' name='pwd1' required/>\n
                </p>\n
                 <p>\n
                    Pwd repeat:<br/>
                    <input type='password' name='pwd2' required/>\n
                </p>\n
                <p>\n
                    <input type='submit' name='createGo' value='createGo'/>
                </p>
            </div>", $_SERVER['PHP_SELF']);

        if (!Model::areCookiesEnabled()) {                                      // Repeated!! change to a function.
            $s .= "<tr><td colspan='2' class='err'>Cookies
            from this domain must be
                      enabled before attempting login.</td></tr>";
        }
        $s .= "          </div>\n";
        $s .= "          </form>\n";
        return $s;
    }

    private function displayForms() {
      if (!Authentication::isAuthenticated()) {
        $s = sprintf("<main class='main'>\n%s\n%s</main>\n"
                    , $this->loginForm()
                    , $this->registerForm());
        return $s;
      }
    }

    public function display(){
       $this->output($this->displayForms());
    }
}
