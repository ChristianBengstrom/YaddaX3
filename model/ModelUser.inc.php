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
    private $activated;
    private $pwd;

    public function __construct($uid, $activated) {
        $this->uid = $uid;
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

    public function create() {
        $sql = "insert into user (uid, password)
                        values (:uid, :pwd)";

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':uid', $this->getUid());
            $q->bindValue(':pwd', password_hash($this->getPwd(), PASSWORD_DEFAULT));
            $q->execute();
        } catch(PDOException $e) {
            printf("<p>Insert of user failed: <br/>%s</p>\n",
                $e->getMessage());
        }
        $dbh->query('commit');
    }

  // public function update($id, $attr, $newValue) {
  //   $sql = sprintf("update user
  //                   set %s = :pwd
  //                   where uid = '%s';"
  //                             , $attr
  //                             , $id);
  //
  //   $dbh = Model::connect();
  //   try {
  //       $q = $dbh->prepare($sql);
  //       // $q->bindValue(':pwd', password_hash($newValue, PASSWORD_DEFAULT));
  //       $q->bindValue(':pwd', $newValue);
  //       $q->execute();
  //   } catch(PDOException $e) {
  //       printf("<p>Update of user failed: <br/>%s</p>\n",
  //           $e->getMessage());
  //   }
  //   $dbh->query('commit');
  // }
    //
    // public static function ActivateUser($uid, $changeTo) {
    //   $sql = sprintf("update user
    //                   set activated = '%s'
    //                   where uid = '%s';"
    //                             , $changeTo
    //                             , $uid);
    //
    //   $dbh = Model::connect();
    //   try {
    //       $q = $dbh->prepare($sql);
    //       $q->execute();
    //   } catch(PDOException $e) {
    //       printf("<p>Insert of user failed: <br/>%s</p>\n",
    //           $e->getMessage());
    //   }
    //   $dbh->query('commit');
    // }

  public function delete($id) {
    $sql = sprintf("delete from user
                    where uid = '%s';"
                              , $id);

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

        public static function createObject($a) {
          $act = isset($a['activated'])? $a['activated'] : null;
          $user = new User($a['uid'], $act);
          if (isset($a['pwd1'])) {
              $user->setPwd($a['pwd1']);
          }
          return $user;
    }

  }
