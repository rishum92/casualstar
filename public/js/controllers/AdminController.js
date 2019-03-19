var AdminCtrl = angular.module('AdminCtrl',[]);

AdminCtrl.controller('AdminController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {

  $scope.onlineUsers = 0;
  $scope.onlineBots = 0;
  $scope.searchUsers = '';

  $scope.genderMale = false;
  $scope.genderFemale = false;

  $scope.count = 0;

  $scope.perPageUsers = 20;
  $scope.pageUsers = 1;

  $scope.perPageSubscriptions = 20;
  $scope.pageSubscriptions = 0;

  var url = '/admin/api/users?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
  $http.get(url).then(function(response) {
    $scope.users = response.data.new.users;
    $scope.totalUsers = response.data.new.count;
  });
  
  var url_admin = '/admin/api/admin_users?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
  $http.get(url_admin).then(function(response) {
    $scope.admin_users = response.data.new.users;
    $scope.totalUsers = response.data.new.count;
    if($scope.savedPageUsers != undefined) {
      $scope.changeAdmin2Page($scope.savedPageUsers, $scope.perPageUsers, $scope.totalUsers);
    }
  });
    
  $http.get('/admin/api/total-users').then(function(response) {
    $scope.count = response.data;
  });

  $scope.changePageUsers = function(page,perPage,total) {
    $scope.pageUsers = page;
    $scope.perPageUsers = perPage;
    $scope.totalUsers = total;
    $scope.filterUsers('admin');
  }
  
  $scope.changeAdmin2Page = function(page,perPage,total) {
    $scope.pageUsers = page;
    $scope.perPageUsers = perPage;
    $scope.totalUsers = total;
    $scope.filterUsers('admin2');
	console.log($scope.totalUsers);
  }

  $http.get('/admin/api/subscriptions?page=' + $scope.pageSubscriptions + '&perPage=' + $scope.perPageSubscriptions).then(function(response) {
    $scope.subscriptions = response.data.new.subscriptions;
    $scope.totalSubscriptions = response.data.new.count;
  });
  
  $scope.changePageSubscriptions = function(page,perPage,total) {
    $scope.pageSubscriptions = page;
    $scope.perPageSubscriptions = perPage;
    $scope.totalSubscriptions = total;
    $http.get('/admin/api/subscriptions?page=' + $scope.pageSubscriptions + '&perPage=' + $scope.perPageSubscriptions).then(function(response) {
      $scope.subscriptions = response.data.new.subscriptions;
      $scope.totalSubscriptions = response.data.new.count;
    });
  }

  $http.get('/admin/api/interest').then(function(response) {
    $scope.interests = response.data;
  });

  $scope.formatDate = function(date) {
	if(date != null){
		var formattedDate = moment(date).format('D MMM YYYY, h:mm:ss A');
		return formattedDate;
	}else{
		return null;
	}
  }
  
  $scope.formatDateOnly = function(date) {
	if(date != null){
		var formattedDate = moment(date).format('D-MMM-YYYY');
		return formattedDate;
	}else{
		return null;
	}
  }

  $scope.filterUsers = function(flag) {
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

    var url = null;
		if(flag == 'admin2'){
			url = '/admin/api/admin_users?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
		}else{
			url = '/admin/api/users?1=1&pageUsers=' + $scope.pageUsers + '&perPageUsers=' + $scope.perPageUsers;
		}
    if(filters != '') {
      url += filters;
    }

    $http.get(url).then(function(response) {
	  if(flag == 'admin2'){
		$scope.admin_users = response.data.new.users;
	  }else{
		$scope.users = response.data.new.users;
	  }
      $scope.totalUsers = response.data.new.count;
	  console.log("after " + $scope.totalUsers);
    });
  }
  
  $scope.$parent.$watch('socket', function(socket) {
    if(socket != undefined) {
      $scope.socket = socket;
      $scope.socket.on('onlineUsers', function(data) {
        console.log('onlineUsers');
        $scope.onlineUsers = data;
        $scope.$apply();
      });

      $scope.socket.on('onlineBots', function(data) {
        console.log('onlineBots');
        $scope.onlineBots = data;
        $scope.$apply();
      });
    }
  });

  $scope.$watch('gender', function(gender){
    console.log(gender);
  });

  $scope.lockUser = function(user) { 
    $http.post('/admin/api/lock-user', {id: user.id}).success(function (response) {
      notify('success','User locked.');
      $.each($scope.users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.status = -1;
          }
      });
	  $.each($scope.admin_users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.status = -1;
          }
      });
    });
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

  $scope.submitModal = function(modalName) {
    var modal = $scope.$eval(modalName);
    switch(modalName) {
      case 'emailUser':
        console.log(modal.data);
        $http.post('/admin/api/email-user', {user_id: modal.data['user_id'], message: modal.data['message'], subject: modal.data['subject']}).then(function(response) {
          notify(response.data.messageType, response.data.message);
        });
      break;
      case 'addInterest':
        $http.post('/admin/api/interest', modal.data).then(function(response) {
          notify(response.data.messageType, response.data.message);
          $scope.interests.push(response.data.new);
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

  $scope.unlockUser = function(user) {
    $http.post('/admin/api/unlock-user', {id: user.id}).success(function (response) {
      notify('success','User unlocked.');
      $.each($scope.users, function(key, currentUser) {
      if(currentUser.id == user.id) {
          currentUser.status = 1;
      }
      });
	  $.each($$scope.admin_users, function(key, currentUser) {
      if(currentUser.id == user.id) {
          currentUser.status = 1;
      }
      });
    });
  }

  $scope.updateInterestField = function(value, key, interest_id) {
    $http.patch('/admin/api/interest/' + interest_id, {key: key, value: value}).then(function(response) {
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.deleteInterest = function(interest) {
    var index = $scope.interests.indexOf(interest);
    $http.delete('/admin/api/interest/' + interest.id).then(function(response) {
      $scope.interests.splice(index, 1);
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.deleteSubscription = function(subscription) {
    var index = $scope.subscriptions.indexOf(subscription);
    $http.get('/admin/api/delete-subscription/' + subscription.id).then(function(response) {
      $scope.subscriptions.splice(index, 1);
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.getPhotoUrl = function(photo, myuser) {
    if(photo != undefined) {
      return '/img/users/' + myuser.username + '/' + photo;
    } else {
      return '/img/' + myuser.gender + '.jpg';
    }
  }
  
  $scope.getPhotoPreviewUrl = function(photo, myuser) {
    if(photo != undefined) {
      return '/img/users/' + myuser.username + '/previews/' + photo;
    } else {
      return '/img/' + myuser.gender + '.jpg';
    }
  }
  
  $scope.getVerifyPhotoUrl = function(photo, myuser) {
    if(photo != undefined) {
      return '/img/Verified/users/' + myuser.username + '/' + photo;
    } else {
      return '/img/' + myuser.gender + '.jpg';
    }
  }
  
  $scope.getVerifyPhotoPreviewUrl = function(photo, myuser) {
    if(photo != undefined) {
      return '/img/Verified/users/' + myuser.username + '/' + photo;
    } else {
      return '/img/' + myuser.gender + '.jpg';
    }
  }
  
  $scope.getCoverPhotoUrl = function(photo, myuser) {
    if(photo != undefined) {
      return '/img/users/' + myuser.username + '/' + photo;
    } else {
      return '/img/cover.jpg';
    }
  }
  
  $scope.initLightGallery = function() {
    console.log('Admin initLightGallery');
    $scope.lightGalleryProfile = $('#userPhotoProfile');
    if($scope.lightGalleryProfile.data('lightGallery') != undefined) {
      $scope.lightGalleryProfile.data('lightGallery').destroy(true);
    }
	 $scope.lightGalleryProfile.lightGallery({
      mode: 'lg-fade',
      selector: 'a.lightGallery',
      thumbnail:true,
      animateThumb: true,
      showThumbByDefault: true,
      zoom: false,
      download: false
    });
  }

  $scope.approveUser = function(user) { 
    $http.post('/admin/api/approve-user', {id: user.id}).success(function (response) {
      notify('success','User Verified.');
      $.each($scope.users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_check = "VERIFIED";
          }
      });
	  $.each($scope.admin_users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_check = "VERIFIED";
          }
      });
    });
  }
  
  $scope.cancelUser = function(user) { 
    $http.post('/admin/api/cancel-user', {id: user.id}).success(function (response) {
      notify('success','User Verification has been denied.');
      $.each($scope.users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_check = "CANCELLED";
          }
      });
	  $.each($scope.admin_users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_check = "CANCELLED";
          }
      });
    });
  }

  $scope.deleteSelfie = function(user) {
    $http.post('/admin/api/delete-selfie-photo', {id: user.id}).success(function (response) {
      notify('success', 'Fansign Selfie Removed');
      $.each($scope.users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_img = null;
              currentUser.verify_check = 'None';
              currentUser.verify_created_at = null;
          }
      });
	  $.each($scope.admin_users, function(key, currentUser) {
          if(currentUser.id == user.id) {
              currentUser.verify_img = null;
              currentUser.verify_check = 'None';
              currentUser.verify_created_at = null;
          }
      });
    });
  }
  
  $scope.saveUpdates = function(user, txt_value) {
	  $http.post('/admin/api/save-notes', {id: user.id, note: txt_value}).success(function (response) {
	  });
  }
  
}]);