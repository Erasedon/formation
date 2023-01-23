<?php
    try {
       
      
        /* Mode Local */
      
          $db=new PDO('mysql:host=localhost;dbname=formation;charset=utf8','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
     
           /* Mode en ligne */
      
        // $db=new PDO('mysql:host=db5006773312.hosting-data.io;dbname=dbs5603904;charset=utf8','dbu2407296','5Rc3y4Zg',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
?>
