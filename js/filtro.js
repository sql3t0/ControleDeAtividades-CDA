$(function(){
    $("#minhaTabela input").keypress(function(e){  
        if(e.which == 13) {      
            var index = $(this).parent().index();
            var nth = "#minhaTabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#minhaTabela tbody tr").show();
            $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                    $(this).parent().hide();
                }
            });
        }  
    });
 
   /* $("#minhaTabela input").blur(function(){
        $(this).val("");
        $("#minhaTabela tbody tr").show();
    });*/ 
    $("#minhaTabela .cls_filtro").click(function(){
        $("#minhaTabela input").val("");
        $("#minhaTabela tbody tr").show();
    });

    $("#minhaTabela input").keyup(function(e){  
        if(e.which == 8) {      
            var index = $(this).parent().index();
            var nth = "#minhaTabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#minhaTabela tbody tr").show();
            $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                    $(this).parent().hide();
                }
            });
        }  
    });''
});