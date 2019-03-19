var UserCtrl = angular.module('ExploreCtrl',[]);

UserCtrl.controller('ExploreController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', '$window', function($scope, $http, $location, $rootScope, $timeout, $window) {
  $scope.slickConfig = {
      adaptiveHeight: true,
      autoplay: true,
      autoplaySpeed: 5000,
      draggable: false,
      arrows: false,
      dots: false,
      infinite: false,
      slidesToShow: 1,
      slidesToScroll: 1
  }

  $window.addEventListener("resize", function() {
    $scope.refreshSlick();
  });

  $scope.photos = [];
  $scope.comment = '';
  $scope.photoLikes = [];
  $scope.user = undefined;
  $scope.refreshInterval = undefined;
  $scope.isLoading = false;

  $scope.perPage = 4;
  $scope.page = 1;

  $scope.refreshPaused = false;

  $scope.popoverObserver = undefined;

  $scope.bannerAd = undefined;

  $scope.getPhotos = function() {
    $http.get('/api/photo?page=' + $scope.page + '&perPage=' + $scope.perPage).then(function(response) {
      $scope.photos = $scope.photos.concat(response.data.new.photos);
      if(response.data.new.count > $scope.page * $scope.perPage) {
        $scope.isLoading = false;
        $scope.page = $scope.page + 1;
      } 
    });
  }

  $scope.deleteComment = function(photo, comment_id) {
    $http.delete('/api/photo-comment/' + comment_id).then(function(response) {
      notify(response.data.messageType, response.data.message);
      $scope.getComments(photo);
    });
  }

  $scope.getBannerAd = function() {
      $('#slick').slick('unslick');
      $http.get('/api/active-banner-ad').then(function (response) {
        if(response.data != '') {
          $scope.bannerAd = response.data;
          $('#slick').slick();
        }
      });
  }

  $scope.paging = function() {
    $scope.isLoading = true;
    $scope.getPhotos();
  }

  $scope.deletePhoto = function(photo) {
    $http.get('/admin/api/delete-photo/' + photo.id).then(function(response) {
      notify(response.data.messageType, response.data.message);
      $scope.photos = [];
      $scope.page = 1;
      $scope.getPhotos();
    });
  }

  $scope.pauseRefresh = function(event) {
    if(!$scope.refreshPaused) {
      $scope.refreshPaused = true;
      $scope.popoverObserver = new MutationObserver(function(mutations) {
        $scope.refreshPaused = false;
      });
      $scope.popoverObserver.observe($('.popover:visible').get(0), {
        attributes: true
      });
    } else {
      if($scope.popoverObserver) {
        $scope.popoverObserver.disconnect();
      }
      $scope.refreshPaused = false;
    }
  }

  $scope.getPhotoUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + photo.user.username + '/' + photo.img;
    }
  }

  $scope.getPhotoPreviewUrl = function(photo) {
    if(photo != undefined) {
      return '/img/users/' + photo.user.username + '/previews/' + photo.img;
    }
  }

  $scope.viewThisPhoto = function(photo) {
    $scope.openModal('viewPhoto', 'photo', photo);

    $scope.user = $scope.$parent.user;

    $scope.getLikes(photo);
    $scope.getComments(photo);

    $scope.refreshInterval = setInterval(function() {
      if(!$scope.refreshPaused) {
        $scope.getComments(photo);
        $scope.getLikes(photo);
      } 
    }, 5000);
  }


  $scope.getLikes = function(photo) {
    console.log('refreshing likes');
    $http.get('/api/photo-like/' + photo.id).then(function(response) {
      $scope.photoLikes = response.data;
    });
  }

  $scope.getComments = function(photo) {
    console.log('refreshing comments');
    $http.get('/api/photo-comment/' + photo.id).then(function(response) {
      $scope.photoComments = response.data;
    });
  }

  $scope.postComment = function(photo) {
    if($scope.comment.length > 0) {
      $('#postCommentButton').attr('disabled', 'disabled');
      $http.post('/api/photo-comment', {photo_id: photo.id, user_id: photo.user.id, comment: $scope.comment}).then(function(response) {
        notify(response.data.messageType, response.data.message);
        $scope.getComments(photo);
        $scope.comment = '';
        $('#postCommentButton').removeAttr('disabled');
      });
    }
  }

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

  $scope.refreshSlick = function() {
      $('#slick').slick('slickGoTo', 0);
  }

  $scope.likePhoto = function(photo) {
    $http.post('/api/photo-like', {photo_id: photo.id, user_id: photo.user.id}).then(function(response) {
      $scope.getLikes(photo);
    });
  }

  $scope.getLikeIcon = function() {
    var likedByUser = $scope.photoLikes.filter(like => like.user.id == $scope.user.id).length > 0;
    return likedByUser ? 'ion-ios-heart' : 'ion-ios-heart-outline';
  }

  $scope.formatLikes = function(likesNo) {
    if(likesNo > 9999) {
      return "10k+"
    }
    return likesNo;
  }

  $scope.openModal = function(modalName, optionKey, optionValue) {
    if(optionKey) {
      var modal = $scope.$eval(modalName);
      if(!modal['data']) {
        modal['data'] = [];
      }

      modal['data'][optionKey] = optionValue;
    }

    var modalToShown = $('#' + modalName + 'Modal');
    modalToShown.modal('show');
    modalToShown.on('hidden.bs.modal', function () { 
      clearInterval($scope.refreshInterval);
    });
  }

  $scope.hideModal = function(modalName) {
    $('#' + modalName + 'Modal').modal('hide');
  }

$scope.getUserPhotoPreviewUrl = function(user) {
    if(user != undefined) {
        if(user.img != undefined) {
            return '/img/users/' + user.username + '/previews/' + user.img;
        } else {
            return '/img/' + user.gender + '.jpg';
        }
    }
}

  $scope.getBannerAd();


}]);