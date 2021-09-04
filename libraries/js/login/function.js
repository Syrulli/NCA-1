

    $('form').on('submit', function (e) {

      e.preventDefault();

      $.ajax({

        type: 'post',

        url: '../../API/login/dummy-login.php',

        data: $('form').serialize(),

        datatype: 'json',

        beforeSend: function(){

          // CLEAR EFFECTS
          display_validation_username('',false);

        },
        
        success: function (e) {

          $.each(e, function(key, val){

            if(val.status == '200')
            {

              $('#modal_output').modal('show');

              $('.modal-body p').append(val.feedback);

              $('#a_goToDashboard').attr('href',val.url);
              
            }
            else if(val.status == '403')
            {
              $('.display-fail').text('Invalid Username and Password');
  
              $('.display-fail').removeClass('d-none')
            }
            else if(val.status == '401')
            {
              $('.display-fail').text(val.feedback);
  
              $('.display-fail').removeClass('d-none')
            }
            else if( val.status == '201' )
            {
              display_internal_server_error(val.feedback, val.sub_feedback)
            }
            else if( val.status == '415' ){

              display_validation_username('Username '+val.feedback);

            }

          })

          $('.input_box').removeAttr('disabled','disabled');

        }

      });

    });


    
    function display_validation_username(feedback, toValidate = true)
    {

      console.log(toValidate);

      if( toValidate )
      {
        $('#fb_username').removeClass('d-none');

        $('#fb_username small').text(feedback);

        $('#txt_username').addClass('border border-danger')

        $('#container_password').addClass('mt-2rem')

        $('#container_password').removeClass('mt-3')
      }
      else
      {

       

        $('#fb_username').addClass('d-none');

        $('#txt_username').removeClass('border border-danger')
    
        $('#container_password').removeClass('mt-2rem')
    
        $('#container_password').addClass('mt-3')
      }

    }
    
    function display_internal_server_error(feedback, sub_feedback)
    {

      $('#modal_output').modal('show');

      $('.modal-body p').append(feedback);

      $('.modal-body small').append(sub_feedback);

      $('.modal-body i').addClass('far fa-times-circle fa-2x');

      $('.modal-body i').css('color','red');

      $('#btn_modal').attr('onClick','refresh');

      $('#btn_modal').text('Retry');

    }



















    $(document).ready(function() {

      setTimeout(function(){

        $( ".load-screen" ).fadeOut( "slow", function() {
  
          $('.load-screen').addClass('d-none');
          
          $( ".content" ).fadeIn( "fast", function() {

            $('.content').removeClass('d-none');

          })
  
        });

      },1100)
    
    });

    


