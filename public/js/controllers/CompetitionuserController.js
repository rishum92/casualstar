var CuserCtrl = angular.module('CuserCtrl',[]);

CuserCtrl.controller('UserCompetitionController',function($scope, $http, $location, $rootScope, $timeout, Upload) {
   
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

//comment start
 $scope.viewThisPhoto = function(user_id) { alert(user_id);

    $scope.openModal('viewPhoto', 'user_id', user_id);
  console.log($scope.$parent)
    $scope.user = $scope.$parent.user;
    $scope.user.user_id = user_id;

    $scope.getLikes(user_id);
    $scope.getComments(user_id);

    $scope.refreshInterval = setInterval(function() {
      if(!$scope.refreshPaused) {
        $scope.getComments(user_id);
        $scope.getLikes(user_id);
      } 
    }, 5000);
  }


  $scope.getLikes = function(user_id) { 
    console.log('refreshing likes');
    $http.get('/api/photo-like/' + user_id).then(function(response) {
      $scope.photoLikes = response.data;
    });
  }

  $scope.getComments = function(user_id) {
    console.log('refreshing comments');
    $http.get('/api/photo-comment/' + user_id).then(function(response) {
      $scope.photoComments = response.data;
    });
  }

 
  $scope.postComment = function(user_id) { alert(user_id)
    if($scope.comment.length > 0) { 
      $('#postCommentButton').attr('disabled', 'disabled');
      $http.post('/api/profile-comment', {user_id: user_id, comment: $scope.comment}).then(function(response) {
        notify(response.data.messageType, response.data.message);
        //$scope.getComments(user_id);
        $scope.comment = '';
        $('#postCommentButton').removeAttr('disabled');
      });
    }
  }
//comment end

  $scope.getCommentUserPhoto = function(comment) {
    if(comment.user.img != undefined) {
      return '/img/users/' + comment.user.username + '/chat/' + comment.user.img;
    } else {
      return '/img/' + comment.user.gender + '.jpg';
    }
  }

  $scope.getUserPhoto = function(user) {
    if(user != undefined) {
      if(user.img != undefined) {
        return '/img/users/' + user.username + '/chat/' + user.img;
      } else {
        return '/img/' + user.gender + '.jpg';
      }
    }
    
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
          url: 'competition-user',
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
          url: 'competition-user',
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
          method:'POST',
          url:'competition-user',
          data: modal.data,
          file: file
        }).progress(function (evt) {
          $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
          var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
          $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
          
          //console.log($scope.user);
          window.location.href = '/competitions';
          // $scope.lightGallery.data('lightGallery').destroy(true);
          //$scope.user = response.data.new;
          // $scope.initLightGallery();

          //$scope.notify.close();
 
          //notify(response.data.messageType, response.data.message);
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
       case "termsmodel":
         console.log('alert');
        $scope.upload = Upload.upload({
          method: 'POST',
          url: 'adminedit',
          data: modal.data,
          
        }).progress(function (evt) {
              }).then(function (response) {
          
          console.log($scope.user);

          // $scope.lightGallery.data('lightGallery').destroy(true);
          $scope.user = response.data.new;
          // $scope.initLightGallery();

          $scope.notify.close();
 
          notify(response.data.messageType, response.data.message);
        });
       break;
        case "visitorpopup":
        $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        }); 
        $scope.upload = Upload.upload({
        method: 'POST',
          url: 'adminedit',
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
       case 'imageModal':
       $scope.notify = uploadProgress('');
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        });
        $scope.upload = Upload.upload({
        method: 'POST',
          url: 'competition-user',
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
       }

    modal.data = [];
    modal.$setPristine();
    $scope.hideModal(modalName);
  }
  $scope.destroyPhoto = function(item) {
    $http.delete('/api/photo/' + item.id).then(function(response) {
      var index = $scope.user.photos.indexOf(item);
      $scope.user.photos.splice(index, 1);
      notify(response.data.messageType, response.data.message);
    });
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

 
      });



