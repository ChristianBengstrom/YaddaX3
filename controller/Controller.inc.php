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
                $this->model = new User(null, null, null, null, null, null, null);
                $view1 = new LoginView($this->model);
                if (isset($_POST)) {
                    $this->auth($_POST);
                }
                $view1->display();
                break;
            case 'Z':   //logout
                $this->model = new User(null, null, null, null, null, null, null);
                $view1 = new LoginView($this->model);
                $this->logout();
                $view1->display();
                break;
            case 'U':   //user create
                $this->model = new User(null, null, null, null, null, null, null); // init a model
                $view1 = new UserView($this->model);                  // init a view
                if (isset($_POST['activateGo'])) {
                  $this->makeUserActive();
                } elseif (isset($_POST['changeGo'])) {
                  $this->changeUserPwd();
                } elseif (isset($_POST['AdminDeleteGo'])) {
                  $this->AdminDeleteUser();
                }
                $view1->display();
                break;
            case 'T':   //user create
                $this->model = new User(null, null, null, null, null, null, null); // init a model
                $view1 = new UserUpdateView(null, null);                           // init a view
                if (isset($_POST['createGo'])) {
                    $this->createUser($_POST);                                     // activate controller
                } elseif (isset($_POST['changeGo'])) {
                  $this->changeUserPwd();
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
            }
            $p = array();
        }
    }
    //
    // public function createCountry($p) {
    //     if (isset($p) && count($p) > 0) {
    //         $p['code'] = $_POST['code']; // augment array with dummy
    //         $country = Country::createObject($p);  // object from array
    //         $country->create();         // model method to insert into db
    //         $p = array();
    //     }
    // }
    // public function updateCountry($p) {
    //   if (isset($p) && count($p) > 0) {
    //       $p['code'] = $_POST['code'];                          // augment array with dummy
    //       $country = Country::createObject($p);           // object from array
    //       // $id = $_POST['id'];
    //       $country->update($p, null, null);           // model method to insert into db
    //       $p = array();
    //   }
    // }
    // public function deleteCountry($p) {
    //       $id = $_POST['code'];
    //       country::delete($id);
    // }
    // public function createCity($p) {
    //     if (isset($p) && count($p) > 0) {
    //         $p['id'] = null; // augment array with dummy
    //         $city = City::createObject($p);  // object from array
    //         $city->create();         // model method to insert into db
    //         $p = array();
    //     }
    // }
    // public function updateCity($p) {
    //   if (isset($p) && count($p) > 0) {
    //       $p['id'] = null;                          // augment array with dummy
    //       $city = City::createObject($p);           // object from array
    //       $id = $_POST['id'];
    //       $city->update($id, null, null);           // model method to insert into db
    //       $p = array();
    //   }
    // }
    // public function deleteCity($p) {
    //       $id = $_POST['id'];
    //       city::delete($id);
    // }
    // public function createLanguage($p) {
    //     if (isset($p) && count($p) > 0) {
    //         $language = CountryLanguage::createObject($p);  // object from array
    //         $language->create();         // model method to insert into db
    //         $p = array();
    //     }
    // }
    // public function updateLanguage($p) {
    //     if (isset($p) && count($p) > 0) {
    //         $p['countrycode'] = $_POST['countrycode'];
    //         $p['language'] = $_POST['language'];                     // augment array with dummy
    //         $language = CountryLanguage::createObject($p);  // object from array
    //         $language->update(null, null, null);           // model method to insert into db
    //         $p = array();
    //     }
    // }
    // public function deleteLanguage($p) {
    //       $p['countrycode'] = $_POST['countrycode'];
    //       $p['language'] = $_POST['language'];                     // augment array with dummy
    //       $language = CountryLanguage::createObject($p);
    //       // $id = $_POST['countrycode'];
    //       $language->delete(null);
    // }

    public function createUser($p) {
        if (isset($p) && count($p) > 0) {
            $user = User::createObject($p);  // object from array
            $user->create();         // model method to insert into db

            $p = array();
        }
    }

    public function makeUserActive() {
            $uid = $_POST['activate_uid'];
            $changeTo = $_POST['state'];
            User::ActivateUser($uid, $changeTo);
    }

    public function changeUserPwd() {
            $id = $_POST['uid'];
            $attr = "password";
            if ($_POST['pwd1'] == $_POST['pwd2']) {
              $newValue = $_POST['pwd1'];
              User::update($id, $attr, $newValue);
            //
            }
    }
    public function deleteUser($p) {
        $user = User::createObject($p);
        $user->delete();
        // $id = $_POST['id'];
        // User::delete();
    }

    public function logout() {
        Authentication::Logout();
    }
}
