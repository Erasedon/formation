<?php
include('../db/connectdb.php');	



if(isset($_GET["str"])){
    echo $_GET["str"];
    // var_dump($_GET["str"]);
}