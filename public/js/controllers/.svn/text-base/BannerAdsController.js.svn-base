var BannerAdsCtrl = angular.module('BannerAdsCtrl',['ngFileUpload']);

BannerAdsCtrl.controller('BannerAdsController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', 'Upload', function($scope, $http, $location, $rootScope, $timeout, Upload) {
    moment.locale('en_gb', {
        week : {
            dow : 1
        }
    });
    $scope.events = [];
    $scope.calendarView = 'month';
    $scope.viewDate = moment().startOf('month').toDate();
    $scope.month = moment().startOf('month').toDate();
    $scope.year = moment().year();
    $scope.selectedDates = [];
    $scope.type = undefined;
    $scope.typeSelected = false;
    $scope.monthIndex = $scope.viewDate.getMonth();
    $scope.selectedDays = [];
    $scope.bookedDays = [];
    $scope.filesConfirmed = false;
    $scope.options = {
        minDate: new Date()
    };
    $scope.requestFormData = {
        extra_promotions: false,
        type: $scope.type
    };

    $scope.confirmFiles = function() {
        $scope.filesConfirmed = true;
    }

    $scope.unconfirmFiles = function() {
        $scope.filesConfirmed = false;
    }

    $scope.getBookedDays = function() {
        $http.get('/api/banner-ad', {}).then(function(response) {
            $scope.bookedDays = response.data.map(function(bookedDay) {
                return bookedDay.day;
            })
        });
    }

    $scope.submitModal = function(modalName) {
        var modal = $scope.$eval(modalName);
        modal.data.crop = [];
        $('#' + modalName + 'Modal input[type="hidden"]:not([name="type"])').each(function(key, item) {
          modal.data.crop[$(item).attr('name')] = $(item).val();
        });
        $scope.hideModal(modalName);
        var preview = $('#' + modalName + 'Preview');
        preview.attr('src', $('#' + modalName  + 'Modal').find('img.live-preview').cropper('getCroppedCanvas').toDataURL());
        preview.parent().removeClass('hidden');
        $scope.filesConfirmed = true;
    }

    $scope.completeBooking = function (event) {
        var jButton = $(event.target);
        jButton.attr('disabled','disabled');
        var file;
        if($scope.type === 'video') {
            file = $('#videoFile').prop('files')[0];
        } else {
            file = {};
            var photoFile1 = $('#photoFile1').prop('files')[0];
            if(photoFile1) {
                file.file1 = photoFile1;
                $scope.requestFormData.file1CropData = $scope.$eval('addPhoto1').data.crop;
            }
            var photoFile2 = $('#photoFile2').prop('files')[0];
            if(photoFile2) {
                file.file2 = photoFile2;
                $scope.requestFormData.file2CropData = $scope.$eval('addPhoto2').data.crop;
            }
            var photoFile3 = $('#photoFile3').prop('files')[0];
            if(photoFile3) {
                file.file3 = photoFile3;
                $scope.requestFormData.file3CropData = $scope.$eval('addPhoto3').data.crop;
            }
            var photoFile4 = $('#photoFile4').prop('files')[0];
            if(photoFile4) {
                file.file4 = photoFile4;
                $scope.requestFormData.file4CropData = $scope.$eval('addPhoto4').data.crop;
            }
        }
        $scope.requestFormData.selectedDays = $scope.selectedDays;
        $scope.notify = uploadProgress('');
        $scope.upload = Upload.upload({
            method: 'POST',
            url: '/api/banner-ad-request',
            data: $scope.requestFormData,
            file: file
        }).progress(function (evt) {
            $scope.uploadProgress = parseInt(100.0 * evt.loaded / evt.total, 10);
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            $scope.notify.update('progress', progressPercentage);
        }).then(function (response) {
            $scope.notify.close();
            if(response.data.messageType === 'success') {
                $scope.getBookedDays();
            }
            $scope.type = undefined;
            $scope.typeSelected = false;
            $scope.filesConfirmed = false;
            $scope.selectedDays = [];
            $scope.selectedDates = '';
            $scope.requestFormData.extra_promotions = false;
            jButton.removeAttr('disabled');
            notify(response.data.messageType, response.data.message);
        });
    }

    $scope.setMonths = function(direction) {
        if(direction === 'next') {
            if($scope.monthIndex === 11) {
                $scope.monthIndex = 0;
                $scope.year++;
            } else {
                $scope.monthIndex++;
            }
        } else if(direction === 'prev') {
            if($scope.monthIndex === 0) {
                $scope.monthIndex = 11;
                $scope.year--;
            } else {
                $scope.monthIndex--;
            }
        }
        $scope.monthInView = $scope.getMonth();
    };

    $scope.getActiveTypeClass = function (type) {
        return type === $scope.type ? 'active' : '';
    };

    $scope.selectType = function(type) {
        $scope.type = type;
        $scope.requestFormData.type = type;
        $scope.typeSelected = true;
        $scope.filesConfirmed = false;
    };

    $scope.rangeSelected = function(startDate, endDate) {
      $scope.firstDateClicked = startDate;
      $scope.lastDateClicked = endDate;
    };

    $scope.selectDay = function(cell) {
        if(cell.isToday) {
            notify('warning', 'You can only select dates starting tomorrow.');
            return;
        }
        if(cell.isPast) {
            notify('warning', 'That date is in the past.');
            return;
        }
        if($scope.bookedDays.indexOf(cell.date.format("YYYY-MM-DD")) > -1) {
            notify('warning', 'That date has already been booked.');
            return;
        }

        var day = cell.date.format("YYYY-MM-DD");
        var cellIndex = $scope.selectedDays.indexOf(day);
        if(cellIndex === -1) {
            if($scope.selectedDays.length === 4) {
                notify('warning','You have already selected the maximum of 4 days.');
                return;
            }
            if(!$scope.validateConsecutiveDates(cell.date)) {
                notify('warning', 'You can only select consecutive dates.');
                return;
            }
            $scope.selectedDays.push(day);
        } else {
            $scope.selectedDays = [];
        }

        $scope.$broadcast('calendar.refreshView');

        $scope.selectedDates = $scope.selectedDays.sort(function(day1, day2) {
            return new Date(day2) - new Date(day1);
        }).map(function(day) {
            return $scope.getLocalDateFormat(day);
        }).reverse().join(', ');
    }

    $scope.validateConsecutiveDates = function(selectedDay) {
        if($scope.selectedDays.length == 0) {
            return true;
        } else if($scope.selectedDays.length == 1) {
            var preselectedDay = moment($scope.selectedDays[0]);
            return $scope.validateConsecutiveDate(preselectedDay, selectedDay);
        } else if($scope.selectedDays.length > 1) {
            return $scope.validateConsecutiveDate(moment($scope.selectedDays[0]), selectedDay) ||
                $scope.validateConsecutiveDate(moment($scope.selectedDays[$scope.selectedDays.length - 1]), selectedDay);
        }
    }

    $scope.validateConsecutiveDate = function(date1, date2) {
        var diffInDays = date1.diff(date2, 'days');
        return diffInDays === -1 || diffInDays === 1;
    };

    $scope.getLocalDateFormat = function(dateString) {
        return moment(new Date(dateString)).format('DD/MM/YYYY');
    };

    $scope.getMonth = function(index) {
      const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];

      return monthNames[index ? index : $scope.monthIndex];
    };

    $scope.cellModifier = function(cell) {
        if($scope.bookedDays && $scope.bookedDays.indexOf(cell.date.format("YYYY-MM-DD")) > -1) {
            cell.cssClass = cell.cssClass + " booked";
        } else if($scope.selectedDays.indexOf(cell.date.format("YYYY-MM-DD")) > -1) {
            cell.cssClass = cell.cssClass + " active";
        }
    };

    $scope.viewChangeClicked = function(nextView) {
        if (nextView !== 'month') {
            return false;
        }
    };

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
      }

      $scope.hideModal = function(modalName) {
        $('#' + modalName + 'Modal').modal('hide');
      }

    $scope.setMonths();
    $scope.getBookedDays();
}]);