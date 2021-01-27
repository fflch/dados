
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

});