$(document).ready(function(){
   changeBGColor();
});

function changeBGColor(){
    $('.form-input-color').change(function(){
        var colorVal = $(this).val();
        var idColorName = $(this).prop('name');
        $('#'+idColorName).html();
        if(idColorName == 'bg-message-color'){
            $('.m-preview').css('background', colorVal);
        }else{
            $('#message-title-output, #message-description-output').css('color', colorVal);
        }
        console.log(idColorName);
        console.log(colorVal);
    });
}

function typeForm(e){
    var idName = $(e).prop('id');
    var inputVal = $('#'+idName).val();
    // console.log(inputVal);
    $('#'+idName+'-output').html(inputVal);
}