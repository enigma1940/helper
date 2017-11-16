<?php

  try{
    /*
      ** DATABASE: dbase
      ** HOST: localhost
      ** USER: root
      ** PASSWORD: [nothing]
    */
    $bdd=new PDO('mysql:dbname=dbase;host=localhost','root', '');
  }catch(Exception $e){
    die('Error : '.$e->getMessage());
  }

?>
