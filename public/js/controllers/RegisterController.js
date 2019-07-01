var RegisterCtrl = angular.module('RegisterCtrl',[]);

RegisterCtrl.controller('RegisterController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', '$window', function($scope, $http, $location, $rootScope, $timeout, $window) {

  $scope.$watch('username', function(username) {
    if(username != undefined && username != '') {
      $http.post('/check-username', {username: username} ).then(function(response) {
        if(response.data.new.exists) {
          $('#username').addClass('taken');
         $('#username').parents('.form-group').find('.custom-help-block').show();
        } else {
         $('#username').parents('.form-group').find('.custom-help-block').hide();
          $('#username').removeClass('taken');
          if($('#locationSet').length == 1) {
            console.log($('#locationSet').val());
            if($('#locationSet').val() == "true") { 
//              $('#createAccount').removeAttr('disabled');
            }
          } else {
//            $('#createAccount').removeAttr('disabled');
          }

        }
      });
    } else {
//      $('#createAccount').attr('disabled','disabled');
    }
  });

  $scope.$watch('email', function(email) {
    console.log(email);
    if(email != undefined && email != '') {
      $http.post('/check-email', {email: email} ).then(function(response) {
        if(response.data.new.exists) {
          $('.step.second-step input[name="email"]').addClass('taken');
          $('.step.second-step input[name="email"]').parent().next('.custom-help-block').show();
        } else {
          $('.step.second-step input[name="email"]').removeClass('taken');
          $('.step.second-step input[name="email"]').parent().next('.custom-help-block').hide();
        }
      });
    }
  });
}]);