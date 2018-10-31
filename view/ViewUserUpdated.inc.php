<?php
/**
 * view/ViewUser.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once 'view/View.inc.php';

class UserUpdateView extends View {
  private $actionAttr;
  private $action;

    public function __construct($model) {
        parent::__construct($model);
        // $this->actionAttr = $actionAttr;
        // $this->action = $action;
    }

    public function getActionAttr() {
        return $this->actionAttr;
    }
    public function getAction() {
        return $this->action;
    }

    private function FeedBack() {
      // $s = sprintf("
      //       <h3>Your %s has been %s</h3>"
      //             , $this->getActionAttr()
      //             , $this->getAction()
      //             );
      $s = "<h3>Your profile has been createt.</h3>
            <p>
            Please wait for our lazy sysOps to activate your account
            </p>";

      return $s;
    }

    private function displayUpdate() {
        $s = sprintf("<main class='main'>\n%s</main>\n"
                    , $this->FeedBack());

        return $s;
    }

    public function display(){
       $this->output($this->displayUpdate());
    }

    public static function createObject($f) {
      $view1 = new UserUpdateView($f['actionAtrr'], $f['action']);

      return $view1;
    }
}
