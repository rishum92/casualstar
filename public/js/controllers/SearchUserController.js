var SearchUserCtrl = angular.module('SearchUserCtrl',[]);

SearchUserCtrl.controller('SearchUserController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
  
 $scope.perPageBrowse = 12;
  $scope.pageBrowse = 1;

  $scope.perPageFavorites = 3;
  $scope.pageFavorites = 1;

  $scope.genderMale = false;
  $scope.genderFemale = false; 

  $scope.results = [];

  $scope.userText = '';

  $scope.minAge = 18;
  $scope.maxAge = 100;

  $scope.withImagesOnly = false;
  $scope.withAllGender = true;

  $scope.onlineNow = false; 

  $scope.applyingFilters = false;

  $scope.distance = 500;

  $scope.sortBy = 'created_at';

  $scope.getCheckedTrue = function(){
    return $scope.withAllGender;
  };
  
  $scope.getToggle = function(){
    return !$scope.withAllGender;
  };

  
  $scope.$watch('filtersSet', function(filtersSet) {
    console.log(filtersSet);
    $.each(filtersSet, function(index, value) {
      switch(index) {
        case 'page':
          $scope.pageBrowseRemember = parseInt(value);
          break;
        case 'totalBrowse':
          if(value != 'undefined') {
            $scope.totalBrowseRemember = parseInt(value);
          }
          break;
        case 'withImagesOnly':
          if(value == 'true') {
            $scope.withImagesOnly = true;
          } else {
            $scope.withImagesOnly = false;
          }
          break;
        case 'onlineNow':
          if(value == 'true') {
            $scope.onlineNow = true;
          } else {
            $scope.onlineNow = false;
          }
          break;
        case 'minAge':
          $scope.minAge = parseInt(value);
          break;
        case 'maxAge':
          $scope.maxAge = parseInt(value);
          break;
        case 'distance':
          $scope.distance = parseInt(value);
          break;
        case 'lookingForInterests':
          $scope.results.selected = value;
          break;
        case 'sortBy':
          $scope.sortBy = value;
          break;
        case 'userText':
      $scope.userText = value;
          break;
      case 'withAllGender':
          $scope.withAllGender = Boolean(value);  
          break;
      }
    }); 
   $scope.filterUsers();
  });

  $scope.$watch('results.selected', function(newValue, oldValue) {
    if(newValue !== oldValue) {
      $scope.filterUsers();
       
      console.log("replaced " +$scope.withAllGender);
    }
  }); 

  $scope.filterUsers = function(override, rememberPage) {
    //console.log("apply "+ $scope.applyingFilters);
    //if(!$scope.applyingFilters) {
      $scope.applyingFilters = true;
      var filters = "12345";
   
      filters += '&withImagesOnly=' + $scope.withImagesOnly;
      filters += '&withAllGender=' + $scope.withAllGender;
      filters += '&onlineNow=' + $scope.onlineNow;

    if(!$scope.withAllGender){
    if($scope.distance) {
      filters += '&distance=' + $scope.distance;
    }
    }

    if($scope.genderFemale) {
    filters += '&genderFemale=' + true;
    }

    if($scope.genderMale) {
    filters += '&genderMale=' + true;
    }
    
      if($scope.minAge) {
        filters += '&minAge=' + $scope.minAge;
      }

      if($scope.maxAge) {
        filters += '&maxAge=' + $scope.maxAge;
      }

    if($scope.userText != null && $scope.userText != '') {
        filters += '&userText=' + $scope.userText;
      }
    
      if($scope.results.selected) {
        if($scope.results.selected.length > 0) {
          filters += '&lookingFor=';

          $($scope.results.selected).each(function(key, item) {
            filters += item.id + ',';
          });

          filters = filters.substr(0, filters.length-1);
        }
      }

      if(!override) {
        $scope.pageBrowse = 1;
      }

      var url = '/api/browse?page=' + $scope.pageBrowse + '&perPage=' + $scope.perPageBrowse + '&sortBy=' + $scope.sortBy + '&totalBrowse=' + $scope.totalBrowse;
      if(filters != '') {
        url += filters;

      }
      $http.get(url).then(function(response) {
        $scope.users = response.data.new.users;
        $scope.totalBrowse = response.data.new.count;
        $scope.applyingFilters = false;
        

        if($scope.pageBrowseRemember != undefined && !override && $scope.pageBrowseRemember != $scope.pageBrowse) {
          $scope.changePageBrowse($scope.pageBrowseRemember , $scope.perPageBrowse, $scope.totalBrowse);
        }
      });
  }

  // $scope.filterUsers();

  $scope.searchInterests = function(searchString) {
    var params = {searchString: searchString};
    var selected = $scope.results.selected;
    $scope.searchString = searchString;
    $scope.results = [];

    $http.get('/api/interest', {params: params}).then(function(response) {
      $(response.data).each(function(key,item) {
        $scope.results.push(item);
      });
    });

    $scope.results = $.unique($scope.results);
    $scope.results.selected = selected;
  };

  $scope.getLocation = function(location) {
    if(location.length > 30) {
      return location.substr(0, 30) + ".."
    } else {
      return location
    }
  }

 
  $http.get('/api/favorites?page=' + $scope.pageFavorites + '&perPage=' + $scope.perPageFavorites).then(function(response) {
    $scope.favorites = response.data.new.favorites;
    $scope.totalFavorites = response.data.new.count;
  });

  $scope.getUserPhotoPreviewUrl = function(user) {
    if(user != undefined) {
      if(user.img != undefined) {
        return '/img/users/' + user.username + '/previews/' + user.img;
      } else {
        return '/img/' + user.gender + '.jpg';
      }
    }
  }

  $scope.getAge = function(birthday) {
    var ageDifMs = Date.now() - new Date(birthday);
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
  }

  $scope.destroyFavorite = function(user) {
    $http.delete('/api/favorite/' + user.username).then(function(response) {
      // var index = $scope.favorites.indexOf(user);
      // $scope.favorites.splice(index, 1);
      notify(response.data.messageType, response.data.message);
      $http.get('/api/favorites?page=' + $scope.pageFavorites + '&perPage=' + $scope.perPageFavorites).then(function(response) {
        $scope.favorites = response.data.new.favorites;
        $scope.totalFavorites = response.data.new.count;
      });
    });
  }

  $scope.changePageBrowse = function(page,perPage,total) {
    $scope.pageBrowse = page;
    $scope.perPageBrowse = perPage;
    $scope.totalBrowse = total;
    
    $scope.filterUsers(true);
  }

  $scope.changePageFavorites = function(page,perPage,total) {
    $scope.pageFavorites = page;
      $scope.perPageFavorites = perPage;
      $scope.totalFavorites = total;
      
      $http.get('/api/favorites?page=' + $scope.pageFavorites + '&perPage=' + $scope.perPageFavorites).then(function(response) {
        $scope.favorites = response.data.new.favorites;
        $scope.totalFavorites = response.data.new.count;
      });
  }
  
  $scope.getVerifySymbolUrl= function(){
    return '/img/verifiedBadge2018.png'; 
  }
}]);