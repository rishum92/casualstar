function notify(type, message) {
  if(type == "success") { 
    var prefix = '<i class="ion-checkmark-circled"></i> ';
  } else if(type == "danger") {
    var prefix = '<i class="ion-close-circled"></i> ';
  } else if(type == "info") {
    var prefix = '<i class="ion-information-circled"></i> ';
  } else if(type == "warning") {
    var prefix = '<i class="ion-alert-circled"></i> ';
  } else {
    var prefix = '';
  } 

  $.notify(   
    {
      message: prefix + message,       
    }, 
  {
    type: type,  
    newest_on_top: false, 
    mouse_over: "pause",
    delay: 3000,
    placement: {
      from: "top",
      align: "center"  
    }, 
  });
}

function videoSelected(input) {
    var allowedFormats = ['video/mp4', 'video/quicktime'];
    if (input.files && input.files[0]) {
        var file = input.files[0];
        if(allowedFormats.indexOf(file.type) == -1) {
            notify('warning', 'Video format must be MP4 or MOV.');
            $('#unconfirmFiles').click();
            $('#video').addClass('hidden');
            return;
        }

        var maxSize = 280 * 1000;
        if(file) {
          var fileSize = file.size / 1000;
          if(fileSize > maxSize) {
            notify('warning', 'Selected file size exceeds max: 280MB');
            $('#unconfirmFiles').click();
            $('#video').addClass('hidden');
            return;
          }
          var reader = new FileReader();
          reader.onload = function(e) {
              var video = $('#video');
              video.attr('src', e.target.result);
              video.removeClass('hidden');
              $('#confirmFiles').click();
          }
          reader.readAsDataURL(input.files[0]);
        }
    } else {
        $('#unconfirmFiles').click();
        $('#video').addClass('hidden');
    }
}

function photoSelected(input) {
  if (input.files && input.files[0]) {
      var file = input.files[0];
      var fileSize = file.size / 1000;
      var maxSize = 4.5 * 1000;
      if(fileSize > maxSize) {
          notify('warning', 'Selected file size exceeds max: 4.5MB');
          return;
      }
      var reader = new FileReader();
      reader.onload = function(e) {
        var image = new Image;
        image.onload = function() {
            if(parseInt(this.width) < parseInt(this.height)) {
              notify('warning', 'You can only upload landscape photos.');
              input.value = '';
              return;
            }
            var imgControls = $(input).parents('.col-md-3').find('.img-controls');
            var img = imgControls.find('img');
            img.attr('src', e.target.result);
            imgControls.removeClass('hidden');
            $('#confirmFiles').click();
        };
        image.src = e.target.result;
      }
      reader.readAsDataURL(file);
  } else {
      var imgControls = $(input).parents('.col-md-3').find('.img-controls');
      var img = imgControls.find('img');
      img.removeAttr('src');
      imgControls.addClass('hidden');
      var filePresent = false;

      $('input.image-file').each(function(key, input) {
        if(input.value != '') {
            filePresent = true;
        }
      });

      if(!filePresent) {
        $('#unconfirmFiles').click();
      }
  }
}

function clickInputFile(button) {
  $(button).parent().find('input').click();
}

(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);
  
function uploadProgress(message) {
    return $.notify(
      {
        message: '<i class="fa fa-upload"></i>' + message,
      },
    {
      type: 'info',
      newest_on_top: false,
      showProgressbar: true,
      placement: {
        from: "top",
        align: "center"
      },
    }
  );
}

function cropperControl(button) {
  var cropper = $(button).parents('.form-group').find('.img-preview > img');
  cropper.cropper($(button).attr('data-method'), $(button).attr('data-option'))
}

function setCropData(cropper, data) {
  var formGroup = $(cropper).parents('.form-group');
  var xData = String(data.x);
  var yData = String(data.y);

  if(xData.indexOf("e-") > 0) {
    data.x = 0;
  }
  if(yData.indexOf("e-") > 0) { 
    data.y = 0;
  }

  formGroup.find('input[name="x"]').val(data.x);
  formGroup.find('input[name="y"]').val(data.y);
  formGroup.find('input[name="width"]').val(data.width);
  formGroup.find('input[name="height"]').val(data.height);
  formGroup.find('input[name="rotate"]').val(data.rotate);
}

function cleanModalData(modal) { 
  modal.find('input[type="file"]').val('');
  var modalPreview = modal.find('img');
  modalPreview.find('img').cropper('destroy');
  modalPreview.attr('src','');
  modalPreview.parent().fadeOut();
  modal.find('.photo-controls').fadeOut();
}

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function validateStep() {
  
  var valid = true;

  $('.step.second-step input').each(function() {

    var name = $(this).attr('name');

    // Get male and female radio inputs, used to check gender
    var male;
    var female;
     
    // Form value listeners
    if (name === "username") {
      $(this).parent().next('.custom-help-block').hide();
      var inputVal = $(this).val();
      var inputLength = $(this).val().length;
      var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
      if(!characterReg.test(inputVal)) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
      else if (inputLength < 2) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
      else if ($(this).hasClass('taken')) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "email") {
      $(this).parent().next('.custom-help-block').hide();
      var inputVal = $(this).val();
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if(!emailReg.test(inputVal)) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
      else if (!inputVal) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
      else if ($(this).hasClass('taken')) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "password") {
      $(this).parent().next('.custom-help-block').hide();
      var inputLength = $(this).val().length;
      if (inputLength < 4) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "password_confirmation") {
      $(this).parent().next('.custom-help-block').hide();
      var pass = $('input[name=password]');
      if ( $(this).val() != pass.val() ) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }
    else if (name === "gender") {
      inputVal = $(this).val();
      if (inputVal === "male") {
        var male = this;
      }
      else {
        var female = this;
      }
    }
    else {
      $(this).parent().next('.custom-help-block').hide();
      var inputVal = $(this).val();
      if (!inputVal) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }

  });

  // Gender is checked listener
  $(male).parent().next('.custom-help-block').hide();
  if ($(male).prop('checked') == false && $(female).prop('checked') == false) {
    $(male).parent().next('.custom-help-block').show();
    valid = false;
  } else {
    $(male).parent().next('.custom-help-block').hide();
  }

  // Final check if valid is true
  if (valid === true) {
    $('.second-step .step-btn').addClass('valid'); 
  }
  else {
    $('.second-step .step-btn').removeClass('valid');
  }
  
}

function twit_validateStep() {
  
  var valid = true;
  $('#twit_createAccount').attr('disabled', 'disabled');
  $('.step.last-step input').each(function() {
	  console.log("entered");
	var name = $(this).attr('name');
    // Get male and female radio inputs, used to check gender
    var male;
    var female;
     
    // Form value listeners
    if (name === "gender") {
      var inputVal = $(this).val();
      if (inputVal === "male") {
        var male = this;
      }
      else {
        var female = this;
      }
    }
    else {
      $(this).parent().next('.custom-help-block').hide();
      var inputVal = $(this).val();
      if (!inputVal) {
        $(this).parent().next('.custom-help-block').show();
        valid = false;
      }
    }

  });
// console.log($(male).prop('checked') + "&&" + $(female).prop('checked'));
  // Gender is checked listener
  $(male).parent().next('.custom-help-block').hide();
  if ($(male).prop('checked') == false && $(female).prop('checked') == false) {
    $(male).parent().next('.custom-help-block').show();
    valid = false;
  } else {
    $(male).parent().next('.custom-help-block').hide();
  }

  // Final check if valid is true
  if (valid === true) {
	 // console.log("validtrue");
    $('.last-step .step-btn').addClass('valid'); 
  }
  else {
	 // console.log("valid");
    $('.last-step .step-btn').removeClass('valid');
	$("#twit_location").trigger("geocode");
	// $('#twit_createAccount').removeAttr('disabled')
  }
  
}

$(document).ready(function() {
  
  // Chats open
  $('.toggle-chats').click(function() {
    $('.wrap.pusher').toggleClass('pushed');
    $('body').toggleClass('framed');
  });
  
  $('.user-menu .image').click(function() {
    $(this).find('.logout').toggleClass('mob-open');
  });
  
  
  
//  $('.mobile-users-box ul li').click(function() {
//    $('.wrap.pusher').toggleClass('pushed');
//  });

  // Index steps login & registration
  $('.main-btn.create-account').click(function() {
    $(this).parent().removeClass('in').addClass('out');
    $('.second-step').removeClass('out').addClass('in');
  });

//  $('.step.second-step .form-control').keyup(function() {
//    validateStep();
//  });
  
  $('.step.second-step .radio-group input[type="radio"]').click(function() {
    validateStep();
  });
  
  
  $('.step.second-step .main-btn').click(function() {
    validateStep();
  });

  /** Twit Validate **/
  $('.step.last-step .radio-group input[type="radio"]').click(function() {
	  // console.log("clicked");
    twit_validateStep();
  });
  
  
  $('.step.last-step .main-btn').click(function() {
	  console.log("button");
	 twit_validateStep();
  });
  
  $('.step.third-step .form-control').keyup(function() {
    
    var valid = true;

    $(this).parent().next('.custom-help-block').hide();
    var inputVal = $(this).val();
    if (!inputVal) {
      $(this).parent().next('.custom-help-block').show();
      valid = false;
    }

    if (valid === true) {
      $('#createAccount').removeAttr('disabled');
      $('.third-step .step-btn').addClass('valid');
    }
    else {
      $('.third-step .step-btn').removeClass('valid');
      $('#createAccount').attr('disabled','disabled');
    }
    
  });
  
  
  $('.main-btn.step-btn').click(function() { 

    if ( $(this).hasClass('valid') ) {
      $(this).parent().removeClass('in').addClass('out');
      $(this).parent().next().removeClass('out').addClass('in');
    }
    
    // Animate
    $('html, body').animate({
      scrollTop: $('#form-top').offset().top 
    }, 500);
    
  });
  

  $('.main-btn.login').click(function() {
    $(this).parent().removeClass('in').addClass('out');
    $('.login-step').removeClass('out').addClass('in');
	$('.twitter_login-step').removeClass('in').addClass('out');
  });
  
  $('.main-btn.twitter_login').click(function() {
    $(this).parent().removeClass('in').addClass('out');
    $('.twitter_login-step').removeClass('out').addClass('in');
    $('.login-step').removeClass('in').addClass('out');
  });
  
  $('.small-link.back-link.back-to-reg').click(function() {
    $('.login-step').removeClass('in').addClass('out');
    $('.twitter_login-step').removeClass('in').addClass('out');
    $('.last-step').removeClass('in').addClass('out');
    $('.second-step').removeClass('out').addClass('in');
  });
  
  $('.small-link.back-link.back-step').click(function() {
    $('.second-step').addClass('out').removeClass('in');
    $('.first-step').removeClass('out').addClass('in');
    $('.last-step').removeClass('in').addClass('out');
  });
  
  $('.small-link.back-link.back-step2').click(function() {
    $('.third-step').addClass('out').removeClass('in');
    $('.second-step').removeClass('out').addClass('in');
    $('.last-step').removeClass('in').addClass('out');
  });
  
  $('.small-link.back-link.back-step3').click(function() {
    $('.fourth-step').addClass('out').removeClass('in');
    $('.third-step').removeClass('out').addClass('in');
    $('.last-step').removeClass('in').addClass('out');
  });
  
  $('.back-login').click(function() {
    $('.login-step').addClass('out').removeClass('in');
    $('.twitter_login-step').addClass('out').removeClass('in');
    $('.first-step').removeClass('out').addClass('in');
    $('.last-step').addClass('out').removeClass('in');
  });


  // Menu toggle
  $('.menu-toggle').click(function() {
    $('.sidebar').toggleClass('open');
  });
  
  
  // Options toggle
  $('.options-toggle').click(function() {
    $('.options-container').toggleClass('open');
  });

  
  // Smooth scroll
  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          if($(target).attr('id') == 'messages-top') {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 650);
          } else {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
          }
            return false;
        }
      }
    });
  });
  
  $('.browse-members paging').click(function(){
    $("html, body").animate({ scrollTop: "50px" });
    console.log('click');
  });
  
});

$(window).scroll(function() {
  
  // User menu stick to top 
  var height = $(window).scrollTop();

  if(height  > 100) {
    $('.user-menu').addClass('fixed');
  }
  else {
    $('.user-menu').removeClass('fixed');
  }
}); 

