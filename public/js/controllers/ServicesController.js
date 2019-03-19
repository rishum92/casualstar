  var ServiceCtrl = angular.module('ServiceCtrl', []);

  ServiceCtrl.controller('ServiceController', ['$scope', '$http', '$location', '$rootScope', '$timeout', 'Upload', '$route', '$interval', function ($scope, $http, $location, $rootScope, $timeout, Upload, $route, $interval) {
      $scope.currency_code = "";
      $scope.page = 1;
	  $scope.serverData = [];
	  
      if (currency_code) {
          $scope.currency_code = currency_code;
      }
      $scope.service_variable = "";
      $scope.toggleRequestServiceList = function () {
          $("#RequestServiceList").slideToggle();
      }
      $scope.toggleServiceList = function () {
          $("#ServiceList").slideToggle();
      }
	  
      $scope.getCurrencyList = function () {
          $scope.loadingWinks = true;
          $http.get('/api/getAllCurrency').success(function (data) {
              $scope.currencyList = data.new;
              $scope.loadingWinks = false;
          }).error(function (data) {
              $scope.loadingWinks = false;
          });
      }
      $scope.getServiceList = function () {
			// $scope.Qs = [];
          $scope.loadingWinks = true;
          $http.get('/api/getAllService').success(function (data) {
			  // console.log(data);
			  // $scope.Qs = data.new.qry;
              $scope.serviceList = data.new;
              $scope.loadingWinks = false;
			 /*  for(var i = 0; i < $scope.Qs.length; i++){
				console.log("Query "+i+" " + $scope.Qs[i].query);
				console.log("Query "+i+" " + $scope.Qs[i].bindings);
			} */
          }).error(function (data) {
              $scope.loadingWinks = false;
          });
      }

	  $scope.selectedProduct = {};
	  $scope.selectProduct = function() {
	    $scope.terms = {	label : "Save", heading	: "Add New Services" };
	    // $scope.selectedProduct = $scope.serviceList;
		// console.log("selectedProduct "+ );
		// console.log(Object.values($scope.selectProduct));
		$scope.orderAmount = 0;
		$scope.add_service_name = "";
		$scope.add_fee_amount = "";
		$scope.add_variable = "";
	  
		$('#product-detail').modal("show");
	  }
	  
	  $scope.selectProduct_id = function(user) {
		  // console.log(user.id);
	    // $scope.selectedProduct = $scope.serviceList;
		// console.log(user.variable_list[0].variable_name);
		// console.log(Object.values($scope.selectProduct));
		$scope.terms = {	label : "Update", heading	: "Update New Services"	};
		// $scope.this_service = user;
		$scope.orderAmount = user.id;
		$scope.add_service_name = user.service_name;
		$scope.add_fee_amount = user.amount;
		$scope.add_variable = user.variable_list[0].variable_name;
	  
		$('#product-detail').modal("show");
	  }
	  
		$scope.selectProduct_id_del = function(serv) {
		    bootbox.confirm({
				size: 'small',
				message: "Are you sure you want to remove this Service? <br> Click OK to Delete.",
				title: "Delete New Service",
				callback: function (result) {
					if (result) {
						$scope.loadingWinks = true;
						var dataObj = { "service_id": serv.id }
						  $http.post('/api/delNewService' , dataObj).success(function (data) {
							  $scope.loadingWinks = false;
							  $scope.getServiceList();
							  notify(data.messageType, data.message);
						  }).error(function (data) {
							  $scope.loadingWinks = false;
							  $scope.getServiceList();
							  notify(data.messageType, data.message);
						  });
					}
				}
			});
		}
		
	  $scope.orderAmount = "";
	  $scope.add_service_name = null;
	  $scope.add_fee_amount = null;
	  $scope.add_variable = null;
	  $scope.orderAlert = "";

	  $scope.orderItem = function() {
		  
		$( '#add_service_name-error' ).html( "" );
		$( '#add_fee_amount-error' ).html( "" );
		$( '#add_variable-error' ).html( "" );
		
		if ($scope.add_service_name == null || $scope.add_service_name == "") {
		  $( '#add_service_name-error' ).html( "Please Enter Valid Service Name." );
		  return false;
		}
		if ($scope.add_variable == null || $scope.add_variable == "") {
		  $( '#add_variable-error' ).html( "Variable Name Cannot Be Empty." );
		  return false;
		}
		 
		var dataObj = {
			"service_name": $scope.add_service_name,
			"amount": $scope.add_fee_amount,
			"variable_name": $scope.add_variable,
		}
		  // console.log(" Add Data " + dataObj);
		// console.log(Object.values(dataObj));
		 
		  $scope.loadingWinks = true;
		  $http.post('/api/saveNewService', dataObj).success(function (data) {
			  if(data.new.errors) {
				  // console.log(data.errors);
                    if(data.new.errors.service_name){
                        $( '#add_service_name-error' ).html( data.new.errors.service_name[0] );
                    }
					/* if(data.new.errors.amount){
                        $( '#add_fee_amount-error' ).html( data.new.errors.amount[0] );
                    } */
					if(data.new.errors.variable_name){
                        $( '#add_variable-error' ).html( data.new.errors.variable_name[0] );
                    }
			  }else if(data.new.success) {
				  $('#product-detail').modal("hide");
				  $scope.getServiceList();
				  notify(data.messageType, "Service Added Successfully.");
			  }
			  $scope.loadingWinks = false;
			  /* if(data.errors) {
                    if(data.errors.name){
                        $( '#add_service_name-error' ).html( data.errors.service_name[0] );
                    }
			  } */
			  /* if(data.success) {
				  // $scope.getServiceList();
				  $scope.loadingWinks = false;
				  // $('#product-detail').modal("hide");
				  notify(data.messageType, "Service Added Successfully.");
				  $scope.getServiceList();
			  } */
		  });
		
/* 		$scope.orderAlert = $scope.orderAmount + " units of ";
			$('#product-detail').modal("hide");
			$('#order-alert-box').slideDown("slow");
			setTimeout(function(){
				// alert("hello");
				$("#order-alert-box").slideUp("slow");
				notify("success", "Service Added successfully.");
			},4000) */
		}


	  $scope.orderItem_update = function() {
		  console.log(" ids " +$scope.orderAmount)
		$( '#add_service_name-error' ).html( "" );
		$( '#add_fee_amount-error' ).html( "" );
		$( '#add_variable-error' ).html( "" );
		
		if ($scope.add_service_name == null || $scope.add_service_name == "") {
		  $( '#add_service_name-error' ).html( "Please Enter Valid Service Name." );
		  return false;
		}
		if ($scope.add_variable == null || $scope.add_variable == "") {
		  $( '#add_variable-error' ).html( "Variable Name Cannot Be Empty." );
		  return false;
		}
		 
		var dataObj = {
			"service_id": $scope.orderAmount,
			"service_name": $scope.add_service_name,
			"amount": $scope.add_fee_amount,
			"variable_name": $scope.add_variable,
		}
		  // console.log(" Add Data " + dataObj);
		// console.log(Object.values(dataObj));
		 
		  $scope.loadingWinks = true;
		  $http.post('/api/updateNewService', dataObj).success(function (data) {
			  if(data.new.errors) {
				  // console.log(data.errors);
                    if(data.new.errors.service_name){
                        $( '#add_service_name-error' ).html( data.new.errors.service_name[0] );
                    }
					/* if(data.new.errors.amount){
                        $( '#add_fee_amount-error' ).html( data.new.errors.amount[0] );
                    } */
					if(data.new.errors.variable_name){
                        $( '#add_variable-error' ).html( data.new.errors.variable_name[0] );
                    }
			  }else if(data.new.success) {
				  // console.log("data id " + data.new.datas.service_name);
				  $('#product-detail').modal("hide");
				  $scope.getServiceList();
				  notify(data.messageType, "Service Updated Successfully.");
			  }else{
				  notify("danger", "Something Wrong.");
			  }
			  $scope.loadingWinks = false;
		  });
	  }
		
      $scope.updateUserCurrency = function () {

          $scope.loadingWinks = true;
          currency_co=0;
          if($scope.currency_code){
             currency_co=$scope.currency_code;
          }
          $http.get('/api/updateUserCurrency/' + currency_co).success(function (data) {
              console.log(data);
              $scope.loadingWinks = false;
              notify(data.messageType, data.message);
          }).error(function (data) {
              $scope.loadingWinks = false;
          });

      }

      $scope.getCurrencyList();
      $scope.getServiceList();

	$scope.requestedServiceList = [];
	
	$scope.refresh = function() {
		setTimeout(function(){
				if ($scope.serverData !== $scope.requestedServiceList){
				   $scope.serverData = $scope.requestedServiceList;
				}else{
					$http.get('/api/getAllServiceRequest/' + $scope.page).success(function (data) {
					  $scope.count = Math.ceil(data.new.count);              
					  $scope.requestedServiceList = data.new.data;
					  $scope.totalBrowse = Math.ceil(data.new.total_count);
					  if ($scope.page < 2) {
						  $scope.prev = false;
					  } else {
						  $scope.prev = true;
					  }
					  $scope.next = data.new.is_nxt;

				  }).error(function (data) {});
					// console.log("ok");
				}
				
				if($scope.accessonly !== $scope.accessGranted){
					$scope.accessonly = $scope.accessGranted;
				}else{
					
				}
		}, 100);
	};

	$scope.intervalPromise = $interval(function(){
		$scope.refresh();
	}, 1000);  
	  
	  
	  /* $scope.reloadPage = function () { window.location.reload();	} // APInfo Reload Page
	  //10 seconds delay
	  $timeout( function(){
	    // $scope.test1 = "Hello World!";
	  }, 5000 );

	  //time
	  $scope.time = 0;
        
          //timer callback
	  var timer = function() {
		  if( $scope.time < 5000 ) {
                $scope.time += 1000;
                $timeout(timer, 1000);
                
		  }
		  if( $scope.time % 5000 == 0) {
                $scope.time = 0;
                $route.reload();
				$scope.getRequestedServiceList();
				$scope.getPendingServiceRequest();
				console.log("route refresh");
                //$timeout(timer, 1000);
		  }
	  }
	  
	   //run!!
	  $timeout(timer, 1000);    */

	  /* $scope.checkForServices = function(serv){
	      $scope.getRequestedServiceList();
		  console.log("next", $scope.next);
		  $scope.getPendingServiceRequest();
		  console.log("counter", $scope.count);
			  for(var i = 0; i < $scope.requestedServiceList.length; i++){
					  // if($scope.requestedServiceList[i].receiver_id == serv.receiver_id && $scope.requestedServiceList[i].user_service_id == serv.user_service_id && $scope.requestedServiceList[i].confirm_date == serv.confirm_date){
					  if($scope.requestedServiceList[i].id == serv.id){
						  console.log(serv.id);
					  }
			  }
	  } */
	  
      $scope.addService = function (serv) {
          //console.log(serv.negotiate);
          // console.log("ALL Services " + Object.values(serv));
		 
          if (!serv.amount && !serv.negotiate) {
              notify("danger", "Please give amount or choose negotiate option");
              return false;
          }
          if (!serv.variable_name ) {
              notify("danger", "Please select service variable");
              return false;
          }
          if (serv.negotiate) {
              serv.negotiate = "true";
          } else {
              serv.negotiate = "false";
          }
          var dataObj = {
              "service_id": serv.id,
              "variable_name": serv.variable_name,
              "amount": serv.amount,
              "negotiate": serv.negotiate

          }
		  // console.log(" Add Data " + dataObj);
		  console.log(Object.values(dataObj));
		 
          $scope.loadingWinks = true;
          $http.post('/api/saveUserService', dataObj).success(function (data) {
              $scope.getServiceList();
              $scope.loadingWinks = false;
              notify(data.messageType, data.message);
			  // window.location.reload();
          }).error(function (data) {
              $scope.loadingWinks = false;
          });
      }
      

      $scope.removeService = function (usId,id) {
            if(id==10){
                 bootbox.confirm({
              size: 'small',
              message: "If you remove the Private Gallery service, users will no longer be able to send requests or subscribe to your current Private Gallery. <br> Click OK to confirm.",
              title: "Remove Private Galley Service",
              callback: function (result) {
                  if (result) {
                      $scope.removeService2(usId);
                  }
              }
          });
            }else{
              $scope.removeService2(usId);
            }
         
      }

      $scope.removeService2= function (usId) {

          $scope.loadingWinks = true;
          $http.get('/api/deleteUserService/' + usId).success(function (data) {
              $scope.loadingWinks = false;
              $scope.getServiceList();
              notify(data.messageType, data.message);
          }).error(function (data) {
              $scope.loadingWinks = false;
          });
      }


      $scope.changeServiceRequestStatus = function (service_request_id, status) {
       var message="Are you sure you want to change service request status? <br> Click OK to confirm.";
      var title= "Change Service Request Status";
          if(status==3){
            message="Are you sure you want to delete this service? <br> Click OK to confirm.";
            title="Delete Service.";
          }

          bootbox.confirm({
              size: 'small',
              message: message,
              title: title,
              callback: function (result) {
                  if (result) {
                      $scope.loadingWinks = true;
                      $http.get('/api/changeServiceRequestStatus/' + service_request_id + '/' + status).success(function (data) {
                          $scope.loadingWinks = false;
                          
                          $scope.getRequestedServiceList(true);
                          $scope.getPendingServiceRequest();
                          notify(data.messageType, data.message);
                      }).error(function (data) {
                          notify("success", "Your service request status changed successfully");
                      }).finally(function(data){
						  $scope.loadingWinks = false;
					  });
                  }
              }
          });

      }
     
       $scope.displayDate=function(dat){
       return new Date(dat).getTime();
       }

      $scope.parseId = function (service) {
         var str = ""+service.amount;
        var res = str.substr(0, 6);
        service.amount = parseFloat(res);
      }
      $scope.getNumber2 = function (n) {
          return new Array(n);
      }
      $scope.customfun = function (n, k) {
          ml = Math.abs(n - k);
          if (ml < 5) {
              return true;
          } else {
              return false;
          }
      }
      $scope.customfun2 = function (n, k) {
          ml = Math.abs(n - k);
          if (ml == 5) {
              return true;
          } else {
              return false;
          }
      }
      /* $scope.changePage = function (val) {
          $scope.page = $scope.page + val;
          $scope.getRequestedServiceList();
      } */
      $scope.goPage = function (val) {
          $scope.page = val;
          $scope.getRequestedServiceList();
      }

      $scope.getRequestedServiceList = function (action) {
			// alert("page" + $scope.page);
          $scope.loadingWinks = true;
          $http.get('/api/getAllServiceRequest/' + $scope.page).success(function (data) {
              $scope.loadingWinks = false;
              $scope.count = Math.ceil(data.new.count);  
			  $scope.totalBrowse = data.new.total_count;			  
			  $scope.requestedServiceList = data.new.data;

			  if(action != undefined) {
				  if($scope.totalBrowse / $scope.perPageBrowse > 1 && $scope.page > 1) {
				  	$scope.goPage($scope.page);
				  } else {
				  	$scope.goPage(1);
				  }
			  }
			  // console.log("total Count " + $scope.count );			  			  // APInfo
			 				
			  // data.new.data.forEach(function(entry) {					console.log(entry);				});				// APInfo
			  // console.log(files[i]);				console.log("hello");				// console.log("total Count " + $scope.count + " service_name " + $scope.requestedServiceList[0].service_name + " created_at " + $scope.requestedServiceList[0].created_at + " User " + $scope.requestedServiceList[0].username + " Id " + $scope.requestedServiceList[0].id + " Access For " + $scope.requestedServiceList[0].variable_name); // APInfo
			  
              if ($scope.page < 2) {
                  $scope.prev = false;
              } else {
                  $scope.prev = true;
              }
              $scope.next = data.new.is_nxt;

          }).error(function (data) {
              $scope.loadingWinks = false;
          });


      }
      $scope.getRequestedServiceList();

      $scope.getPendingServiceRequest = function () {
		  // $scope.Qs = [];
          $scope.loadingWinks = true;
          $http.get('/api/getPendingServiceRequest').success(function (data) {
              $scope.loadingWinks = false;
			  // $scope.Qs = data.new.qry;
              $rootScope.pending_count = data.new.count;
			/* for(var i = 0; i < $scope.Qs.length; i++){
				console.log("Query "+i+" " + $scope.Qs[i].query);
				console.log("Query "+i+" " + $scope.Qs[i].bindings);
			} */

          }).error(function (data) {
              $scope.loadingWinks = false;
          });


      }
	
	$scope.perPageBrowse = 5;
	$scope.pageBrowse = 1;
	

	$scope.changePage = function(page,perPage,total) {
		$scope.perPageBrowse = perPage;
		$scope.pageBrowse = page;
		$scope.page = page;
		$scope.totalBrowse = total;
		
		$scope.getRequestedServiceList();
		$scope.goToByScroll("service-list")
	}
	
	$scope.goToByScroll =function(id){
		$('html,body').animate({scrollTop: $("#"+id).offset().top- 100},'slow');
	}
}]);

	ServiceCtrl.directive('validNumber', function() {
      return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
          if(!ngModelCtrl) {
            return; 
          }

          ngModelCtrl.$parsers.push(function(val) {
            if (angular.isUndefined(val)) {
                var val = '';
            }
            
            var clean = val.replace(/[^-0-9\.]/g, '');
            var negativeCheck = clean.split('-');
			var decimalCheck = clean.split('.');
            if(!angular.isUndefined(negativeCheck[1])) {
                negativeCheck[1] = negativeCheck[1].slice(0, negativeCheck[1].length);
                clean =negativeCheck[0] + '-' + negativeCheck[1];
                if(negativeCheck[0].length > 0) {
                	clean =negativeCheck[0];
                }
                
            }
              
            if(!angular.isUndefined(decimalCheck[1])) {
                decimalCheck[1] = decimalCheck[1].slice(0,2);
                clean =decimalCheck[0] + '.' + decimalCheck[1];
            }

            if (val !== clean) {
              ngModelCtrl.$setViewValue(clean);
              ngModelCtrl.$render();
            }
            return clean;
          });

          element.bind('keypress', function(event) {
            if(event.keyCode === 32) {
              event.preventDefault();
            }
          });
        }
      };
    });
