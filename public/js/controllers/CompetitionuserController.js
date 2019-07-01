var CuserCtrl = angular.module('CuserCtrl',[]);

CuserCtrl.controller('UserCompetitionController',function($scope, $http, $location, $rootScope, $timeout, Upload) {
   
    $http.get('/api/user').then(function(response) {
    $scope.user = response.data;
    // console.log($scope.user);
  $scope.$watch('results.selected', function(newValue, oldValue) {
      if(newValue !== oldValue) {
        $http.post('/api/user-interest', {interests: newValue}).then(function(response) {
          notify(response.data.messageType, response.data.message);
        }); 
      }
    });

    $scope.userLoaded = true; 
  });
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
});