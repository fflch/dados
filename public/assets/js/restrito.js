$(document).ready(function(){

    $("#collapseExAlunos #nivel").change(function(){
        var value = $(this).val();
        
        $("#collapseExAlunos #curso, #collapseExAlunos #area, #collapseExAlunos .curso-area").addClass('d-none');
        if(value == 'gr' ){
            $('#collapseExAlunos #curso, #collapseExAlunos .curso-area').removeClass('d-none');
        } else if (value == 1 || value == ''){
            $("#collapseExAlunos #curso, #collapseExAlunos #area, #collapseExAlunos .curso-area").addClass('d-none');
        } else{
            $('#collapseExAlunos #area, #collapseExAlunos .curso-area').removeClass('d-none');
        }
    });

    $("#collapseIntercambio #pessoa").change(function(){
        var value = $(this).val();
        
        $("#collapseIntercambio #curso, #collapseIntercambio #setor, #collapseIntercambio #ano, #collapseIntercambio .curso-setor").addClass('d-none');
        if(value == 'alunos_intercambistas' ){
            $('#collapseIntercambio #curso, #collapseIntercambio .curso-setor, #collapseIntercambio #ano').removeClass('d-none');
        } else if (value == 'alunos_estrangeiros'){
            $('#collapseIntercambio #ano').removeClass('d-none');
        } else if (value == 1 || value == ''){
            $("#collapseIntercambio #ano").addClass('d-none');
        } else if (value == 'docentes_estrangeiros'){
            $('#collapseIntercambio #setor, #collapseIntercambio .curso-setor, #collapseIntercambio #ano').removeClass('d-none');
        }
    });
    
    

    

  


});
