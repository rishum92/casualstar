var CompitionCtrl = angular.module('CompitionCtrl',[]);
CompitionCtrl.controller('CompitionController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
    
    $scope.count = 0;
    $scope.perPageUsers = 5;
    $scope.pageUsers = 1;
    
    var url = '/admin/api/getCompitions?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
    $http.get(url).then(function(response) {
      $scope.compitions = response.data.new.compitions;
      //console.log($scope.compitions);debugger
      $scope.totalCompitions = response.data.new.count;
    });
    $scope.changePageCompitions = function(page,perPage,total) {
      $scope.pageUsers = page;
      $scope.perPageUsers = perPage;
      $scope.totalCompitions = total;
      $scope.filterCompitions();
    }
    $scope.openModal = function(modalName, optionKey, optionValue) {
      var todayYears = new Date();
      $('#expiry').datetimepicker({ 
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        minDate : todayYears.toISOString().slice(0,10),
      });
      if(optionKey) {
        var modal = $scope.$eval(modalName);
        //console.log(modal);debugger
        if(!modal['data']) {
          modal['data'] = [];
        }
        modal['data']['subject'] = optionValue.title;
        modal['data']['description'] = optionValue.sub_title;
        modal['data']['expiry'] = optionValue.expiry_date;
        modal['data']['price'] = optionValue.price;
        modal['data']['id'] = optionValue.id;
        //console.log(modal);debugger
      }
      $('#' + modalName + 'Modal').modal('show');
    }

    $scope.submitModal = function(modalName) {
      var modal = $scope.$eval(modalName); 
      var expiry_d=document.getElementById('expiry').value;
      if(modal['data']['id']){
        case_name="compitionedit";
      }else{
        case_name="compition"
      }
      console.log(case_name);debugger
      switch(case_name) {
        case 'compition':
          $http.post('/admin/api/competition-save', {expiry_date: expiry_d,title: modal.data['subject'],sub_title: modal.data['description'],price:modal.data['price']}).then(function(response) {
              notify(response.data.messageType, response.data.message);
              $scope.compitions.push(response.data.new);
              $scope.filterCompitions();
              //console.log($scope.compitions);debugger
          });
        break;
        case 'compitionedit':
          $http.post('/admin/api/competition-edit', {compition_id:modal.data['id'],expiry_date: expiry_d,title: modal.data['subject'],sub_title: modal.data['description'],price:modal.data['price']}).then(function(response) {
          notify(response.data.messageType, response.data.message);
          $scope.filterCompitions();
          modalName="compition";
        });
        break;
      }
      modal.data = undefined;
      modal.$setPristine();
      $scope.hideModal(modalName);
    }

    $scope.hideModal = function(modalName) {
      $('#' + modalName + 'Modal').modal('hide');
    }
    $scope.deleteCompition= function(compition){
      $http.delete('/admin/api/deleteCompition/' + compition.id).then(function(response) {
        var index = $scope.compitions.indexOf(compition);
        $scope.compitions.splice(index, 1);
        notify(response.data.messageType, response.data.message);
      });
    }
    $scope.filterCompitions = function() {
      var url ='/admin/api/getCompitions?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
      $http.get(url).then(function(response) {
      $scope.compitions = response.data.new.compitions;
      $scope.totalCompitions = response.data.new.count;
      console.log("after " + $scope.totalCompitions);
      });
    }

    $scope.selectedCompition = function (compition){
      $scope.compition = compition;
    }
}]);