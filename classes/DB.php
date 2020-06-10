<?php
class DB{

        private static function connect(){
            $pdo=new PDO('mysql:host=localhost;dbname=SocialNetwork;charset=utf8','root','');
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $pdo;
          }
              //to interact with the database
     public static function query($query, $params=array()){
              $statement=self::connect()->prepare($query);
              $statement->execute($params);
              //The explode() function breaks a string into an array.
              if(explode(' ',$query)[0] =='SELECT'){
              $data=$statement->fetchAll();
              return $data;
              }
           }
}

?>
