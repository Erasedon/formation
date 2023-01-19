<?php
session_start();



require_once '../assets/include/config.php';


// $id= '';
$array = array("username" =>"", "password" =>"",
"usernameError" => "", "passwordError"=>"",  "isSuccess"=>false);

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $array["username"] = verifyInput($_POST["username"]);
    $array["password"] = verifyInput($_POST["password"]);
    $array["isSuccess"] = true;

    if(empty($array["username"])){
        $array["usernameError"] ="Ecrire votre identifiant!";
        $array["isSuccess"] = false;
    }

    if(empty($array["password"])){
        $array["passwordError"] ="Ecrire votre mot de passe!";
        $array["isSuccess"] = false;
    }

/* Look for the username in the database. */
$query = 'SELECT * FROM loginDashboard WHERE username = :name';

$username =  $array["username"];
$password =  $array["password"];

/* Values array for PDO. */
$values = [':name' => $username];

/* Execute the query */

  $res = $db->prepare($query);
  $res->execute($values);

   $row = $res->fetch(PDO::FETCH_ASSOC);
    // $test2 = $row->rowCount();

    if($row){  
/* If there is a result, check if the password matches using password_verify(). */
if (password_verify($password, $row['password']))

    {

      $array["isSuccess"] = true;
    //   $_SESSION['id'] = $row['id'];
   
    //   $_SESSION['id'] = ['id'];     

    $_SESSION['id'] = $row['id'];
    // $_SESSION['id'] = $test['id'];



  }
  
  else {
    $array["isSuccess"] = false;
   
    $array["passwordError"] = "Identifiant et/ou mot de passe incorrect";
}
}
}




    echo json_encode($array, JSON_UNESCAPED_UNICODE);

function verifyInput($var)
{
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

?>