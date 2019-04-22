<?php $__env->startSection('meta'); ?>
  <title>Messages » CasualStar</title> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="messages" id="messages-top" data-ng-controller="ChatController" data-ng-init="chatId='<?php echo e($chatId); ?>';newChat='<?php echo e($chat); ?>';subscribed=1" >
    <div class="loader" data-ng-hide="!loadingMessages">
      <div class="spinner">
        <img src="<?php echo e(URL::asset('img/ring.gif')); ?>" alt="loader" /> 
      </div>
    </div>
    <div class="wrap users-box-wrap"> 
      <div class="mobile-users-box" id="users-box">
        <ul>
          <li data-ng-click="switch(chat, $event)" data-ng-repeat="(key, chat) in chats" class="block-flex wrap-flex vertical-center-flex [[getChatClass(chat)]]">
            <div class="image">
              <img data-ng-src="/img/users/[[chat.partner.username]]/chat/[[chat.partner.img]]" alt="[[chat.partner.username]]" />  
            </div> 
            <span>[[chat.partner.username]]<br> 
            <p class="date">[[chat.updated || getMessageDate(chat.updated_at)]]</p>
            </span>
            <button type="button" class="edit-button" placement="left" mwl-confirm="" title="<?php echo e(Lang::get('messages.removeChat')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyChat(chat)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
            <p class="new-message" data-ng-if="chat.unread > 0 && chat.unread < 100">[[chat.unread]]</p>
            <p class="new-message large-notif" data-ng-if="chat.unread > 99">99+</p>
          </li>
        </ul>
      </div>
    </div>
    <div class="wrap pusher"> 
      <!-- <div class="block-flex wrap-flex " data-ng-hide="chats.length > 0">
        <h3 class="no-chats" data-ng-if="user.gender == 'female'">Loading... Please wait while we fetch your messages for you.</h3>
        <h3 class="no-chats" data-ng-if="user.gender == 'male'"><?php echo e(Lang::get('messages.noChats')); ?></h3>
      </div> -->
      <button class="toggle-chats">
        <i class="ion-chatbubbles"></i>chats
        <span class="chat-indicator" data-ng-if="$parent.messageCount > 0 && $parent.messageCount < 100">[[$parent.messageCount]]</span>
        <span class="chat-indicator large-indicator" data-ng-if="$parent.messageCount > 0 && $parent.messageCount > 99">99+</span></button>
      <div class="block-flex wrap-flex" data-ng-hide="chats.length == 0"> 
        <div class="left"> 
          <h3>From</h3>
          <ul>
            <li data-ng-click="switch(chat, $event)" data-ng-repeat="(key, chat) in chats" class="block-flex wrap-flex vertical-center-flex [[getChatClass(chat)]]">
              <div class="image">
                <a href="/users/[[chat.partner.username]]">
                  <img data-ng-src="/img/users/[[chat.partner.username]]/chat/[[chat.partner.img]]" alt="[[chat.partner.username]]" />  
                </a>
              </div> 
              <span>[[chat.partner.username]]<br>
              <p class="date">[[chat.updated || getMessageDate(chat.updated_at)]]</p>
              </span>
              <button type="button" class="edit-button" mwl-confirm="" placement="left" title="<?php echo e(Lang::get('messages.removeChat')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyChat(chat)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
              <p class="new-message" data-ng-if="chat.unread > 0 && chat.unread < 100">[[chat.unread]]</p>
              <p class="new-message large-notif" data-ng-if="chat.unread > 99">99+</p>
            </li>
          </ul>
        </div>
        <div class="right">
          <div data-ng-hide="chat == undefined" class="chat-content">
            <h1>[[chat.partner.username]]<span data-ng-if="isOnline">online now</span></h1>
            <div class="conversation" id="conversation" data-scroll-glue>
              <div class="subscription-overlay" ng-hide="true">
                <h3><span>[[chat.partner.username]]</span> has just sent you a message. </h3>
                <p>Please subscribe now to enable instant messaging with [[chat.partner.username]] and all other members.</p>
                <button class="main-btn" data-toggle="modal" data-target="#subscribeModal">Subscribe now</button>
              </div>
              <p data-ng-hide="!endMessages" style="text-align:center;margin-top:20px;">Conversation started: [[getMessageDate(chat.created_at)]]</p>
              
              <div class="message block-flex wrap-flex [[message.class]]" data-ng-hide="key < chat.messages.length - showMessages || user.id == message.deleted[0] || user.id == message.deleted[1]" data-ng-class="{'partner': message.id == user.id}" data-ng-repeat="(key, message) in chat.messages">
                <div class="image">
                  <img data-ng-if="message.id == user.id && user.img" data-ng-src='/img/users/[[user.username]]/chat/[[user.img]]' alt="[[user.username]]" />
                  <img data-ng-if="message.id == user.id && !user.img" data-ng-src='/img/[[user.gender]].jpg' alt="[[user.username]]" />
                  <a data-ng-if="message.id !== user.id" href="/users/[[chat.partner.username]]">
                    <img data-ng-src='/img/users/[[chat.partner.username]]/chat/[[chat.partner.img]]' alt="[[user.username]]" />
                  </a>
                </div>
                <div class="text">
                  [[message.message]]
                  <span class="date-sent">[[getMessageDate(message.sent)]]</span> 
                </div>
                <button type="button" class="edit-button" placement="left" data-ng-show="message.id == user.id" mwl-confirm="" title="<?php echo e(Lang::get('messages.removeMessage')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyMessage(message)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
              </div>
            </div>
             
            <div class="textarea">
              <p class="is-typing" data-ng-hide="!partnerTyping">[[chat.partner.username]] is typing</p>
              <form data-ng-submit="send()">
                <div class="form-group">
                  <textarea data-ng-readonly="subscribed == 0" data-ng-model="messageToSend" enter="send()" shift class="form-control" placeholder="Type a message here..."></textarea>
                </div>
                <button type="submit" class="send-btn"><i class="ion-ios-paperplane"></i><span>send</span></button>
              </form>
            </div>
          </div>

          <!-- <p data-ng-hide="chat != undefined">Select a chat.</p> -->
          <a href="#messages-top" class="mobile-to-top main-btn stroke-btn">back to top</a>
        </div>
      </div>
    </div>

    <?php echo $__env->make('modals.payment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>