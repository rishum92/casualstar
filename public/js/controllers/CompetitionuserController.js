var CuserCtrl = angular.module('CuserCtrl',[]);

CuserCtrl.controller('UserCompetitionController',function($scope, $http, $location, $rootScope, $timeout, Upload) {
   
    $http.get('competition_user').then(function(response) {
    $scope.competition_user = response.data;
    console.log($scope.competition_user);
    //sssalert($scope.competition_users);
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
        window.location.href = '/competitions';
        });
      break;
      case "termsmodel":
        $scope.upload = Upload.upload({
        method: 'POST',
        url: 'adminedit',
        data: modal.data,
        }).progress(function (evt) {
        }).then(function (response) {
        console.log($scope.user);
        $scope.user = response.data.new;
        $scope.notify.close();
        notify(response.data.messageType, response.data.message);
        });
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
        return '/img/' + user.gender + '.jpg';
      }
    }
  }
});



