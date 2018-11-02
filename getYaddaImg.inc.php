<?php
  require_once './model/DbH.inc.php';
  require_once './model/ModelA.inc.php';

  $id = $_GET['uid'];
  // $type = $_GET['type'];
  $dateintime = $_GET['dateintime'];
  //
  // $sql  = "select i.img
  //               , i.mimetype
  //               , r.dateintime
  //          from image i
  //          join imgrelation r
  //          on i.id = r.iid
  //          where i.uid = 'admin'
  //          and i.type = 'YaddaIMG'
  //          and r.dateintime = '2018-11-02 09:04:53';";

  $sql  = "select i.img
                , i.mimetype
                , r.dateintime
           from image i
           join imgrelation r
           on i.id = r.iid
           where i.uid = $id
           and r.dateintime = $dateintime";


  $dbh = Model::connect();

  try {
      $q = $dbh->prepare($sql);
      $q->execute();
      $out = $q->fetch();
  } catch(PDOException $e)  {
      printf("Error getting image.<br/>". $e->getMessage(). '<br/>' . $sql);
      die('');
  }
  $out['img'] = stripslashes($out['img']);                                      // strip slashes that was added when inserting to the database
  header("Content-type: " . $out['mimetype']);
  echo $out['img'];

?>
