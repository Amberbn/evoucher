$(document).ready(function(){
    $('#prvImgBox').on({
        mouseenter: function() {
            if($('#output_image').prop('src') !== ''){
                $('#prvRemoveBtn').show();
                $('#prvImgBox').css('cursor','pointer');
                $('#output_image').css({'opacity':'0.6'});
                $('#prvImgBox').css({'background':'#000'});
                console.log('enter');
            }
        },
        mouseleave: function() {
            console.log('bye!');
            if($('#output_image').prop('src') !== ''){
                $('#prvRemoveBtn').hide();
                $('#output_image').css({'opacity':'1'});
                $('#prvImgBox').css({'background':'none'});
            }   
        }
    });

    $('#prvImgBox').on('click', function(event){
        event.preventDefault();
        $('#prvImgInput').val(null);
        $('#prvUploadBtn').show();
        $('#prvImgRes').show();
        $('#output_image').prop('src', '');
        $('#prvBox').hide();
        console.log('delete it..');
    });

});

function preview_image(event) 
{
    var reader = new FileReader();
    reader.onload = function()
    {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    $('#prvUploadBtn').hide();
    $('#prvBox').show();
    $('#prvImgRes').hide();
}