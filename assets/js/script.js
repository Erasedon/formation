function showResult(str) {
    datas= {}
    if (str.length==0) {
      document.getElementById("livesearch").innerHTML="";
      document.getElementById("livesearch").style.border="0px";
      return;
    }

    rech =str ;
    var action = 'fetch_data';
    if (action = !null) { datas.action = action;}
    if (str = !null) { datas.str = rech;}
   
    
    $.ajax({
        url: "assets/include/traitement_search.php",
        method: "GET",
        data: datas,
        success: function(data) {
            // document.getElementById("livesearch").innerHTML=this.responseText;
            $('#livesearch').html(data);
        }
    });
}



 //page login dashboard 

 $ (function(){

    $('#connexion-admin').submit(function (e){
        console.log('hello');

        e.preventDefault();
        $('.comments-admin').empty();
        var postdata = $('#connexion-admin').serialize();
        console.log('hello2');

        $.ajax({
    
    type:'POST',
    url: 'page-login-dashboard-backend.php',
    data: postdata,
    dataType: 'json',

    success: function(result)
    {
   console.log('printing result');
   console.log('hello3');

    console.log(result);
        if(result.isSuccess){
            console.log('ça marche');
            $("#connexion-admin").append("<p calss= 'thank-you'> Connexion reussi</p>");
            $("#connexion-admin")[0].reset();
           
            
            document.location.href="index.php";
              
        }
        else{
            console.log('erreur');
            $("#username + .comments-admin").html(result.usernameError);
            $("#password + .comments-admin").html(result.passwordError);
           
        }
    
    },
 
    
        });
    
    }); 
    
    
    });

    // Fin page login dashboard 