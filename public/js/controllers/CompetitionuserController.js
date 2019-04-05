var CuserCtrl = angular.module('CuserCtrl',[]);

CuserCtrl.controller('UserCompetitionController',function($scope, $http, $location, $rootScope, $timeout, Upload) {
  
  $http.get('competition_user').then(function(response) {
  $scope.competition_user = response.data;
  console.log($scope.competition_user);
  //sssalert($scope.competition_users);

  //Comment Section Start
  $scope.viewThisPhoto = function(photo) {
    $scope.openModal('viewPhoto', 'photo', photo);
    $scope.user = $scope.$parent.user;
   
   // $scope.getLikes(photo);
    //$scope.getComments(photo);

  //   $scope.refreshInterval = setInterval(function() {
  //     if(!$scope.refreshPaused) {
  //       $scope.getComments(photo);
  //       $scope.getLikes(photo);
  //     } 
  //   }, 5000);
  // }

  // $scope.getLikes = function(photo) {
  //   console.log('refreshing likes');
  //   $http.get('/api/photo-like/' + photo.id).then(function(response) {
  //     $scope.photoLikes = response.data;
  //   });
  // }

  // $scope.getComments = function(photo) {
  //   console.log('refreshing comments');
  //   $http.get('/api/photo-comment/' + photo.id).then(function(response) {
  //     $scope.photoComments = response.data;
  //   });
  }

  $scope.postComment = function(user_id) {alert(user_id)
    if($scope.comment.length > 0) {
      $('#postCommentButton').attr('disabled', 'disabled');
      $http.post('profile-comment', {user_id: user_id, comment: $scope.comment}).then(function(response) {
        notify(response.data.messageType, response.data.message);
        //$scope.getComments(photo);
        $scope.comment = '';
        $('#postCommentButton').removeAttr('disabled');
      });
    }
  }
  //Comment Section Close

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
      }

    modal.data = [];
    modal.$setPristine();
    $scope.hideModal(modalName);
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
  $scope.getUserPhotoPreviewUrl = function(user) {
    if(competition_user != undefined) {
      if(competition_user.img != undefined) {
        return '/img/competition_users/' + competition_user.username + '/previews/' + competition_user.user_profile;
      } else {
        return '/img/' + competition_user.gender + '.jpg';
      }
    }
  }
});
  $scope.getPhotoUrl = function(photo) {

    if(photo != undefined) {
      return '/img/competition_user/' + $scope.competition_user.username + '/previews/' + photo;
    } else {
      //return '/img/' +'female.jpg';
    }
  }

  $scope.getPhotoPreviewUrl = function(photo) {
    if(photo != undefined) {
      return '/img/competition_user/' + $scope.competition_user.username + '/previews/' + photo;
    } else {
      //return '/img/' + 'female.jpg';
    }
  }

  $scope.deleteconfirmation =function(id)
  {
    if(confirm("Are you sure want to delete this data ?"))
    {
      $http.get('competitiondelete/'+ id).then(function(data)
      {
        window.location.href = '/competitions';
      });
    }
    else
    {
      return false;
    }
  }
});