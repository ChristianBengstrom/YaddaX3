<?php
/**
 * includes/ModelUser.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
class User extends Model {
    private $uid;       // string
    private $password;  // string ll=128
    private $firstname;
    private $lastname;
    private $email;
    private $pwd;
    private $activated;


    public function __construct($uid, $firstname, $lastname, $email, $activated) {
        $this->uid = $uid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->activated = $activated;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }
    public function getPwd() {
        return $this->pwd;
    }

    public function getUid() {
        return $this->uid;
    }
    public function getFirstName() {
        return $this->firstname;
    }
    public function getLastName() {
        return $this->lastname;
    }
    public function getEmail() {
        return $this->email;
    }

    public function create() {
        $sql = "insert into user (id, password, firstname, lastname, email)
                         values (:uid, :pwd, :firstname, :lastname, :email)";

        $dbh = Model::connect();
        // $dbh->beginTransaction();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':uid', $this->getUid());
            $q->bindValue(':pwd', password_hash($this->getPwd(), PASSWORD_DEFAULT));
            $q->bindValue(':firstname', $this->getFirstname());
            $q->bindValue(':lastname', $this->getLastname());
            $q->bindValue(':email', $this->getEmail());
            $q->execute();

            $actionAtrr = 'profile';
            $action = 'created';
            $f = array (
              'actionAtrr' => $actionAtrr,
              'action' => $action);
            $view1 = UserUpdateView::createObject($f);
            // $dbh->query('commit');
        } catch(PDOException $e) {
            printf("<p>Insert of user failed: <br/>%s</p>\n",
                $e->getMessage());
                // $dbh->rollBack();
        }

    }

  public function update($id, $attr, $newValue) {
    $sql = sprintf("update user
                    set %s = :pwd
                    where id = '%s';"
                              , $attr
                              , $id);

    $dbh = Model::connect();
    try {
        $q = $dbh->prepare($sql);
        $q->bindValue(':pwd', password_hash($newValue, PASSWORD_DEFAULT));
        $q->bindValue(':pwd', $newValue);
        $q->execute();
    } catch(PDOException $e) {
        printf("<p>Update of user failed: <br/>%s</p>\n",
            $e->getMessage());
    }
    $dbh->query('commit');
  }

    public static function ActivateUser($uid, $changeTo) {
      $sql = sprintf("update user
                      set activated = '%s'
                      where id = '%s';"
                                , $changeTo
                                , $uid);

      $dbh = Model::connect();
      try {
          $q = $dbh->prepare($sql);
          $q->execute();
      } catch(PDOException $e) {
          printf("<p>Insert of user failed: <br/>%s</p>\n",
              $e->getMessage());
      }
      $dbh->query('commit');
    }

  public function delete() {
    $sql = sprintf("delete from user
                    where id = '%s';"
                              , $this->getUid());

    $dbh = Model::connect();
    try {
        $q = $dbh->prepare($sql);
        $q->execute();
    } catch(PDOException $e) {
        printf("<p>Insert of user failed: <br/>%s</p>\n",
            $e->getMessage());
    }
    $dbh->query('commit');
  }

    public function __toString() {
        return sprintf("%s%s", $this->uid, $this->activated ? '' : ', not activated');
    }

    public static function retrievem() {
        $users = array();
        $dbh = Model::connect();

        $sql = "select *";
        $sql .= " from user";
        try {
            $q = $dbh->prepare($sql);
            $q->execute();
            while ($row = $q->fetch()) {
                $user = self::createObject($row);
                array_push($users, $user);
            }
        } catch(PDOException $e) {
            printf("<p>Query of users failed: <br/>%s</p>\n",
                $e->getMessage());
        } finally {
            return $users;
        }
    }

    public static function createObjectID($a) {
      $user = new User($_POST['uid']);

      return $user;
}

      public static function createObject($a) {
        $act = isset($a['activated'])? $a['activated'] : null;
        $user = new User($_POST['uid'], $_POST['fname'], $_POST['lname'], $_POST['email'], $act);
        if (isset($a['pwd1'])) {
            $user->setPwd($a['pwd1']);
        }
        return $user;
  }
}
