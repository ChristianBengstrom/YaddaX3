<?php
/**
 * model/ModelCity.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once 'model/ModelB.inc.php';

class Yadda extends ModelB {
    private $dateintime;
    private $uid;
    private $content;

    public function __construct($dateintime
                              , $uid
                              , $content) {
        $this->dateintime = $dateintime;
        $this->uid = $uid;
        $this->content = $content;
    }

    public function getDateintime() {
        return $this->dateintime;
    }

    public function getUid() {
        return $this->uid;
    }

    public function getContent() {
        return $this->content;
    }

    // public function hasImage() {
    //       $sql = "select *";
    //       $sql .= " from yadda";
    //       try {
    //           $q = $dbh->prepare($sql);
    //           $q->execute();
    //           while ($row = $q->fetch()) {
    //               $yadda = self::createYaddaObject($row);
    //               array_push($yaddas, $yadda);
    //           }
    //       } catch(PDOException $e) {
    //           printf("<p>Query of users failed: <br/>%s</p>\n",
    //               $e->getMessage());
    //       } finally {
    //           return $yaddas;
    //       }
    // }

    public function createYadda() {
      $sql1succes = 1; $sql2succes = 1; $sql3succes = 1;

      // SQL FIRST INSERT
        $sql1 = "insert into yadda (uid, content)
                        values (:uid, :content)";

        $dbh = Model::connect();
        $dbh->beginTransaction();
        try {
            $q = $dbh->prepare($sql1);
            $q->bindValue(':uid', $this->getUid());
            $q->bindValue(':content', $this->getContent());
            $q->execute();
        } catch(PDOException $e) {
            printf("<p>Insert failed1: <br/>%s</p>\n",
                $e->getMessage());
                $sql1succes = 0;
        }

        if (isset($_FILES['img']) && count($_FILES['img']) > 0) {
          // SQL SECOND INSERT
          $image = addslashes(file_get_contents($_FILES['img']['tmp_name']));      // Temporary file name stored on the server +  addslashes
          $imagetype = $_FILES['img']['type'];

           $sql2 = "insert into image (uid, img, mimetype, type)
                            values (:uid, :imageitself, :mimetype, :type)";

           try {
             $q = $dbh->prepare($sql2);
             $q->bindValue(':uid', $this->getUid());
             $q->bindValue(':imageitself', $image);
             $q->bindValue(':mimetype', $imagetype);
             $q->bindValue(':type', 'YaddaIMG');
             $q->execute();
             $lastiid = $dbh->lastInsertId().'<br />';
           } catch(PDOException $e) {
               printf("<p>Insert2 of user failed: <br/>%s</p>\n",
                   $e->getMessage());
                   $sql2succes = 0;
           }
         }
         // SQL THIRD INSERT
         $sql3 = "insert into imgrelation (iid, uid)
                  values (:iid, :uid)";

          try {
            $q = $dbh->prepare($sql3);
            $q->bindValue(':iid', $lastiid);
            $q->bindValue(':uid', $this->getUid());
            $q->execute();
          } catch(PDOException $e) {
              printf("<p>Insert3 of user failed: <br/>%s</p>\n",
                  $e->getMessage());
                  $sql3succes = 0;
          }

          if ($sql1succes == 1 && $sql2succes == 1 && $sql3succes == 1) {
            $dbh->query('commit');
          } else {
            $dbh->rollBack();
            echo "Error" . $sql3succes.$sql3succes.$sql3succes;
          }
    }

    public function update($uid, $content) {}     // required by ModelB
    public function delete($dateintime) {}     // required by ModelB

          public static function retrievem() {
            $yaddas = array();
            $dbh = Model::connect();

            $sql = "select *";
            $sql .= " from yadda";
            try {
                $q = $dbh->prepare($sql);
                $q->execute();
                while ($row = $q->fetch()) {
                    $yadda = self::createYaddaObject($row);
                    array_push($yaddas, $yadda);
                }
            } catch(PDOException $e) {
                printf("<p>Query of users failed: <br/>%s</p>\n",
                    $e->getMessage());
            } finally {
                return $yaddas;
            }
        }

        public static function retrieve2($uid, $tid) {
          $yaddas = array();
          $dbh = Model::connect();

          $sql = "select *";
          $sql .= " from yadda";
          $sql .= " where uid = :uid";
          $sql .= " and dateintime = :tid";
          try {
             $q = $dbh->prepare($sql);
             $q->bindValue(':uid', $uid);
             $q->bindValue(':tid', $tid);
             $q->execute();
             while ($row = $q->fetch()) {
                  $yadda = self::createYaddaObject($row);
                  array_push($yaddas, $yadda);
             }
          } catch(PDOException $e) {
             printf("<p>Query of users failed: <br/>%s</p>\n",
                  $e->getMessage());
          } finally {
             return $yaddas;
          }
     }

    public static function createYaddaObject($a) {
        $dateintime = $a['dateintime'];
        $uid = $a['uid'];
        $content = $a['content'];
        $yadda = new Yadda($dateintime
                       , $uid
                       , $content);
        return $yadda;
    }
}
