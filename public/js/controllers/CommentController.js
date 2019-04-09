var CommentCtrl = angular.module('CommentCtrl',[]);

CommentCtrl.controller('CommentController',function($scope, $http, $location, $rootScope, $timeout, $window) {


  $scope.photos = [];
  $scope.comment = '';
  $scope.photoLikes = [];
  $scope.user = undefined;
  $scope.refreshInterval = undefined;

  $scope.deleteComment = function(photo, comment_id) {
    $http.delete('/api/photo-comment/' + comment_id).then(function(response) {
      notify(response.data.messageType, response.data.message);
      $scope.getComments(photo);
    });
  }

  
 

  $scope.deletePhoto = function(photo) {
    $http.get('/admin/api/delete-photo/' + photo.id).then(function(response) {
      notify(response.data.messageType, response.data.message);
      $scope.photos = [];
      $scope.page = 1;
      $scope.getPhotos();
    });
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

  $scope.postComment = function(user_id) {alert(user_id)
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



});