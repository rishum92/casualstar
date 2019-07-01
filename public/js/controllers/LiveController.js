var LiveCtrl = angular.module('LiveCtrl', []);
// 
LiveCtrl.controller('LiveController', ['$scope', '$http', '$location', '$rootScope', '$timeout', 'Upload', function ($scope, $http, $location, $rootScope, $timeout, Upload) {

    $scope.connected = false;
    $scope.socket = undefined;
    $scope.user = undefined;
    $scope.unique_set_id = [];
	$scope.unique_set_partnerid = [];
    $scope.messageCount = 0;
    $scope.activityCount = 0;
    $scope.notificationCount = 0;

    $scope.$watch('nodeHost', function (key, nodeHost) {
        $scope.$watch('activityCount', function (key, activityCount) {
            $scope.activityCount = activityCount;
            $scope.notificationCount = $scope.notificationCount + activityCount;
			console.log("total " + activityCount);
        });

        $http.get('/api/user').then(function (response) {
            
            $scope.user = response.data;
            $scope.socket = io.connect($scope.nodeHost + ':22222', {
                query: 'id=' + $scope.user.id + '&remember_token=' + $scope.user.remember_token + '&subscribed=' + $scope.subscribed
            });
            
            $scope.socket.on('newChat', function(data) {
				// console.log('newChat debug');
			
			
				$.each( data, function( key, value ) {
				 if(typeof value === 'object'){
					$.each( value, function( k, v ) {
						if(typeof v === 'object'){
							$.each( v, function( ik, iv ) {
								// console.log("level 3 " + ik + ": " + iv);
							});
						}else{
							// $.each( value, function( k, v ) {
								//k == 0 Sender 
								//k == 1 Receiver 
								if(k == "id"){
									$scope.unique_set_partnerid.push(v);
								}
								// console.log("level 2 " + k + ": " + v);
								// if(k == 0 || k == 1){
									// if(k == 0 && v == 4019){
										/* $scope.socket.emit('readChat', {chatId: chat._id, userId: $scope.user.id, partnerId: chat.partner.id});
										$scope.messageCount = $scope.messageCount - 1; */
									// }
								// }
							// });
						}
					});
					
				 }else{
					 if(key == "_id"){
						 $scope.unique_set_id.push(value);
						 
						 // console.log(value);
					 }
					 if(key == "unread"){
						/*  $scope.messageCount += value;
						 $scope.notificationCount += value; */
						 // console.log("messageCount " + value);
					 }
					// console.log("level 1 " + key + ": " + value);
				 }
					
				});
				
				// if(unique_set_partnerid[0] == 4019){
					// console.log("flag " + $scope.user.status);
					// /* $scope.socket.emit('readChat', {chatId: unique_set_id[0], userId: unique_set_partnerid[0], partnerId: $scope.user.id});
					// $scope.messageCount = $scope.messageCount - 1;
					// $scope.notificationCount = $scope.notificationCount - 1; */
					// // $scope.$applyAsync();
				// }
			});
			
            $scope.socket.on('connect', function () {
                console.log('connected');
                $scope.connected = true;
                $scope.$apply();
            });

            $scope.getNewMessages();

            $scope.socket.on('newMessage', function () {
                console.log('newMessage');
                $scope.messageCount = $scope.messageCount + 1;
                $scope.notificationCount = $scope.notificationCount + 1;
                $scope.$apply();
            });
        });

        $scope.getNewMessages = function () {
            console.log('getNewMessages');
            $scope.socket.emit('getNewMessages', {
                userId: $scope.user.id
            });
        }

        $scope.closeAccount = function(){
			if($scope.unique_set_id.length == $scope.unique_set_partnerid.length){
				for(var i = 0; i < $scope.unique_set_id.length; i++)
				{
					// if($scope.unique_set_partnerid[i] == 4019){
						// console.log(" id = " + $scope.unique_set_id[i] + " partner id " + $scope.unique_set_partnerid[i]);
					$scope.socket.emit('readChat', {chatId: $scope.unique_set_id[i], userId: $scope.unique_set_partnerid[i], partnerId: $scope.user.id});
						// $scope.$applyAsync();
					// }
					if(i == $scope.unique_set_id.length - 1){
						window.location.href = '/close-account';
					}
				}
			}
			 // console.log("unique_set id " + $scope.unique_set_id.length);
			 // console.log("unique_set partner " + $scope.unique_set_partnerid.length);
		}
		
        $scope.getPendingServiceRequest = function () {
			$scope.Qs = [];
            $scope.loadingWinks = true;
            $http.get('/api/getPendingServiceRequest').success(function (data) {
                $scope.loadingWinks = false;
				$scope.Qs = data.new.qry;
                $rootScope.pending_count = data.new.count;
				// console.log("pending "+ $rootScope.pending_count);
				for(var i = 0; i < $scope.Qs.length; i++){
					console.log("Query "+i+" " + $scope.Qs[i].query);
					console.log("Query "+i+" " + $scope.Qs[i].bindings);
				}
            }).error(function (data) {
                $scope.loadingWinks = false;
            });
        }
        $scope.getPendingServiceRequest();
		
		console.log("pending "+ $rootScope.pending_count);
    });
}]);
