<?php

  
$pass2 = '123456';
        $param_password = password_hash($pass2, PASSWORD_DEFAULT);

echo $param_password;