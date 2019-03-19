var AdminBannerAdsCtrl = angular.module('AdminBannerAdsCtrl', []);

AdminBannerAdsCtrl.controller('AdminBannerAdsController', ['$scope', '$http', '$location', '$rootScope', '$timeout', 'Upload', function ($scope, $http, $location, $rootScope, $timeout, Upload) {
    moment.locale('en_gb', {
        week: {
            dow: 1
        }
    });

    $scope.perPageBannerAdRequests = 20;
    $scope.pageBannerAdRequests = 1;
    $scope.totalBannerAdRequests = 0;
    $scope.activeBannerAdsCount = 0;

    $scope.activeBannerAdRequests = 0;
    $scope.totalActiveBannerAdRequests = 0;
    $scope.perPageActiveBannerAdRequests = 20;
    $scope.pageActiveBannerAdRequests = 1;

    $scope.bannerAds = [];
    $scope.bookedDays = [];
    $scope.calendarView = 'month';
    $scope.viewDate = moment().startOf('month').toDate();
    $scope.month = moment().startOf('month').toDate();
    $scope.year = moment().year();
    $scope.monthIndex = $scope.viewDate.getMonth();
    $scope.modalBannerAdRequest = undefined;

    $scope.saveTimeout = undefined;

    $scope.slickConfig = {
        enabled: true,
        arrows: false,
        autoplay: true
    };

    $scope.getBannerAds = function() {
        var url = '/admin/api/banner-ads';
        $http.get(url).then(function (response) {
            $scope.bannerAds = response.data;
            $scope.bookedDays = [];
            $scope.bookedDays = response.data.map(function (bookedDay) {
                return bookedDay.day;
            });
            $scope.$broadcast('calendar.refreshView');
        });
    }

    $scope.updateNotes = function(bannerAdRequest) {
        if($scope.saveTimeout != undefined) {
            clearTimeout($scope.saveTimeout);
        }
        $scope.saveTimeout = setTimeout(function() {
            $http.patch('/admin/api/banner-ad-request/' + bannerAdRequest.id, {
                key: 'notes',
                value: bannerAdRequest.notes
            }).then(function (response) {
                notify('success', 'Banner ad request notes have been updated.');
            });
        }, 1000);
    }

    $scope.getBannerAdRequests = function () {
        var params = {
            pageBannerAdRequests: $scope.pageBannerAdRequests,
            perPageBannerAdRequests: $scope.perPageBannerAdRequests,
            filters: {
                status: 'review'
            }
        }
        var url = '/admin/api/banner-ad-requests?1=1&' + $.param(params);
        $http.get(url).then(function (response) {
            $scope.bannerAdRequests = response.data.new.bannerAdRequests;
            $scope.totalBannerAdRequests = response.data.new.count;
            $scope.$broadcast('calendar.refreshView');
            $scope.getActiveBannerAdRequests();
// $scope.activeBannerAdsCount = $scope.bannerAdRequests.filter(function (adRequest) {
            //     return adRequest.status === 'active';
            // }).length;
        });
    }

    $scope.getActiveBannerAdRequests = function () {
        var params = {
            pageActiveBannerAdRequests: $scope.pageActiveBannerAdRequests,
            perPageActiveBannerAdRequests: $scope.perPageActiveBannerAdRequests,
            filters: {
                status: 'review'
            }
        }
        var url = '/admin/api/active-banner-ad-requests?1=1&' + $.param(params);
        $http.get(url).then(function (response) {
            $scope.activeBannerAdRequests = response.data.new.bannerAdRequests;
            $scope.totalActiveBannerAdRequests = response.data.new.count;
            $scope.$broadcast('calendar.refreshView');
        });
    }

    $scope.decrementBannerAdNotificationCount = function() {
        var bannerAdNotification = $('.banner-ad-notification');
        var bannerAdNotificationCount = parseInt(bannerAdNotification.attr('data-count'));
        var newBannerAdNotificationCount = bannerAdNotificationCount - 1;
        if(newBannerAdNotificationCount === 0) {
            bannerAdNotification.hide();
        } else if(newBannerAdNotificationCount > 99) {
            newBannerAdNotificationCount = "99+";
        }

        bannerAdNotification.text(newBannerAdNotificationCount);
        bannerAdNotification.attr('data-count', newBannerAdNotificationCount);
    }

    $scope.denyRequest = function (removeData) {
        $http.post('/admin/api/deny-banner-ad-request', removeData).then(function (response) {
            notify('success', 'Banner ad request has been denied.');
            $scope.decrementBannerAdNotificationCount();
            $scope.getBannerAdRequests();
            $scope.getBannerAds();
        });
    }

    $scope.removeBannerAd = function (removeData) {
        $http.post('/admin/api/remove-banner-ad', removeData).then(function (response) {
            notify('success', 'Banner ad has been removed.');
            $scope.getBannerAdRequests();
            $scope.getActiveBannerAdRequests();
            $scope.getBannerAds();
        });
    }

    $scope.approveRequest = function (bannerAdRequest) {
        $http.post('/admin/api/approve-banner-ad-request', {
            banner_ad_request_id: bannerAdRequest.id
        }).then(function (response) {
            $scope.decrementBannerAdNotificationCount();
            notify('success', 'Banner ad request has been approved.');
            $scope.getBannerAdRequests();
            $scope.getBannerAds();
        });
    }

    $scope.changePageActiveBannerAdRequests = function (page, perPage, total) {
        $scope.pageActiveBannerAdRequests = page;
        $scope.perPageActiveBannerAdRequests = perPage;
        $scope.totalActiveBannerAdRequests = total;
        $scope.getActiveBannerAdRequests();
    }

    $scope.changePageBannerAdRequests = function (page, perPage, total) {
        $scope.pageBannerAdRequests = page;
        $scope.perPageBannerAdRequests = perPage;
        $scope.totalBannerAdRequests = total;
        $scope.getBannerAdRequests();
    }

    $scope.formatDate = function (date) {
        return moment(date).format('D MMM YYYY, h:mm:ss A');
    }

    $scope.setMonths = function (direction) {
        if (direction === 'next') {
            if ($scope.monthIndex === 11) {
                $scope.monthIndex = 0;
                $scope.year++;
            } else {
                $scope.monthIndex++;
            }
        } else if (direction === 'prev') {
            if ($scope.monthIndex === 0) {
                $scope.monthIndex = 11;
                $scope.year--;
            } else {
                $scope.monthIndex--;
            }
        }
        $scope.monthInView = $scope.getMonth();
    };

    $scope.selectDay = function (cell) {
        if($scope.bookedDays.indexOf(cell.date.format("YYYY-MM-DD")) > -1) {
            var bookedDay = $scope.bannerAds.filter(function(bannerAd) {
                return bannerAd.day === cell.date.format("YYYY-MM-DD");
            })[0];
            var bannerAdRequest = $scope.activeBannerAdRequests.filter(function(bannerAdRequest) {
                return bannerAdRequest.id === bookedDay.banner_ad_request_id;
            })[0];
            if(bannerAdRequest === undefined) {
                bannerAdRequest = $scope.bannerAdRequests.filter(function(bannerAdRequest) {
                    return bannerAdRequest.id === bookedDay.banner_ad_request_id;
                })[0];
            }
            $scope.openBannerAdRequestModal(bannerAdRequest);
        }
    }

    $scope.openBannerAdRequestModal = function(bannerAdRequest) {
        $scope.modalBannerAdRequest = bannerAdRequest;
        $scope.openModal('bannerAdRequest', 'bannerAdRequest', bannerAdRequest);
    }

    $scope.getLocalDateFormat = function (dateString) {
        return moment(new Date(dateString)).format('DD/MM/YYYY');
    }

    $scope.getMonth = function (index) {
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        return monthNames[index ? index : $scope.monthIndex];
    }

    $scope.cellModifier = function(cell) {
        if(cell.cssClass == undefined) {
            cell.cssClass = '';
        }
        if($scope.bookedDays && $scope.bookedDays.indexOf(cell.date.format("YYYY-MM-DD")) > -1) {
            cell.cssClass = cell.cssClass + " booked";
        }
    };

    $scope.viewChangeClicked = function (nextView) {
        if (nextView !== 'month') {
            return false;
        }
    };

    $scope.refreshSlick = function() {
        setTimeout(function() {
            $('#adminSlick').slick('slickGoTo', 0);
        }, 100);
    }

    $scope.openModal = function(modalName, optionKey, optionValue) {
        if(optionKey) {
            var modal = $scope.$eval(modalName);
            if(!modal['data']) {
                modal['data'] = [];
            }

            modal['data'][optionKey] = optionValue;
        }
        $('#' + modalName + 'Modal').modal('show');
        $scope.refreshSlick();
    }

    $scope.hideModal = function(modalName) {
        $('#' + modalName + 'Modal').modal('hide');
        $scope.modalBannerAdRequest = undefined;
    }

    $scope.submitModal = function(modalName) {
        var modal = $scope.$eval(modalName);
        switch(modalName) {
            case 'approveVideoBannerAdRequest':
                $http.post('/admin/api/approve-video-banner-ad-request', {
                    banner_ad_request_id: modal.data['banner_ad_request_id'],
                    resource: modal.data['resource']
                }).then(function (response) {
                    notify('success', 'Banner ad request has been approved.');
                    $scope.decrementBannerAdNotificationCount();
                    $scope.getBannerAdRequests();
                    $scope.getBannerAds();
                });
                break;
            case 'removeBannerAdRequest':
                $scope.removeBannerAd({banner_ad_request_id: modal.data['banner_ad_request_id'], reason: modal.data['reason']});
                break;
            case 'denyBannerAdRequest':
                $scope.denyRequest({banner_ad_request_id: modal.data['banner_ad_request_id'], reason: modal.data['reason']});
                break;
        }

        modal.data = [];
        modal.$setPristine();
        $scope.hideModal(modalName);
    }



    $scope.setMonths();
    $scope.getBannerAdRequests();
    $scope.getBannerAds();

}]);
