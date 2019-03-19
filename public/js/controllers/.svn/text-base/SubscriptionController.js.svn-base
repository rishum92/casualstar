var SubscriptionCtrl = angular.module('SubscriptionCtrl',[]);

function isAlphaNumeric(str) {
  var code, i, len;

  for (i = 0, len = str.length; i < len; i++) {
    code = str.charCodeAt(i);
    if (!(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)) { // lower alpha (a-z)
      return false;
    }
  }
  return true;
};

SubscriptionCtrl.controller('SubscriptionController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', '$window', function($scope, $http, $location, $rootScope, $timeout, Upload, $window) {

  $scope.perPageDonationAttempts = 12;
  $scope.pageDonationAttempts = 0;

  $http.get('/api/user').then(function(response) {
    $scope.user = response.data;

    $http.get('/api/donation-attempts?1=1&pageDonationAttempts=' + $scope.pageDonationAttempts + '&perPageDonationAttempts=' + $scope.perPageDonationAttempts).then(function(response) {
      $scope.donationAttempts = response.data.new.donationAttempts;
      $scope.totalDonationAttempts = response.data.new.count;
    });
  });



  $scope.update = function(value, key, id) {
    if((key == 'paypal_url' || key == 'cashme_url' || key == 'cashme_url_uk' || key == 'alt_url')) {
      if(isAlphaNumeric(value) || value == '') {
        $http.patch('/api/user/' + id,{key: key, value: value}).then(function(response) {
          notify(response.data.messageType, response.data.message);
          $http.get('/api/user').then(function(response) {
            $scope.user = response.data;
          });
        });
      } else {
        notify('danger', 'Invalid characters. Only letters and numbers allowed.');
      }
    }
  }

  $scope.changePageDonationAttempts = function(page,perPage,total) {
    $scope.pageDonationAttempts = page;
    $scope.perPageDonationAttempts = perPage;
    $scope.totalDonationAttempts = total;
    $http.get('/api/donation-attempts?1=1&pageDonationAttempts=' + $scope.pageDonationAttempts + '&perPageDonationAttempts=' + $scope.perPageDonationAttempts).then(function(response) {
      $scope.donationAttempts = response.data.new.donationAttempts;
      $scope.totalDonationAttempts = response.data.new.count;
    });
  }

  $scope.formatDate = function(date) {
    // console.log('getMessageDate');
    var formattedDate = moment(date.date).format('D MMM YYYY, h:mm:ss A');
    return formattedDate;
  }
 
}]);