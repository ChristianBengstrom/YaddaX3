<?php
/**
 * model/Authentication.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once './model/AuthA.inc.php';


class Authentication extends AuthA {

    protected function __construct($user, $pwd) {
        parent::__construct($user);
        try {
            self::dbLookUp($user, $pwd);                                        // invoke auth
            $_SESSION[self::$sessvar] = $this->getUserId();                     // succes
        }
        catch (Exception $e) {
            self::$logInstance = FALSE;
            unset($_SESSION[self::$sessvar]);                                   //miserys
            print "error";                                                      //move to a view
        }
    }

    public static function authenticate($user, $pwd) {
        if (! self::$logInstance) {
            self::$logInstance = new Authentication($user, $pwd);
        }
        return self::$logInstance;
    }

    protected static function dbLookUp($user, $pwdtry) {
        // Using prepared statement to prevent SQL injection
        $sql = "select id, password
                from user
                where id = :uid
                and activated = true;";

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':uid', $user);
            $q->execute();
            $row = $q->fetch();

            if (!($row['id'] === $user
                    && password_verify($pwdtry, $row['password']))) {
                 throw new Exception("Not authenticated", 42);                  //misery
            }
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
}
