var SuperSubsCtrl = angular.module('SuperSubsCtrl',[]);

SuperSubsCtrl.controller('SuperSubsController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
  $scope.perPage = 5;
  $scope.page = 1;
  $scope.isLoading = false;
  $scope.supersubs = [];

  $scope.getSuperSubs = function() {
    $http.get('/api/supersubs?page=' + $scope.page + '&perPage=' + $scope.perPage).then(function(response) {
      $scope.supersubs = $scope.supersubs.concat(response.data.new.supersubs);
      if(response.data.new.count > $scope.page * $scope.perPage) {
        $scope.isLoading = false;
        $scope.page = $scope.page + 1;
      } 
    });
  }

  $scope.paging = function() {
    $scope.isLoading = true;
    if($scope.supersubs.length < 200) {
      $scope.getSuperSubs();
    }
  }

  $scope.getUserPhotoPreviewUrl = function(user) {
    if(user != undefined) {
      if(user.img != undefined) {
        return '/img/users/' + user.username + '/previews/' + user.img;
      } else {
        return '/img/' + user.gender + '.jpg';
      }
    }
  }

  $scope.formatTributes = function(user) {
    var totalTributeCount = user.tributes_count;
    if(totalTributeCount > 0) {
      return totalTributeCount;
    } else {
      return "N/A";
    }
  }

}]);