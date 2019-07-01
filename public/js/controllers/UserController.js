var UserCtrl = angular.module('UserCtrl', []);

UserCtrl.controller('UserController', ['$scope', '$http', '$location', '$rootScope', '$timeout', 'Upload', '$interval', function ($scope, $http, $location, $rootScope, $timeout, Upload, $interval) {

    $scope.userLoaded = false;
	$scope.serverData = [];
	$scope.accessonly = null;
    $scope.$watch('username', function (key, username) {
		// console.log("Watch User " + username);
        // $scope.getServiceList(username);
        $scope.privateGalleryAccess(username);
        $scope.getServiceList(username);
        $http.get('/api/user/' + username).then(function (response) {
            $scope.user = response.data;
			var data_only = $scope.user;
			var string = '';
			var key;
			/* for(key in data_only) {
				string += '<ul>';
				if (data_only.hasOwnProperty(key)) {
					string += '<li>['+key+'] => ';
					string += data_only[key];
					string += '</li>';
			  }
				string += '</ul>';
			}
			console.log(string); */
/* 			for(key in $scope.serverData) {
				string += '<ul>';
				if (data_only.hasOwnProperty(key)) {
					string += '<li>['+key+'] => ';
					string += data_only[key];
					string += '</li>';
			  }
				string += '</ul>';
			}
			console.log(string); */
            $scope.userLoaded = true;
        });
    });
	
	// APInfo Starts
	$scope.serviceList = [];
	// $scope.refresh = function() {
	function refresh(){
		setTimeout(function(){
				if ($scope.serverData !== $scope.serviceList){
				   $scope.serverData = $scope.serviceList;
				}else{
					$http.get('/api/getAllUserServices/' + $scope.u_name).then(function (response) {
						$scope.serviceList = response.data.new.service;
						$scope.currency_code = response.data.new.currency_code;
					});
					// console.log("ok");
				}
				
				if($scope.accessonly !== $scope.accessGranted){
					$scope.accessonly = $scope.accessGranted;
				// $scope.privateGalleryAccess(username);
				}else{
					$http.get('/api/privateGalleryAccess/' + $scope.u_name).then(function (response) {
						$scope.accessGranted = response.data.new.accessGranted;
						$scope.buttonEnable=response.data.new.buttonEnable;
						$scope.iwantaccess=response.data.new.iwantaccess;
						$scope.accessPending=response.data.new.accessPending;
						$scope.timespan=response.data.new.timespan;
						$timeout(function() {
							// console.log("timespan " + $scope.timespan + " granted " + $scope.accessGranted + " buttonEnable " + $scope.buttonEnable+ " iwantaccess " + $scope.iwantaccess + " accessPending " + $scope.accessPending);
							// $scope.initLightGallery();
						}, 1000);
					});
				}
		}, 100);
	};

	
	   // store the interval promise in this variable
		var promise;
		
		// starts the interval
		$scope.start = function() {
		  // stops any running interval to avoid two intervals running at the same time
		  $scope.stop(); 
		  
		  // store the interval promise
		  // promise = $interval(setRandomizedCollection, 1000);
		  promise = $interval(refresh,  1000);  
		};
		
		// stops the interval
		$scope.stop = function() {
		  $interval.cancel(promise);
		};
		
		 // starting the interval by default
		$scope.start();
 
		// stops the interval when the scope is destroyed,
		// this usually happens when a route is changed and 
		// the ItemsController $scope gets destroyed. The
		// destruction of the ItemsController scope does not
		// guarantee the stopping of any intervals, you must
		// be responsible for stopping it when the scope is
		// is destroyed.
		$scope.$on('$destroy', function() {
		  $scope.stop();
		});
	
	  /* $scope.intervalPromise = $interval(function(){
		$scope.refresh();
	  }, 1000);   */

	  // initial load of data
	  // $scope.refresh();
	// APInfo Ends
	
	/* 
	$scope.time = 0;
	var timer = function() {
		// if( $scope.time < 5000 ) {
		console.log("timer "+ $scope.u_name);
		// $scope.$watch('username', function(key, username){
			// $scope.getServiceList($scope.u_name);
		// });
		$scope.time += 1000;
		$timeout(timer, 1000);
	}
	
		$timeout(timer, 1000); */
	
   $scope.privateGalleryAccess=function(username){
     $scope.loadingWinks = true;
     $http.get('/api/privateGalleryAccess/' + username).then(function (response) {
            $scope.accessGranted = response.data.new.accessGranted;
            $scope.buttonEnable=response.data.new.buttonEnable;
            $scope.iwantaccess=response.data.new.iwantaccess;
             $scope.accessPending=response.data.new.accessPending;
             $scope.timespan=response.data.new.timespan;
              $scope.loadingWinks = false;
            $timeout(function() {
				// console.log("timespan " + $scope.timespan + " granted " + $scope.accessGranted + " buttonEnable " + $scope.buttonEnable+ " iwantaccess " + $scope.iwantaccess + " accessPending " + $scope.accessPending);
        $scope.initLightGallery();
    }, 1000);
    });
   }
    
	$scope.grantedAccess=function(id){
		$scope.loadingWinks = true;
						  $http.get('/api/changeServiceRequestStatus/' + id + '/' + 1).success(function (data) {
							  $scope.loadingWinks = false;
							  $scope.page = 1;
							  notify("success", "Access granted successfully.");
							  $("#grant-access").hide();
						  }).error(function (data) {
							  $scope.loadingWinks = false;
						  });
	}

    $scope.toggleFavorite = function (username) {
        $http.post('/api/toggle-favorite/' + username).then(function (response) {
            notify(response.data.messageType, response.data.message);
            $http.get('/api/user/' + $scope.username).then(function (response) {
                $scope.user = response.data;
            });
        });
    }

    $scope.donate = function () {
        $http.get('/api/donate/' + $scope.username + '?donate=&method=').then(function (response) {});
    }
    $scope.getServiceList = function (username) {
        $scope.u_name = username;
        $scope.serviceList = [];
        $scope.Qs = [];
        $http.get('/api/getAllUserServices/' + username).then(function (response) {
            $scope.serviceList = response.data.new.service;
            // $scope.Qs = response.data.new.qry;
            $scope.currency_code = response.data.new.currency_code;
			// console.log("query " + Object.value($scope.q));
			/* for(var i = 0; i < $scope.serviceList.length; i++){
			    // if($scope.serviceList[i].id == serv.id){
					console.log("ids" + $scope.serviceList[i].id);
				// }
			} */
/* 			for(var i = 0; i < $scope.Qs.length; i++){
			    // if($scope.serviceList[i].id == serv.id){
					console.log("Query "+i+" " + $scope.Qs[i].query);
					console.log("Query "+i+" " + $scope.Qs[i].bindings);
				// }
			} */
        });

        
    }
	
    //http://localhost/api/privateGalleryAccess/Krayn
    $scope.sendRequest = function (service_id) {
		$scope.stop();
		 // $interval.cancel($scope.intervalPromise);
        var dataObj = {
            "service_id": service_id,
            "username": $scope.u_name
        }
        $scope.loadingWinks = true;
        $http.post('/api/sendServiceRequest', dataObj).success(function (data) {
            // console.log(data);
            $scope.getServiceList($scope.u_name);
            $scope.privateGalleryAccess($scope.u_name);
            notify(data.messageType, data.message);
        }).error(function (data) {
            // console.log(data);
            notify("success", "Your request has been sent successfully");
        }).finally(function(data){
            $scope.loadingWinks = false;
			$scope.start();
		});
    }

    $scope.getFavorite = function (user) {
        if (user !== undefined) {
            if (user.favorite == true) {
                return 'active';
            } else {
                return '';
            }
        }
    }

    $scope.getAge = function (birthday) {
        var ageDifMs = Date.now() - new Date(birthday);
        var ageDate = new Date(ageDifMs);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

    $scope.getUserPhotoUrl = function (photo) {
        if ($scope.user != undefined) {
            if ($scope.user.img != null) {
                return '/img/users/' + $scope.user.username + '/' + photo;
            } else {
                return '/img/' + $scope.user.gender + '.jpg';
            }
        }
    }
$scope.getPrivatePhotoPreviewUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + $scope.user.username + '/privatephoto/' + photo;
    } else {
      return '/img/' + $scope.user.gender + '.jpg';
    }
  }
    $scope.getPhotoUrl = function (photo) {
        if ($scope.user != undefined) {
            if (photo != null) {
                return '/img/users/' + $scope.user.username + '/' + photo;
            }
        }
    }

    $scope.getPhotoPreviewUrl = function (photo) {
        if (photo != undefined) {
            return '/img/users/' + $scope.user.username + '/previews/' + photo;
        } else {
            return '/img/' + $scope.user.gender + '.jpg';
        }
    }

    $scope.wink = function (username) {
        $http.post('/api/wink/' + username).then(function (response) {
            notify(response.data.messageType, response.data.message);
            $http.get('/api/user/' + $scope.username).then(function (response) {
                $scope.user = response.data;
            });
        });
    }

    $scope.initLightGallery = function () {
        // console.log('initLightGallery');

        $scope.lightGalleryProfile = $('#userPhotoProfile');
        if ($scope.lightGalleryProfile.data('lightGallery') != undefined) {
            $scope.lightGalleryProfile.data('lightGallery').destroy(true);
        }
        $scope.lightGalleryProfile.lightGallery({
            mode: 'lg-fade',
            selector: 'a.lightGallery',
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: true,
            zoom: false,
            download: false
        });

        $scope.lightGallery = $('#userPhotos');
        if ($scope.lightGallery.data('lightGallery') != undefined) {
            $scope.lightGallery.data('lightGallery').destroy(true);
        }
        $scope.lightGallery.lightGallery({
            mode: 'lg-fade',
            selector: 'a.lightGallery',
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: true,
            zoom: false,
            download: false
        });
      if($scope.accessGranted){
$scope.lightPrivateGallery = $('#userPrivatePhotos');
    if($scope.lightPrivateGallery.data('lightGallery') != undefined) {
      $scope.lightPrivateGallery.data('lightGallery').destroy(true);
    }
    $scope.lightPrivateGallery.lightGallery({
      mode: 'lg-fade',
      selector: 'a.lightGallery',
      thumbnail:true,
      animateThumb: true,
      showThumbByDefault: true,
      zoom: false,
      download: false
    });
      }
        
    }
    
	$scope.getVerifySymbolUrl= function(){
	  return '/img/verifiedBadge2018.png'; 
    }
}]);
