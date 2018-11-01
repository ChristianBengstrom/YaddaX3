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

    public function createYadda() {
        $sql = sprintf("insert into yadda (uid, content)
                        values ('%s', '%s')"
                              , $this->getUid()
                              , $this->getContent());

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->execute();
        } catch(PDOException $e) {
            printf("<p>Insert failed: <br/>%s</p>\n",
                $e->getMessage());
        }
        $dbh->query('commit');
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
