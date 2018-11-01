<?php
/**
 * view/ViewUser.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once 'view/View.inc.php';

class UserView extends View {

    public function __construct($model) {
        parent::__construct($model);
    }

    private function changePwdForm() {
      $s = sprintf("
          <form action='%s?function=T' method='post'>\n
            <div class='gets'>\n
                <h3>Change Password</h3>\n
                <p>\n
                    Userid:<br/>
                    <input type='text' name='uid' value='%s'required readonly/>\n
                </p>\n
                <p>\n
                    New Password:<br/>
                    <input type='password' name='pwd1'/>\n
                </p>\n
                 <p>\n
                    Repeat new Password:<br/>
                    <input type='password' name='pwd2'/>\n
                </p>\n
                <p>\n
                    <input type='submit' name='changeGo' value='changeGo'/>\n
                </p>\n
            </div>
          </form>", $_SERVER['PHP_SELF'], Authentication::getLoginId());

      return $s;
    }
    private function deleteUserForm() {
        $s = sprintf(" <form action='%s?function=T' method='post'>\n
                          <div class='gets'>\n"
                        , $_SERVER['PHP_SELF']);

        $s .= "<h3>Delete User</h3>";

        $s .= sprintf( "<input type='text' name='uid' value='%s'required readonly/>\n", Authentication::getLoginId());

        $s .= "
                          <input type='submit' name='deleteGo'>\n
                        </div>
                      </form>\n";

        return $s;
    }
    private function displayUser() {
        $s = sprintf("<main class='main'>\n%s\n%s</main>\n"
                    , $this->changePwdForm()
                    , $this->deleteUserForm());

        return $s;
    }

    public function display(){
       $this->output($this->displayUser());
    }

}
