var UserCtrl = angular.module('ProfileCtrl',[]);

UserCtrl.controller('ProfileController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {

  $scope.userLoaded = false;
  $scope.locationSet = false;
  $scope.iwantaccess=1;
  $scope.getSamplePhotoUrl='/img/sample/verify.png'; 
  $scope.getUserPhotoUrl=null; 
  


  $http.get('/api/user').then(function(response) {
    $scope.user = response.data;
    // console.log($scope.user);
    
    $scope.getServiceList($scope.user.username);
    $scope.geoReady();

    $scope.date = $scope.user.dob;
    $scope.age = $scope.getAge($scope.user.dob);

    if($scope.user.interests) {
      if(!$scope.results) {
        $scope.results = [];
      }
      $scope.results.selected = $scope.user.interests;
    }

    $scope.$watch('results.selected', function(newValue, oldValue) {
      if(newValue !== oldValue) {
        $http.post('/api/user-interest', {interests: newValue}).then(function(response) {
          notify(response.data.messageType, response.data.message);
        }); 
      }
    });

    $scope.userLoaded = true; 
  });

  $scope.geoReady = function() {
    if($scope.user) {
      $('#vendorAddress').geocomplete( {
        location: $scope.user.location
      }).bind("geocode:result", function(event, result){
        if($scope.locationSet) {
          $scope.updateAddress(result);
        }
        $scope.locationSet = true;
      });
    }
  }
  
  // Stat edit
  $scope.editing = function($event) {
    $($event.currentTarget).parent().addClass('editing');
    setTimeout(function() {
      $('#vendorAddress').focus();
    }, 500);
  }
  
  $scope.noMoreEditing = function($event) {
    $($event.currentTarget).parent().removeClass('editing');
  }

  $scope.updateAddress = function(location) {
    $http.post('/api/update-location', {lat: location.geometry.location.lat(), lng: location.geometry.location.lng(), location: location.formatted_address}).then(function(response) {
      $scope.user = response.data.new;
	  console.log($scope.user);
      $('.stat.location.editing').removeClass('editing');
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.searchInterests = function(searchString) {
      var params = {searchString: searchString};
      if($scope.results) {
        var selected = $scope.results.selected;
        $scope.searchString = searchString;

        $http.get('/api/user-interest', {params: params}).then(function(response) {
          $scope.results = [];
          $(response.data).each(function(key,item) {
            $scope.results.push(item);
          });
          $scope.results = $.unique($scope.results);
          $scope.results.selected = selected;
        });
      }
  };

  // $scope.formatUserDescription = function(description) {
  //   var introText = description.replace(new RegExp(, "g"), '\n\n');
  //   introText = description.replace(new RegExp("<br>", "g"), '\n');
  //   return introText;
  // }


  $scope.openModal = function(modalName, optionKey, optionValue) {
    if(optionKey) {
      var modal = $scope.$eval(modalName);
      if(!modal['data']) {
        modal['data'] = [];
      }

      modal['data'][optionKey] = optionValue;
    }
	console.log("opens " + modalName);
    $('#' + modalName + 'Modal').modal('show');
  }

  $scope.hideModal = function(modalName) {
    $('#' + modalName + 'Modal').modal('hide');
  }

  $scope.submitModal = function(modalName) {
    var modal = $scope.$eval(modalName);
    var file = $('#' + modalName + 'Modal').find('input[type="file"]').prop('files')[0];
    switch(modalName) {
      case 'addProfilePhoto':
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        });
        $scope.upload = Upload.upload({
        method: 'POST',
          url: '/api/add-profile-photo',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          $('#userPhoto').attr('src', location.origin + '/img/users/' + $scope.user.username + '/' + response.data.new.img);
          $scope.user.img = response.data.new.img;
          $scope.notify.close();
 
          notify(response.data.messageType, response.data.message);
        });
      break;
	  case 'addSelfiePhoto':
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        });
        $scope.upload = Upload.upload({
        method: 'POST',
          url: '/api/add-selfie-photo',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          $('#userPhoto').attr('src', location.origin + '/img/Verified/users/' + $scope.user.username + '/' + response.data.new.img);
		  $scope.user = response.data.new;
          // $scope.user.verify_img = response.data.new.img;
          $scope.notify.close();
 
          notify(response.data.messageType, response.data.message);
        });
      break;
      case 'addCoverPhoto':
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        });
        $scope.upload = Upload.upload({
        method: 'POST',
          url: '/api/add-cover-photo',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          $scope.user = response.data.new;
          $scope.notify.close();
          notify(response.data.messageType, response.data.message);
        });
      break;

      case 'addPhoto':
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        }); 
        $scope.upload = Upload.upload({
        method: 'POST',
          url: '/api/photo',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          
          console.log($scope.user);

          // $scope.lightGallery.data('lightGallery').destroy(true);
          $scope.user = response.data.new;
          // $scope.initLightGallery();

          $scope.notify.close();
 
          notify(response.data.messageType, response.data.message);
        });
      break;
      case 'addPrivatePhoto':
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        }); 
        $scope.upload = Upload.upload({
        method: 'POST',
          url: '/api/privatePhoto',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          
          console.log($scope.user);
          
          $scope.sendNotification();
          // $scope.lightGallery.data('lightGallery').destroy(true);
          $scope.user = response.data.new;
          // $scope.initLightGallery();

          $scope.notify.close();
 
          notify(response.data.messageType, response.data.message);
        });
      break;

    }

    modal.data = [];
    modal.$setPristine();
    $scope.hideModal(modalName);
  }

$scope.sendNotification=function(){

$http.get('/api/sendNotification/').then(function (response) {
            
});

}
  $scope.update = function(value, key, id) {
    if(key == 'username' && value == '') {
      return;
    } else {
      $http.patch('/api/user/' + id,{key: key, value: value}).then(function(response) {
        notify(response.data.messageType, response.data.message);
      });
    }
  }

  $scope.destroyPhoto = function(item) {
    $http.delete('/api/photo/' + item.id).then(function(response) {
      var index = $scope.user.photos.indexOf(item);
      $scope.user.photos.splice(index, 1);
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.destroyPrivatePhoto = function(item) {
    $http.delete('/api/privatePhoto/' + item.id).then(function(response) {
      var index = $scope.user.privatephotos.indexOf(item);
      $scope.user.privatephotos.splice(index, 1);
      notify(response.data.messageType, response.data.message);
    });
  }



  $scope.getAge = function(birthday) {
    var ageDifMs = Date.now() - new Date(birthday);
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
  }

  $scope.initLightGallery = function() {
    console.log('initLightGallery');
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

    $scope.lightGallery = $('#userPhotos');
    if($scope.lightGallery.data('lightGallery') != undefined) {
      $scope.lightGallery.data('lightGallery').destroy(true);
    }
    $scope.lightGallery.lightGallery({
      mode: 'lg-fade',
      selector: 'a.lightGallery',
      thumbnail:true,
      animateThumb: true,
      showThumbByDefault: true,
      zoom: false,
      download: false
    });

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

  $scope.getPhotoUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + $scope.user.username + '/' + photo;
    } else {
      return '/img/' + $scope.user.gender + '.jpg';
    }
  }

  $scope.getPhotoPreviewUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + $scope.user.username + '/previews/' + photo;
    } else {
      return '/img/' + $scope.user.gender + '.jpg';
    }
  }
  $scope.getPrivatePhotoPreviewUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + $scope.user.username + '/privatephoto/' + photo;
    } else {
      return '/img/' + $scope.user.gender + '.jpg';
    }
  }

  $scope.getCoverPhotoUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + $scope.user.username + '/' + photo;
    } else {
      return '/img/cover.jpg';
    }
  }

  $scope.getVerifyPhotoUrl = function(photo) {
    if(photo != undefined) {
      return '/img/Verified/users/' + $scope.user.username + '/' + photo;
    } else {
      return '/img/' + $scope.user.gender + '.jpg';
    }
  }
  
  $scope.getServiceList = function (username) {
        $scope.u_name = username;
        $scope.serviceList = [];
        $http.get('/api/getAllUserServices/' + username).then(function (response) {
            $scope.serviceList = response.data.new.service;
            $scope.currency_code = response.data.new.currency_code;
            $scope.iwantaccess=response.data.new.iwantaccess;
$timeout(function() {
 $('.send-request').tooltip({title: "i : Button only works for visitors to your profile.", trigger: "click"});

 $('.addPrivatePhoto2').tooltip({title: "i : Please add Private Gallery Access service in your serviceList to enable this button.", trigger: "click"});
 
}, 1000);

              
        });
    }

  $scope.changeDate = function (modelName, newDob) {
    console.log('changeDate');
    $scope.update(newDob , 'dob', $scope.user.id);
    $scope.age = $scope.getAge(newDob);
    $('.stat.age.editing').removeClass('editing');
  }

  $scope.photoConfig = {
    animation: 150,
    onSort: function (evt){
      var newPos = evt.models;
      $http.patch('/api/photo-reorder', newPos).then(function (response) {
        notify(response.data.messageType, response.data.message);
      });
    }
  };
  
  $scope.enableTwit = function(user, flag, chk) {

		var msg = null;
		var chk_msg = null;
		
		if(flag == "TR"){
			msg = "New Tribute Received Auto-Tweet ";
		}
		if(flag == "PG"){
			msg = "New Subscription to Private Gallery Auto-Tweet ";
		}
		
		if(chk){
			chk_msg = "Enabled.";
		}else{
			chk_msg = "Disabled.";
		}
		
		$http.post('/api/enable-twit', {id: user.id, statics: chk, flgs : flag}).success(function (response) {
		  /* 
		  $scope.users = response.new.users;
		  console.log($scope.users); */
		  $scope.user = response.new.users;
		  notify('success',msg+chk_msg);
		  $.each($scope.user, function(currentUser) {
			  if(currentUser.id == user.id) {
					currentUser.twit_enable = chk;
					currentUser.twit_private_enable = chk;
			  }
		  });
		});
	}

	$scope.enableTwitLimit = function(user, flg) {
		var upd_limit = -1;
		if(flg == "TR")
		{
			upd_limit = $("select[name='twit_limit_save'] option:selected").val();
		}
		if(flg == "PG")
		{
			upd_limit = $("select[name='twit_pvt_limit_save'] option:selected").val();
		}
		
		var msg = null;
		var chk_msg = null;
		
		if(flg == "TR"){
			msg = "New Tribute Received Auto-Tweet Saved Successfully";
		}
		if(flg == "PG"){
			msg = "New Subscription to Private Gallery Auto-Tweet Saved Successfully";
		}
		
		$http.post('/api/save-twit-limit', {id: user.id, set_limit: upd_limit, flgs : flg}).success(function (response) {
		  $scope.user = response.new.users;
		  notify('success',msg);
		  $.each($scope.user, function(currentUser) {
			  if(currentUser.id == user.id) {
					currentUser.twit_limit = $("select[name='twit_limit_save'] option:selected").val();
					currentUser.twit_private_limit = $("select[name='twit_pvt_limit_save'] option:selected").val();
			  }
		  });
		});
	}
	
	$scope.getVerifySymbolUrl= function(){
	  return '/img/verifiedBadge2018.png'; 
	  }
}]);