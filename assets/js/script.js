
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
        var rech =str ;
        if (action = !null) { datas.action = action;}
        if (str = !null) { datas.str = rech;}
        
        
        $.ajax({
            url: "assets/include/traitement_search.php",
            method: "GET",
            data: datas,
            success: function(data) {
                // document.getElementById("livesearch").innerHTML=this.responseText;
                $('.livesearch').html(data);
                console.log('valeur ='+data);
            }
        });
    }
