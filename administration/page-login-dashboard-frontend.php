<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- CSS bootsrap only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper bootsrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!-- icon likn bootsrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- jquery link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="../assets/js/script.js"></script>
     <!-- google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <!-- partie pour Nav page login -->

    <?php include("../assets/include/navbar-login-dashboard.php") ?>
 
    <!-- partie login dashboard -->
    <div class="container">
    
        <div class="heading">
            <h3 class="text-center">Admin login</h3>
            <p class="text-center" >Veuillez renseigner vos identifiants pour vous connecter</p>
        </div>
        <div class="row ">
            <div class="mb-12">
                <form id="connexion-admin" method="POST" action="" role="form">
                    <div class="mb-12 comment-login">
                        <label for="username">Identifiant:</label>
                        <input type="text" id="username" name="username" class="form-control"
                           >
                        <p class="comments-admin"></p>
                    </div>
                    <div class="mb-12 comment-login">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" class="form-control"
                            >
                        <p class="comments-admin"></p>
                    </div>
                
                    <div class="mb-12 text-center">
                        <input type="submit" class="btn btn-info" value="Connecter">
                    </div>
                  
                </form>
            </div>
        </div>
    </div>
   
</body>
</html>