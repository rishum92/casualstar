var PaymentCtrl = angular.module('PaymentCtrl',[]);

PaymentCtrl.controller('PaymentController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', '$interval', 'Upload', function($scope, $http, $location, $rootScope, $timeout, $interval, Upload) {

  $scope.cardTypes = [{name: 'Visa', value: 'visa'}, {name: 'MasterCard', value: 'mastercard'}, {name: 'American Express', value: 'amex'}];

  $scope.altDonate = function(username) {
    $scope.hideModal('donate');
    setTimeout(function() {
    	$scope.openModal('altDonate','username', username);
    	setTimeout(function() {
    		$('#altDonateMessage').val("Hello " + username + ", I would like to make a donation to you, but using another method. Lets talk and see what works best?");
    		$('#altDonateUsername').val(username);
		}, 100);
	}, 300);
  }

  $scope.openModal = function(modalName, optionKey, optionValue) {
    if(optionKey) {
      var modal = $scope.$eval(modalName);
      if(!modal['data']) {
        modal['data'] = [];
      }

      modal['data'][optionKey] = optionValue;
    }

    $('#' + modalName + 'Modal').modal('show');
  }

  $scope.hideModal = function(modalName) {
    $('#' + modalName + 'Modal').modal('hide');
  }

}]);