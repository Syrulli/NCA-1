
  
  $(document).ready(function() {

    setTimeout(function(){

      $( ".load-screen" ).fadeOut( "fast", function() { 
        
        $('.load-screen').addClass('d-none');

        $( ".content" ).fadeIn( "fast", function() {

          $('.content').removeClass('d-none');

          display_validation_username('',false);
        
          display_validation_email('',false);

          display_validation_referral('',false);
          
          display_validation_fields('',false);
          
        });
          
      });

    },1000)

  });

  $('form').on('submit', function (e) {

    e.preventDefault();

    $.ajax({

      type: 'post',

      url: '../../API/register/dummy-register.php',

      data:  $('form').serialize(),

      datatype: 'json',

      beforeSend: function() {

        $('.input_box').attr('disabled','disabled');

        $( ".load-screen" ).fadeIn( "slow", function() { $('.load-screen').removeClass('d-none'); });

        $( ".content" ).fadeOut( "slow", function() {

          $('.content').addClass('d-none');

        });
    
      },

      success: function (e) {

        setTimeout(function(){

          $( ".load-screen" ).fadeOut( "slow", function() {

            $('.load-screen').addClass('d-none');

            display_validation_username('',false);
        
            display_validation_email('',false);

            display_validation_referral('',false);
            
            display_validation_fields('',false);

            display_validation_password('', false);

          });

          $( ".content" ).fadeIn( "slow", function() {

            $.each(e, function(key, val){

              if( val.status == '200' )
              {
                validated_success(val.feedback,val.url)
              }

              else if( val.status == '201' )
              {
                display_internal_server_error(val.feedback, val.sub_feedback)
              }

              else if( val.status == '410' )
              {
                display_validation_username(val.feedback)
              }

              else if( val.status == '411' )
              {
                display_validation_email(val.feedback)
              }

              else if( val.status == '412' )
              {
                display_validation_referral(val.feedback)
              }

              else if( val.status == '413' )
              {
                display_validation_fields(val.feedback)
              }

              else if( val.status == '414' )
              {
                display_validation_email(val.feedback)
              }

              else if( val.status == '415' )
              {
                display_validation_username(val.feedback)
              }

              else if( val.status == '416' )
              {
                display_validation_password(val.feedback)
              }
    
            })

            $('.content').removeClass('d-none');

          });

          $('.input_box').removeAttr('disabled','disabled');

        }, 1500);

      },

      complete: function() {},

      error: function(xhr) { display_error() },

    });

  });

  $('#btn_terms').on('click', function(e){

    window.open("./terms_conditions.html");

  })

  function display_error(){

    $('#modal_output').modal('show');

    $('.modal-body p').append('INTERNAL ERROR:');

    $('.modal-body small').append('Please contact administrator');

    $('.modal-body i').addClass('far fa-times-circle fa-2x');

    $('.modal-body i').css('color','red');

    $('#btn_modal').attr('onClick','refresh');

    $('#btn_modal').text('Retry');
    
  }

  function validated_success(feedback, url)
  {
    $('#modal_output').modal('show');

    $('.modal-body p').append(feedback);

    $('.modal-body i').addClass('far fa-check-circle fa-2x');

    $('.modal-body i').css('color','green');

    $('#btn_modal').attr('href',url);

    $('#btn_modal').text('Go to Login');

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

  function display_validation_referral(feedback, toValidate = true)
  {

    if( toValidate )
    {
      $('#fb_referral').removeClass('d-none');

      $('#fb_referral small').text(feedback);

      $('#txt_referral').addClass('border border-danger')

      $('#fb2_referral').addClass('d-none')
    }
    else
    {
      $('#fb_referral').addClass('d-none');

      $('#txt_referral').removeClass('border border-danger')

      $('#fb2_referral').removeClass('d-none')
    }

  }
  
  function display_validation_fields(feedback, toValidate = true)
  {

    if( toValidate )
    {
      $('.display-fail').text(feedback);
    }
    else
    {
      $('.display-fail').text('');
     
    }

  }

  function display_validation_email(feedback, toValidate = true)
  {
    
    if( toValidate )
    {
      $('#fb_email').removeClass('d-none');

      $('#fb_email small').text(feedback);
  
      $('#txt_email').addClass('border border-danger')
  
      $('#fb2_email').addClass('d-none')
    }
    else
    {
      $('#fb_email').addClass('d-none');

      $('#txt_email').removeClass('border border-danger')
  
      $('#fb2_email').removeClass('d-none')
    }

  }

  function display_validation_username(feedback, toValidate = true)
  {

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

  function display_validation_password(feedback, toValidate = true)
  {

    if( toValidate )
    {
      $('#fb_password').removeClass('d-none');

      $('#fb_password small').text(feedback);

      $('#txt_password').addClass('border border-danger')

      $('#container_referral').addClass('mt-2rem')

      $('#container_referral').removeClass('mt-3')
    }
    else
    {
      $('#fb_password').addClass('d-none');

      $('#txt_password').removeClass('border border-danger')
  
      $('#container_referral').removeClass('mt-2rem')
  
      $('#container_referral').addClass('mt-3')
    }

  }


  function refresh(){

    window.location.reload();

  }




  
