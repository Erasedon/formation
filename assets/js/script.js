
    const url = new URL(window.location); 
    str ="";
    showResult(str);
    function showResult(str) {
        datas= {}
        if (str.length==0) {
            document.getElementsByClassName("livesearch").innerHTML="";
            // document.getElementsByClassName("livesearch").style.border="0px";
            $('.livesearch').html('<div id="loading" style="" ></div>');
            var competence = "";
            var categories = "";
            var ref = "";
            var type = "";
            var action = '';
            var rech =str ;
            var filter = "";

            if (action != "") { datas.action = action;}
            if (str = !"") { datas.str = rech;}
            if (filter != "") { datas.filter = filter;}
            if (competence != "") { datas.competence = competence;}
            if (categories != "") { datas.categories = categories;}
            if (ref != "") { datas.ref = ref;}
            if (type != "") { datas.type = type;}
      
            $.ajax({
                url: "assets/include/traitement_search.php",
                method: "GET",
                data: datas,
                success: function(data) {
                    // document.getElementById("livesearch").innerHTML=this.responseText;
                    $('.livesearch').html(data);
                    console.log('valeur vide ='+data);
                }
            });
            return;
        }
        $('.livesearch').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var filter = "";
        var competence = get_filter("competence");
        var categories = get_filter("categories");
        var ref = get_filter("ref");
        var type = get_filter("type");

        var rech =str ;
        if (action = !null) { datas.action = action;}
        if (str = !null) { datas.str = rech;}
        if (competence != "") { datas.competence = competence; datas.filter = filter;}
        if (categories != "") { datas.categories = categories; datas.filter = filter;}
        if (ref != "") { datas.ref = ref;  datas.filter = filter;}
        if (type != "") { datas.type = type; datas.filter = filter;}
        if(competence == "" && categories == "" && ref == "" && type == ""){datas.filter = "sansf";}
        
        $.ajax({
            url: "assets/include/traitement_search.php",
            method: "GET",
            data: datas,
            success: function(data) {
                // document.getElementById("livesearch").innerHTML=this.responseText;
                $('.livesearch').html(data);
            }
        });
    }
    // recuperer la valeur des checkbox 
    function get_filter(class_name) {
        // un array vide mit dans la variable filter & dans le tableau du class_name tout les checkbox true sont ajouter a la variable checkbox
        var filter = [];
        var checkbox = $('.' + class_name + ':checked'); 
        // ensuite on verifie si chexbox  est vide donc l'url sera vider et on modifie l'historique pour que l'utilisateur si retrouve 
        if(checkbox.length < 1) {
            history.pushState({}, '', url);
            url.searchParams.delete(class_name);
            
        } else {
            // sinon si checkbox n'est pas vide  on  modifie l'url en ajoutant class_name = filter sans oublier historique .
            checkbox.each(function(i) {
                filter.push($(this).val());
            });
            
            url.searchParams.set(class_name, filter.toString());         
            history.pushState({}, '', url);
        }
        // on retourne le tableau sous la forme  d'une chaine de caractere 
        return filter.toString();
    }

   // onclick des checkbox du filtre 
   $('.common_selector').on('click', function() {
    showResult();});


 //page login dashboard 

 $ (function(){

    $('#connexion-admin').submit(function (e){
  

        e.preventDefault();
        $('.comments-admin').empty();
        var postdata = $('#connexion-admin').serialize();
       

        $.ajax({
    
    type:'POST',
    url: 'page-login-dashboard-backend.php',
    data: postdata,
    dataType: 'json',

    success: function(result)
    {
   

    console.log(result);
        if(result.isSuccess){
         
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

