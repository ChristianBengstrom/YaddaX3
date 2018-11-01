<?php
  require_once './model/DbH.inc.php';
  require_once './model/ModelA.inc.php';

  $id = $_GET['uid'];

  $sql  = "select img, mimetype";
  $sql .= " from image";
  $sql .= " where uid = '$id'";
  $sql .= " and type = 'ProfileIMG';";

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
