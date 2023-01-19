
    str ='';
    showResult(str);
    function showResult(str) {
        datas= {}
        if (str.length==0) {
            document.getElementsByClassName("livesearch").innerHTML="";
            // document.getElementsByClassName("livesearch").style.border="0px";
            $('.livesearch').html('<div id="loading" style="" ></div>');
            var action = '';
            var rech =str ;
            if (action != "") { datas.action = action;}
            if (str = !null) { datas.str = rech;}
        
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
        var filter = "sansf";
        var rech =str ;
        if (action = !null) { datas.action = action;}
        if (str = !null) { datas.str = rech;}
        if (filter != "") { datas.filter = filter;}
        
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