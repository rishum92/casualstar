@extends('layouts.master')

@section('meta')
  <title>Activity » CasualStar</title>
@endsection

@section('content')
  <div data-ng-controller="ActivityController">
  <!-- notification start -->
    <section class="viewed wrap">
     <div class="row service-list ">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="background: #f1f1f1;">
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
            </div>
             <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                <button class="options-toggle service-list-header " ng-click="toggleNotification()">
                 @if(Auth()->user()->gender=="female")
                 <span>News Feed</span>
                 @endif 
                  @if(Auth()->user()->gender=="male")
                 <span>News Feed</span>
                 @endif 
                  <i class="ion-arrow-down-b"></i></button>
                </div>
              <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
			  @if(Auth()->user()->gender=="male")
                <button ng-if="notification.length>0" mwl-confirm="" title="{{ Lang::get('Remove All News?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteNotification('all')" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-danger pull-right" style="margin-top: 5px;"><span class="glyphicon glyphicon-remove"></span> Clear All</button>
			  @endif
			  @if(Auth()->user()->gender=="female")
                <button ng-if="notification.length>0" mwl-confirm="" title="{{ Lang::get('Remove All Notifications?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteNotification('all')" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-danger pull-right" style="margin-top: 5px;"><span class="glyphicon glyphicon-remove"></span> Clear All</button>
			  @endif
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class=" service-list-inner" id="notificationList">
                   
                    <div class="box col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="box-body">


                            <div class="row service-row" ng-if="notification.length<1||notification==''">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="padding:12px;font-size:17px">
                                    No Record Found
                                </div>
                            </div>

                            
                            <div class="row service-row" ng-repeat="noti in notification">

                                <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9" style="padding:12px;font-size:17px">
                                <span ng-if="noti.type=='PRIVATE_GALLERY'">
                                     New Private Gallery upload, by <a href="/users/[[noti.username]]">
                              [[noti.username]]
                                </a>/ [[ noti.created_at_human]]
                              </span>
                              <span ng-if="noti.type=='PRIVATE_GALLERY_MALE'">
                               You have been granted subscription access to <a href="/users/[[noti.username]]">
                              [[noti.username]]'s
                                </a> Private Gallery for  [[noti.message]] / [[ noti.created_at_human]]
                              </span>
                              <span ng-if="noti.type=='PRIVATE_GALLERY_FEMALE'">
                              <a href="/users/[[noti.username]]">
                              [[noti.username]]
                                </a> has been granted subscription access to your Private gallery for [[noti.message]] / [[ noti.created_at_human]]
                              </span>
                              <span ng-if="noti.type=='NEW_PHOTO_COMMENT'">
                                <a href="/users/[[noti.username]]">
                                  [[noti.username]]
                                </a> has commented on your Public gallery photo [[ noti.created_at_human]]
                              </span>

                              <span ng-if="noti.type=='NEW_PHOTO_LIKE'">
                                <a href="/users/[[noti.username]]">
                                  [[noti.username]]
                                </a> has liked your Public gallery photo [[ noti.created_at_human]]
                              </span>

                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
								@if(Auth()->user()->gender=="male")
                                <button style="position:relative;top:10px;" type="button" class="edit-button" placement="left" mwl-confirm="" title="{{ Lang::get('Remove News?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteNotification(noti.id)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><span class="glyphicon glyphicon-trash"></span></button>
                                @endif
								@if(Auth()->user()->gender=="female")
                                <button style="position:relative;top:10px;" type="button" class="edit-button" placement="left" mwl-confirm="" title="{{ Lang::get('Remove Notification?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteNotification(noti.id)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><span class="glyphicon glyphicon-trash"></span></button>
                                @endif
                                </div>
                                <?php /* <div class="col-md-3" style="padding-top:3px">
								   <button  ng-click="deleteNotification(noti.id)" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> </button>
                                </div> */ ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        


                    </div>

                </div>
            </div>
        </div>
       </section>
	   
	   <!-- Notification End -->
	   @if(Auth()->user()->gender=="female")
  <!-- winks start -->
    <section class="winks">
      <div class="loader" data-ng-if="loadingWinks">
        <div class="spinner">
          <img src="img/ring.gif" alt="loader" />
        </div>
      </div> 
      <div class="wrap" data-ng-if="winks.length > 0">
        <h1>{{ Lang::get('messages.gotAWink')}} <span><a href="/users/[[winks[0].username]]">[[winks[0].username]]</a></span> <span data-ng-if="winks.length - 1 > 0"> {{ Lang::get('messages.andAnother') }} [[winksTotalPage -1 ]] {{ Lang::get('messages.people') }}</span></h1>
        <div class="winks-grid block-flex wrap-flex">
          <div data-ng-repeat="user in winks" class="wink">
            <a href="/users/[[user.username]]">
              <div class="image">
                <div data-ng-hide="!user.online" class="online-indicator"></div>
                <img data-ng-src="[[getUserPhotoUrl(user)]]" alt="[[user.username]]" />
              </div> 
              <div class="name">
                <h3>[[user.username]]</h3>
              </div>
            </a>
          </div>
        </div>

        <paging
          class="small"
          page="winksPage" 
          page-size="perPage" 
          total="winksTotalPage"
          paging-action="changeWinksPage(page, pageSize, total)">
        </paging>
      </div>
      <div class="wrap" data-ng-if="winks.length == 0">
        <h1>{{ Lang::get('messages.noWinks') }}</h1>
      </div>
    </section>
	 @endif
	 @if(Auth()->user()->gender=="female")
	<!-- view profile start -->
    <section class="viewed wrap">
      <div class="browse-members visiting-members">
        <div class="loader" data-ng-if="loadingViews">
          <div class="spinner">
            <img src="img/ring.gif" alt="loader" />
          </div>
        </div>
        <h2 data-ng-if="views.length > 0">{{ Lang::get('messages.whoViewed') }}</h2>
        <div class="row" data-ng-if="views.length > 0">
          <div class="col-lg-3 col-md-3 col-xs-4" data-ng-repeat="user in views">
            <div class="member" >
              <div class="image">
                <div data-ng-hide="!user.online" class="online-indicator"></div>
                <a href="/users/[[user.username]]">
                  <img data-ng-src="[[getUserPhotoUrl(user)]]" alt="1" />
                </a>
              </div>
              <h4><a href="/users/[[user.username]]">[[user.username]]</a></h4>
              <span>{{ Lang::get('messages.visitedOn') }}</span>
              <p>[[formatViewDate(user.viewDate.date)]]</p>
              <a href="/users/[[user.username]]" class="profile-link">{{ Lang::get('messages.seeProfile') }} <i class="ion-arrow-right-c"></i></a>
            </div>
          </div>
        </div>
        <h2 data-ng-if="views.length == 0">{{ Lang::get('messages.noViews') }}</h2>

        <paging
          class="small"
          page="viewsPage" 
          page-size="perPage" 
          total="viewsTotalPage"
          paging-action="changeViewsPage(page, pageSize, total)">
        </paging>   
      </div>
    </section>
	<!-- view profile end -->
	 @endif
	
	@if(Auth()->user()->gender=="male")
  <!-- winks start -->
    <section class="winks">
      <div class="loader" data-ng-if="loadingWinks">
        <div class="spinner">
          <img src="img/ring.gif" alt="loader" />
        </div>
      </div> 
      <div class="wrap" data-ng-if="winks.length > 0">
        <h1>{{ Lang::get('messages.gotAWink')}} <span><a href="/users/[[winks[0].username]]">[[winks[0].username]]</a></span> <span data-ng-if="winks.length - 1 > 0"> {{ Lang::get('messages.andAnother') }} [[winksTotalPage -1 ]] {{ Lang::get('messages.people') }}</span></h1>
        <div class="winks-grid block-flex wrap-flex">
          <div data-ng-repeat="user in winks" class="wink">
            <a href="/users/[[user.username]]">
              <div class="image">
                <div data-ng-hide="!user.online" class="online-indicator"></div>
                <img data-ng-src="[[getUserPhotoUrl(user)]]" alt="[[user.username]]" />
              </div> 
              <div class="name">
                <h3>[[user.username]]</h3>
              </div>
            </a>
          </div>
        </div>

        <paging
          class="small"
          page="winksPage" 
          page-size="perPage" 
          total="winksTotalPage"
          paging-action="changeWinksPage(page, pageSize, total)">
        </paging>
      </div>
      <div class="wrap" data-ng-if="winks.length == 0">
        <h1>{{ Lang::get('messages.noWinks') }}</h1>
      </div>
    </section>
	 @endif
	 @if(Auth()->user()->gender=="male")
	<!-- view profile start -->
    <section class="viewed wrap">
      <div class="browse-members visiting-members">
        <div class="loader" data-ng-if="loadingViews">
          <div class="spinner">
            <img src="img/ring.gif" alt="loader" />
          </div>
        </div>
        <h2 data-ng-if="views.length > 0">{{ Lang::get('messages.whoViewed') }}</h2>
        <div class="row" data-ng-if="views.length > 0">
          <div class="col-lg-3 col-md-3 col-xs-4" data-ng-repeat="user in views">
            <div class="member" >
              <div class="image">
                <div data-ng-hide="!user.online" class="online-indicator"></div>
                <a href="/users/[[user.username]]">
                  <img data-ng-src="[[getUserPhotoUrl(user)]]" alt="1" />
                </a>
              </div>
              <h4><a href="/users/[[user.username]]">[[user.username]]</a></h4>
              <span>{{ Lang::get('messages.visitedOn') }}</span>
              <p>[[formatViewDate(user.viewDate.date)]]</p>
              <a href="/users/[[user.username]]" class="profile-link">{{ Lang::get('messages.seeProfile') }} <i class="ion-arrow-right-c"></i></a>
            </div>
          </div>
        </div>
        <h2 data-ng-if="views.length == 0">{{ Lang::get('messages.noViews') }}</h2>

        <paging
          class="small"
          page="viewsPage" 
          page-size="perPage" 
          total="viewsTotalPage"
          paging-action="changeViewsPage(page, pageSize, total)">
        </paging>   
      </div>
    </section>
	<!-- view profile end -->
	 @endif
	
  </div>

@endsection