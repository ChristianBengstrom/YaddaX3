<?php
/**
 * controller/Controller.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once 'model/ModelA.inc.php';

class Controller {
    private $model;
    private $qs;
    private $function;

    public function __construct($qs) {
        $this->qs = $qs;
        foreach ($qs as $key => $value) {
            $$key = $value;
        }
        $this->function = isset($function) ? $function : 'A';
    }
    public function doSomething() {
        switch ($this->function) {
            case 'A':   //auth
                $this->model = new User(null, null, null, null, null);
                $view1 = new LoginView($this->model);
                if (isset($_POST)) {
                    $this->auth($_POST);
                }
                $view1->display();
                break;
            case 'Z':   //logout
                $this->model = new User(null, null, null, null, null);
                $view1 = new LoginView($this->model);
                $this->logout();
                $view1->display();
                break;
            case 'U':   //user create
                $this->model = new User(null, null, null, null, null); // init a model
                $view1 = new AdminView($this->model);                  // init a view
                if (isset($_POST['activateGo'])) {
                  $this->makeUserActive($_POST);
                } elseif (isset($_POST['changeGo'])) {
                  $this->adminChangeUserPwd($_POST);
                } elseif (isset($_POST['AdminDeleteGo'])) {
                  $this->AdminDeleteUser($_POST);
                }
                $view1->display();
                break;
            case 'T':   //Create User
                $this->model = new User(null, null, null, null, null);          // init a model
                $view1 = new UserUpdateView(null, null);                           // init a view
                if (isset($_POST['createGo'])&&($_POST['pwd1']===$_POST['pwd2'])) {
                  $this->createUser($_POST);                                     // activate controller
                }
                $view1->display();
                break;
             case 'Yadda':   //lang create
                $this->model = new Yadda(null, null, null); // init a model
                $view1 = new YaddaView($this->model);                     // init a view
                if (isset($_POST)) {
                    $this->createYadda($_POST);                  // activate controller
                }
                $view1->display();
                break;
          case 'Oneyadda':   //lang create
                $this->model = new Yadda($this->qs['tid'], $this->qs['uid'], null); // init a model
                $view1 = new YaddaOneView($this->model);                     // init a view

                $view1->display();
            break;
            case 'S':   //User Settings
                $this->model = new User(null, null, null, null, null);          // init a model
                $view1 = new UserView(null, null);                              // init a view
                if (isset($_POST['changeGo'])) {
                  $this->changeUserPwd($_POST);
                } elseif (isset($_POST['deleteGo'])) {
                  $this->deleteUser($_POST);
                }
                $view1->display();
                break;
        }
    }

    public function auth($p) {
        if (isset($p) && count($p) > 0) {
            if (!Authentication::isAuthenticated()
                    && Model::areCookiesEnabled()
                    && isset($p['uid'])
                    && isset($p['pwd'])) {
                        Authentication::authenticate($p['uid'], $p['pwd']);
                        $_SESSION['uid'] = $p['uid'];
            }
            $p = array();
        }
    }

    public function createYadda($p) {
        if (isset($p) && count($p) > 0) {
            $yaddas = Yadda::createYaddaObject($p);  // object from array
            $yaddas->createYadda($_POST);         // model method to insert into db
            $p = array();
        }
    }

    public function createUser($p) {
        if (isset($p) && count($p) > 0) {
            $user = User::createObject($p);                                     // object from array
            if ($p['pwd1'] == $p['pwd2']) {
              $user->create();                                                  // model method to insert into db
            }
            $p = array();
        }
    }

    public function makeUserActive() {
            $uid = $_POST['activate_uid'];
            $changeTo = $_POST['state'];
            User::ActivateUser($uid, $changeTo);
    }

    public function changeUserPwd($p) {
            $user = User::createObject($p,null,null,null,null);
            if ($p['pwd1'] == $p['pwd2']) {
              User::update();
            }
    }
    public function deleteUser($p) {
        $user = User::createObject($p,null,null,null,null);
        $user->delete();
    }

    public function adminChangeUserPwd($p) {
        $user = User::createObject($p,null,null,null,null);
        if ($p['pwd1'] == $p['pwd2']) {
          User::update();
        }
    }

    public function logout() {
        Authentication::Logout();
    }
}
