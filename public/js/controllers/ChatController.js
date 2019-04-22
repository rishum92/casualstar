var ChatCtrl = angular.module('ChatCtrl',[]);

ChatCtrl.controller('ChatController', ['$scope', '$http', '$location', '$rootScope' , '$timeout', '$interval', 'Upload', function($scope, $http, $location, $rootScope, $timeout, $interval, Upload) {
	$scope.chats = [];
  $scope.chat = undefined;
  $scope.requestedChatId = undefined;

  $scope.messageToSend = '';
  $scope.isOnline = false;
  $scope.isTyping = false;
  $scope.isTypingTimeout = undefined;
  $scope.partnerTyping = false;

  $scope.shiftPressed = false; 
  $scope.showMessages = 10;
  $scope.showChats = 10;
  $scope.loadingMessages = false; 
  $scope.endMessages = false;

  $scope.socket = undefined;


  // $scope.$watch('altDonate', function(altDonate) {
  //   console.log(altDonate);return;
  //   var username = 'tudor';
  //   $scope.altDonateMessage = 
  // });

  $('#conversation').scroll(function () {
    console.log('here');
    if($('#conversation').scrollTop() == 0 && $('#conversation').hasScrollBar()) {
      console.log('scrollTop');
      if($scope.showMessagesTimeout == undefined && !$scope.endMessages) {
        $scope.showMessagesTimeout = $timeout(function() {
          console.log('showMessagesTimeout');
          $scope.loadingMessages = true;
          $scope.showMessages = $scope.showMessages + 10;
          $scope.showMessagesTimeout = undefined;
          $scope.socket.emit('pushMessages', {chatId: $scope.chat._id, userId: $scope.user.id, partnerId: $scope.chat.partner.id, slice: $scope.showMessages});
          $scope.$applyAsync();
         }, 1000
        );
      }
    }  
  });

  $scope.$watch('messageToSend', function(key, messageToSend) {
    if($scope.chat) {
      if($scope.messageToSend !== '') {
        if(!$scope.isTyping) {
          if($scope.isTypingTimeout != undefined && $scope.isTypingTimeout.$$state.status == 0) {
            $timeout.cancel($scope.isTypingTimeout);
          } else {
            $scope.isTypingTimeout = $timeout(function() {
              $scope.socket.emit('stopTyping', {chatId: $scope.chat._id, userId: $scope.user.id, partnerId: $scope.chat.partner.id});
              $scope.isTyping = false;
            }, 5000);
          }

          $scope.socket.emit('isTyping', {chatId: $scope.chat._id, userId: $scope.user.id, partnerId: $scope.chat.partner.id});
          $scope.isTyping = true;
        }
      } else {
        if($scope.isTypingTimeout != undefined && $scope.isTypingTimeout.$$state.status == 0) {
          $timeout.cancel($scope.isTypingTimeout);
        }

        $scope.socket.emit('stopTyping', {chatId: $scope.chat._id, userId: $scope.user.id, partnerId: $scope.chat.partner.id});
        $scope.isTyping = false;
      }
    }
  });

  $scope.$watch('chatId', function(key, chatId) {
    if(chatId != '') {
      if(chatId == 'new') {
        $scope.requestedChatId = chatId; 
      } else {
        $scope.requestedChatId = chatId; 
      }
    }
  });

  $scope.$watch('newChat', function(key, newChat) {
    console.log('newChat is');
    console.log(newChat);
    if(newChat !== undefined) {
      if(typeof newChat == 'string') {
        newChat = $.parseJSON(newChat);
        if(newChat._id == 'new') {
          $scope.chats.push(newChat);
          var index = $scope.chats.indexOf(newChat);
          $scope.switch($scope.chats[index]);
        }
      }
    }
  });

  $scope.$parent.$watch('socket', function(socket) {
    if(socket != undefined) {
      console.log('OMG');
      $scope.socket = socket;

      $scope.socket.on('endMessages', function(data) {
        console.log('endMessages');
        $scope.endMessages = true;
        $scope.loadingMessages = false;
        $scope.$applyAsync();
      });

      $scope.socket.on('chatCreated', function(data) {
        console.log('chatCreated');
        $($scope.chats).each(function(key, chat) {
          console.log(chat._id);
          console.log(data._id);
          if(chat._id == 'new') {
            $scope.chats[key]._id = data._id;
            $scope.$applyAsync();
          }
        });
      });

      $scope.socket.on('newChat', function(data) {
        console.log('newChat');
        if(data.new) {
          $scope.chats.unshift(data);
        } else {
          $scope.chats.push(data);
        }
        if($scope.requestedChatId != undefined && data._id == $scope.requestedChatId) {
          console.log('requested');
          var index = $scope.chats.indexOf(data);
          $scope.switch($scope.chats[index]);
        } else if($scope.chat == undefined) {
          console.log('not requested');
          $scope.$applyAsync();
        }

      });

      $scope.socket.on('isTyping', function(data) {
        console.log('isTyping');
        if($scope.chat) {
          $($scope.chats).each(function(key, chat) {
            if(data.chatId == chat._id && data.chatId == $scope.chat._id) {
              $scope.partnerTyping = true;
            }
          });
          $scope.$applyAsync();
        }
      });

      $scope.socket.on('stopTyping', function(data) {
        console.log('stopTyping');
        if($scope.chat) {
          $($scope.chats).each(function(key, chat) {
            if(data.chatId == chat._id && data.chatId == $scope.chat._id) {
              $scope.partnerTyping = false;
            }
          });
          $scope.$applyAsync();
        }
      });

      $scope.socket.on('pushMessages', function(data) {
        console.log('pushMessages');
        console.log(data);
        if($scope.chat._id == data._id) {
          var messages = data.messages.reverse();
          $(messages).each(function(key, message) {
            $scope.chat.messages.unshift(message);
          });
          $scope.loadingMessages = false;
          $scope.$applyAsync();
        }
      });

      $scope.socket.on('destroyChat', function(data) {
        console.log('destroyChat');
        // $($scope.chats).each(function(key, chat) {
        //   console.log(data.chatId);
        //   console.log(chat._id);
        //   if(data.chatId == chat._id) {
        //     $scope.chats[key].closed = true;
        //     if($scope.chat._id == data.chatId) {
        //       $scope.messageToSend = '';
        //     }
        //     $scope.$applyAsync();
        //   }
        // });
      });

      $scope.socket.on('disconnect', function(data) {
        $scope.chats = [];
        $scope.chat = undefined;
        $scope.$applyAsync();
      });

      $scope.socket.on('getMessage', function(data) {
        console.log('getMessage');
        console.log(data);
        var chatExists = false;
        $($scope.chats).each(function(key, chat) {
          if(data.chatId == chat._id) {
            $scope.chats[key].updated = $scope.getMessageDate(data.message.sent);
            if($scope.chats[key].closed) {
              $scope.chat.closed = false;
            }
            if(data.message.message != '') {
              $scope.chats[key].messages.push(data.message);
            }
            
            if($scope.chat) {
              if(data.chatId != $scope.chat._id && data.message.id !== $scope.user.id) {
                $scope.chats[key].unread = $scope.chats[key].unread + 1;
              } else if(data.chatId == $scope.chat._id && data.message.id !== $scope.user.id) {
                if($scope.subscribed == 1) {
                  $scope.socket.emit('readChat', {chatId: chat._id, userId: $scope.user.id, partnerId: chat.partner.id});
                  $scope.$parent.messageCount = $scope.$parent.messageCount - 1;
                } else {
                  $scope.chats[key].unread = $scope.chats[key].unread + 1;
                }
              }
            } else {
              if(data.message.id !== $scope.user.id) {
                $scope.chats[key].unread = $scope.chats[key].unread + 1;
              }
            }

          }
        });

        $scope.$applyAsync();

      });

      $scope.socket.on('isOnline', function(data) {
        console.log('isOnline');
        $scope.isOnline = data;
        $scope.$applyAsync();
      });
    } 
  });

  $scope.switch = function(chat, event) {
    console.log('switch');
    if(event != undefined) {
      if($(event.target).hasClass('ion-trash-a')) {
        return;
      } else {
        console.log('animation');
        $('html, body').animate({
          scrollTop: $('#conversation').offset().top - 120
        }, 500);
        $('.wrap.pusher').toggleClass('pushed');
        $('body').toggleClass('framed');
      }
    }
    
    $('#conversation').scrollTop($('#conversation')[0].scrollHeight);

    if(chat != undefined) {
      console.log(chat.unread);

      if($scope.$parent.subscribed == 1) {
        $scope.$parent.messageCount = $scope.$parent.messageCount - chat.unread;
        $scope.$parent.notificationCount = $scope.$parent.notificationCount - chat.unread;
        $scope.$parent.$applyAsync();
      }

      if($scope.$parent.subscribed == 1 && chat._id !== 'new') {
        $scope.socket.emit('readChat', {chatId: chat._id, userId: $scope.user.id, partnerId: chat.partner.id});
        chat.unread = 0;
      }

      if(chat.messages.length > 0) {
        chat.updated = $scope.getMessageDate(chat.messages[chat.messages.length - 1].sent);
      }

      if(chat._id !== 'new') {
        $scope.socket.emit('isOnline', {partnerId: chat.partner.id});
      }
      
      if($scope.chat != undefined) {
        if($scope.chat._id != chat._id) {
          $scope.messageToSend = '';
        }
      }

      $($scope.chats).each(function(key, chat2) {
        var chatClass = '';
        if(chat._id == chat2._id) {
          // if(chat.closed) {
          //   chatClass = chatClass + ' closed'
          // }
          // chatClass = chatClass + ' active';
          $scope.chat = $scope.chats[key];
          $scope.chats[key].active = true;
        } else {
          $scope.chats[key].active = false;
        }
      });

      $scope.showMessages = 10;
      $scope.endMessages = false;
      $scope.loadingMessages = false;
      $scope.$applyAsync();

    }

  }

  $scope.altDonate = function() {
  }


  $scope.submitModal = function(modalName) {
    var modal = $scope.$eval(modalName);
    switch(modalName) {
      case 'altDonate':
        $scope.socket.emit('altDonate', {username: $('#altDonateUsername').val(), message: $('#altDonateMessage').val()});
        notify('success', 'Alternative donation method request sent!');
      break;
    }

    modal.data = [];
    modal.$setPristine();
    $scope.hideModal(modalName);
  }

  $scope.send = function() {    
    if($scope.messageToSend != '') {
      $scope.socket.emit('sendMessage', {chatId: $scope.chat._id, userId: $scope.user.id, message: $scope.messageToSend, partnerId: $scope.chat.partner.id});
      $scope.messageToSend = '';
      if($scope.chat._id !== 'new') {
        $scope.socket.emit('readChat', {chatId: $scope.chat._id, userId: $scope.user.id, partnerId: $scope.chat.partner.id});
      }
    }
  }
  // $scope.offer_message_send = function(){
  //   console.log($scope.offermessagesend);
  // }

  $scope.destroyMessage = function(item) {
    $http.post('/api/delete-message', {chatId: $scope.chat._id, userId: $scope.user.id, messageId: item._id}).then(function(response) {
      var index = $scope.chat.messages.indexOf(item);
      $scope.chat.messages.splice(index, 1);
      $('#conversation').scrollTop($('#conversation')[0].scrollHeight);
      notify(response.data.messageType, response.data.message);
    });
  }

  $scope.destroyChat = function(item) {
    var index = $scope.chats.indexOf(item);
    
    if(item._id == 'new') {
      $scope.chats.splice(index, 1);
      if(item._id == $scope.chat._id) {
        $scope.chat = undefined;
      }
    } else {
      $http.post('/api/delete-chat', item).then(function(response) {
        $scope.chats.splice(index, 1);
        if($scope.chats.length > 0) {
          $scope.switch($scope.chats[0]);
        } else {
          if(item._id == $scope.chat._id) {
            $scope.chat = undefined;
          }
        }

        $scope.socket.emit('destroyChat', {chatId: item._id, userId: $scope.user.id, partnerId: item.partner.id});
        notify(response.data.messageType, response.data.message);
      });
      
    }
  }

  $scope.getChatClass = function(chat) {
    // console.log('getChatClass');
    var chatClass = '';
    if(chat.active == true) {
      return chatClass + ' active';
    } else {
      return chatClass + '';
    }
    
  }

  $scope.getMessageClass = function(message) {
    console.log('getMessageClass');
    var chatClass = '';
    if($.inArray($scope.user.id, message.deleted) > -1) {
      chatClass = chatClass + 'hidden';
    }
    if(message.id == $scope.user.id) {
      chatClass = chatClass + ' partner';
    }

    return chatClass;
  }

  $scope.getMessageDate = function(date) {
    // console.log('getMessageDate');
    var formattedDate = moment(date).format('D MMM YYYY, h:mm:ss A');
    return formattedDate;
  }


  $scope.getPhotoPreviewUrl = function(user) {
    console.log('getPhotoPreviewUrl');
    if(user != undefined) {
      if(user.img != undefined) {
        return '/img/users/' + user.username + '/chat/' + user.img;
      } else {
        return '/img/' + user.gender + '.jpg';
      }
    }
  }

  $scope.hideModal = function(modalName) {
    $('#' + modalName + 'Modal').modal('hide');
  }

}]);
