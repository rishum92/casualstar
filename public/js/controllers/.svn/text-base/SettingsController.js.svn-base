var UserCtrl = angular.module('SettingsCtrl',[]);

UserCtrl.controller('SettingsController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', '$window', function($scope, $http, $location, $rootScope, $timeout, Upload, $window) {

  $http.get('/api/user').then(function(response) {
    $scope.user = response.data;
    $scope.email = $scope.user.email;
  });

  $scope.closeAccount = function() {
    //$window.location.href = '/close-account';
  }

  $scope.updateEmail = function() {
    if($scope.email != '' && $scope.email != $scope.user.email) {
      $http.post('/api/update-email', {email: $scope.email} ).then(function(response) {
        // $scope.user = response.data.new;
        notify(response.data.messageType, response.data.message);
      });
    }
  }

  $scope.changePassword = function() {
    if($('#oldPassword').val().length > 0 && $('#oldPassword').val().length > 1 &&  $('#oldPassword').val().length > 1) {
      $http.post('/api/change-password', {old_password: $('#oldPassword').val(), password: $('#password').val(), password_confirmation: $('#password_confirmation').val()} ).then(function(response) {
        // $scope.user = response.data.new;
        $scope.oldPassword = '';
        $scope.password = '';
        $scope.password_confirmation = '';
        
        notify(response.data.messageType, response.data.message);
      });
    }
  }

  $scope.deleteProfilePhoto = function() {
    $http.post('/api/delete-profile-photo').then(function(response) {
      notify(response.data.messageType, response.data.message);
      $http.get('/api/user').then(function(response) {
        $scope.user = response.data;
        $scope.email = $scope.user.email;
      });
    });
  }
 
}]);