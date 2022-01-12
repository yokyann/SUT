<?php
//connecter la base de donnée à phpmyadmin
class Dbh{
    public function connect(){
        try {
            $db = "sut";
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpasswrd = "";
            $dbport = 3306;

            $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswrd);
            $pdo->exec("SET CHARACTER SET utf8");

            return $pdo;
        } catch (PDOException $e) {
            print "Error!: ". $e->getMessage() . "<br/>";
            die();
        }
        
    }
}