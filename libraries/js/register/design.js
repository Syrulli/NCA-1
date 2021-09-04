$('.input-style').on('click', function(){

    var labelId = $(this).attr('aria-label');

    $(labelId).css('color','rgb(240, 65, 65)');

})

$('.input-style').on('focusout', function(){

    $('.label-style').each(function(val){

        if($(this).css('color') == 'rgb(240, 65, 65)')
        {
            $(this).css('color','#65657B')
        }

    })

})