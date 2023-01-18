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
