
$(document).ready(function(){
    $("#formSearchProducaoPrograma #tipo").change(function(){
        var value = $(this).val();
        
        $(".tipo-div-input").addClass('d-none');
        if(value.length == 0){
            $('#formSearchProducaoPrograma .btn-send').addClass('d-none');
        }else{
            $('#formSearchProducaoPrograma .btn-send').removeClass('d-none');
        }
        $("."+value).removeClass('d-none');
    });
    
    $("#formSearchPesquisa #filtro").change(function(){ //executa toda vez que o select do tipo de filtragem mudar de valor
        var value = $(this).val(); //pega o valo deste select
        
        $(".tipo-div-input.serie_historica").addClass('d-none');//desaparece os selects de anos
        if(value.length == 0){
            $('#formSearchProducaoPrograma .btn-send').addClass('d-none');//se o tipo de filtragem retornar nada, o botão de "enviar" irá desaparecer
        }else{
            $('#formSearchProducaoPrograma .btn-send').removeClass('d-none');//caso contrário o botão ficará visível
        }
        $("."+value).removeClass('d-none');//se série histórica for selecionada, os campos de anos irá aparecer
    });

});