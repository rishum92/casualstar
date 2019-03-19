var TermsCtrl = angular.module('TermsCtrl', []);

TermsCtrl.controller('PostController', ['$scope', '$http', function ($scope, $http) {
    $scope.post = {
        name: '',
        description: ''
    };

    $scope.initAddPost = function () {
        var element = angular.element('#new_post');
        element.modal("show");
    };

    $scope.publishPost = function () {
        console.log('Hello');
        console.log($scope.post);
        $http.post('/admin/api/add-terms-condition', {title: $scope.post.name, description: $scope.post.description})
        .then(function(response) {
            if(response){
                notify(response.data.messageType, response.data.message);
            }
            var modal_element = angular.element('#new_post');
            modal_element.modal('hide');
            $scope.post=undefined;
            $scope.listPost();
        }, function error(e) {
            $scope.errors = e.data.errors;
        });

    };

    // list all post
    $scope.listPost = function () {
        $http.get('/admin/api/list-terms-condition', {})
            .then(function success(response) {
                $scope.posts = response.data;
            }, function error(e) {
                console.log('some error occured');
            }
        );
    };

    //edit all post
    $scope.edit = function (index) {
        $scope.update_post = $scope.posts[index];
        var modal_element = angular.element('#update_post');
        modal_element.modal('show');
    };

    $scope.updatePost = function () {
        $http.post('/admin/api/edit-terms-condition', {
            post: $scope.update_post
        })
        .then(function success(e) {
            $scope.errors = [];
            var modal_element = angular.element('#update_post');
            modal_element.modal('hide');
        }, function error(e) {
            $scope.errors = e.data.errors;
        });
    };

}]);

TermsCtrl.directive('ckEditor', function () {
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {
            var ck = CKEDITOR.replace(elm[0]);

            if (!ngModel) return;

            ck.on('pasteState', function () {
                scope.$apply(function () {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function (value) {
                ck.setData(ngModel.$viewValue);
            };
        }
    };
});