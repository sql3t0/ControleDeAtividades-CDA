$(function(){
    $("#minhaTabela input").keyup(function(){        
        var index = $(this).parent().index();
        var nth = "#minhaTabela td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#minhaTabela tbody tr").show();
        $(nth).each(function(){
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }
        });
    });
 
    $("#minhaTabela input").blur(function(){
        $(this).val("");
    }); 
});