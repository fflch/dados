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

});