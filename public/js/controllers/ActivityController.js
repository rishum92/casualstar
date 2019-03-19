  var UserCtrl = angular.module('ActivityCtrl',[]);

UserCtrl.controller('ActivityController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
  $http.get('/api/user').then(function(response) {
    $scope.perPage = 12;
    $scope.user = response.data;

    $scope.viewsPage = 1;
	  $scope.winksPage = 1;

    $scope.loadingWinks = true;
    $scope.loadingViews = true;

  	$http.get('/api/views?page=' + $scope.viewsPage + '&perPage=' + $scope.perPage).then(function(response) {
      $scope.views = response.data.new.views;
      $scope.viewsTotalPage = response.data.new.count;
      $scope.loadingViews = false;
    });

    $http.get('/api/winks?page=' + $scope.winksPage + '&perPage=' + $scope.perPage).then(function(response) {
      $scope.winks = response.data.new.winks;
      $scope.winksTotalPage = response.data.new.count;
      $scope.loadingWinks = false;
    });
  });  
$scope.getNotifications=function(){
  $http.get('/api/getNotifications').then(function(response) {
      $scope.notification = response.data.new;
      $scope.loadingWinks = false;
    });
}
  
$scope.getNotifications();
  $scope.displayDate=function(dat){
       return new Date(dat).getTime();
       }

$scope.toggleNotification = function () {
          $("#notificationList").slideToggle();
      }
      $scope.deleteNotification=function(id){
		   // var r = confirm("Do you really want to Delete ?");
            /* if (r == true) { */
				 $scope.loadingWinks = true;
				 $http.get('/api/deleteNotification/'+id).then(function(response) {
				 $scope.getNotifications();
				 $scope.loadingWinks = false;
				 notify(response.data.messageType, response.data.message);
				 });
			/* } */
      }

  $scope.formatViewDate = function(date) {
    var formattedDate = moment(date).format('D MMM YYYY, h:mm:ss A');
    return formattedDate;
  }


  $scope.getUserPhotoUrl = function(user) {
    if(user != undefined) {
      if(user.img != undefined) {
        return '/img/users/' + user.username + '/previews/' + user.img;
      } else {
        return '/img/' + user.gender + '.jpg';
      }
    }
  }

  $scope.changeViewsPage = function(page,perPage,total) {
    $scope.loadingViews = true;
  	$scope.perPage = perPage;
    $scope.viewsPage = page;
  	$scope.viewsTotalPage = total;

  	$http.get('/api/views?page=' + $scope.viewsPage + '&perPage=' + $scope.perPage).then(function(response) {
	  	$scope.views = response.data.new.views;
			$scope.viewsTotalPage = response.data.new.count;
      $scope.loadingViews = false;
		});
  }

  $scope.changeWinksPage = function(page,perPage,total) {
    $scope.loadingWinks = true;
    $scope.perPage = perPage;
    $scope.winksPage = page;
    $scope.winksTotalPage = total;

    $http.get('/api/winks?page=' + $scope.winksPage + '&perPage=' + $scope.perPage).then(function(response) {
      $scope.winks = response.data.new.winks;
      $scope.winksTotalPage = response.data.new.count;
      $scope.loadingWinks = false;
    });
  }
}]);