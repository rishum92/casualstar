var CompitionuserCtrl = angular.module('CompitionuserCtrl',[]);

CompitionuserCtrl.controller('CompitionuserController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
    
    $scope.genderMale = false;
    $scope.genderFemale = false;
    $scope.count = 0;
    $scope.perCompitionUsers = 20;
    $scope.pageCompitionUsers = 1;
    var CurrentUrl = $location.absUrl();
    var SplitUrl = CurrentUrl.split('/'); 
    //$scope.compitionusers =null
    //$scope.totalUsers=null;
    var ID=SplitUrl['5'];
    console.log(ID);
    var url = '/admin/api/getcompitionuser/'+ID+'?1=1&perCompitionUsers=' + $scope.perCompitionUsers + '&pageCompitionUsers=' + $scope.pageCompitionUsers;
    $http.get(url).then(function(response) {
        $scope.compitionusers = response.data.new.compitionUserList;
        $scope.totalUsers = response.data.new.count;
    });
    $scope.filterCompitionUsers=function(){
        var url = '/admin/api/getcompitionuser/'+ID+'?1=1&perCompitionUsers=' + $scope.perCompitionUsers + '&pageCompitionUsers=' + $scope.pageCompitionUsers;
        $http.get(url).then(function(response) {
        $scope.compitionusers = response.data.new.compitionUserList;
        $scope.totalUsers = response.data.new.count;
        });
    }

    $scope.changePageCompitions = function(page,perPage,total) {
        $scope.pageCompitionUsers = page;
        $scope.perCompitionUsers = perPage;
        $scope.totalUsers = total;
        $scope.filterCompitionUsers();
    }

    $scope.filterCompititionUsers = function(flag) {
        var filters = '';
        
        if($scope.genderFemale) {
          filters += '&genderFemale=' + true;
        }
    
        if($scope.genderMale) {
          filters += '&genderMale=' + true;
        }
    
        if($scope.searchUsers != '') {
          filters += '&searchUsers=' + $scope.searchUsers;
        }
    
        var url = '/admin/api/getcompitionuser/'+ID+'?1=1&perCompitionUsers=' + $scope.perCompitionUsers + '&pageCompitionUsers=' + $scope.pageCompitionUsers;
        if(filters != '') {
          url += filters;
        }
        $http.get(url).then(function(response) { 
          $scope.compitionusers = response.data.new.compitionUserList;
          $scope.totalUsers = response.data.new.count;
          console.log("after " + $scope.totalUsers);
        });
    }
}]);