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

    private function displayul() {
        $users = User::retrievem();
        $s = "<div class='haves'>";
        foreach ($users as $user) {
            $s .=  sprintf("%s<br/>\n"
                , $user);
        }
        $s .= "</div>";
        return $s;
    }

    private function userForm() {
        $s = sprintf("
            <form action='%s?function=U' method='post'>\n
            <div class='gets'>\n
                <h3>Create User</h3>\n
                <p>\n
                    Userid:<br/>
                    <input type='text' name='uid'/>\n
                </p>\n
                <p>\n
                    Pwd:<br/>
                    <input type='password' name='pwd1'/>\n
                </p>\n
                 <p>\n
                    Pwd repeat:<br/>
                    <input type='password' name='pwd2'/>\n
                </p>\n
                <p>\n
                    <input type='submit' name='createGo' value='createGo'/>
                </p>
            </div>", $_SERVER['PHP_SELF']);

        if (!Model::areCookiesEnabled()) {
            $s .= "<tr><td colspan='2' class='err'>Cookies
            from this domain must be
                      enabled before attempting login.</td></tr>";
        }
        $s .= "          </div>\n";
        $s .= "          </form>\n";
        return $s;
    }
    private function activateUserForm() {
        $s = sprintf(" <form action='%s?function=U' method='post'>\n
                          <div class='gets'>\n"
                        , $_SERVER['PHP_SELF']);

        $s .= "<h3>Activate User</h3>";

        $users = User::retrievem();
        $s .= "           <select name='activate_uid'>\n";

        foreach ($users as $user) {
            $t = (explode(",", $user));
            unset($t[1]);
            $t = implode(" ",$t);
            $s .=  sprintf("  <option value='%s'>%s</option>\n"
                , $t
                , $t);
        }
        $s .= "           </select>\n";

        $s .= "
                          <select name='state'>\n
                            <option value='1'>on</option>\n
                            <option value='0'>off</option>\n
                          </select>\n
                          <input type='submit' name='activateGo'>\n
                        </div>
                      </form>\n";

        return $s;
    }
    private function changePwdForm() {
      $s = sprintf("
          <form action='%s?function=U' method='post'>\n
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
          </div>", $_SERVER['PHP_SELF'], Authentication::getLoginId());

      return $s;
    }
    private function deleteUserForm() {
        $s = sprintf(" <form action='%s?function=U' method='post'>\n
                          <div class='gets'>\n"
                        , $_SERVER['PHP_SELF']);

        $s .= "<h3>Delete User</h3>";

        $users = User::retrievem();
        $s .= "           <select name='uid'>\n";

        foreach ($users as $user) {
            $t = (explode(",", $user));
            unset($t[1]);
            $t = implode(" ",$t);
            $s .=  sprintf("  <option value='%s'>%s</option>\n"
                , $t
                , $t);
        }
        $s .= "           </select>\n";

        $s .= "
                          <input type='submit' name='deleteGo'>\n
                        </div>
                      </form>\n";

        return $s;
    }
    private function displayUser() {
        $s = sprintf("<main class='main'>\n%s\n%s\n%s\n%s\n%s</main>\n"
                    , $this->displayul()
                    , $this->userForm()
                    , $this->changePwdForm()
                    , $this->activateUserForm()
                    , $this->deleteUserForm());

        return $s;
    }

    public function display(){
       $this->output($this->displayUser());
    }

}
