<?php //echo "<pre>";print_r($competitionuser);die;?>
<ul class = "profil_ul" ng-controller="UserCompetitionController">
    <li ng-repeat="users in competition_user.data">
        @if(Auth::user())
                <div class="wrap_profile">
                    <div class="img-pro" lightgallery data-src="[[getPhotoUrl(users.user_profile)]]">
                        <a href="[[getPhotoUrl(users.user_profile)]]" class="lightGallery">
                            <img ng-if="[[getPhotoPreviewUrl(users.user_profile != '')]]" data-ng-src="[[getPhotoPreviewUrl(users.user_profile)]]"/>
                        </a>
                    </div>
                    <div class="profile_content">
                        <h1>
                            <a href="/users/[[users.username]]">
                                [[users.username]]
                            </a>
                        </h1>
                        <p>   
                            44 - High Wycombe, Bucking-hamshire
                        </p>
                        <div class="like_block">
                            <i class="fa fa-heart"></i> 
                            [[users.total_votes]]
                        </div>
                        <div class="wrap_btn">
                            @include('modals.vote_popup')
                            <button class="page_btn" type="button" data-ng-click="openModal('vote_popup')">
                                <i class="fa fa-heart"></i> Vote Me
                            </button>
                            @include('modals.commentcompetition')
                            <button ng-controller = "CommentController" ng-click="viewThisPhoto([[users.user_id]])" class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                            </button>
                        </div>
                        @if(Auth::user()->username == 'Admin') 
                            <div class = "delete_icon_div">
                                <i ng-click = "deleteconfirmation ([[users.competition_id]])" class = "fa fa-trash delete_icon_style"></i>
                            </div> 
                        @endif
                    </div>
                </div>
            @else
                <div class="wrap_profile" onclick = 'newwin()'>
                    <div class="img-pro">
                        <img data-ng-src="[[getPhotoUrl(users.user_profile)]]"><br/>
                    </div>
                    <div class="profile_content">
                        <h1>
                            <a>
                                [[users.username]]
                            </a>
                        </h1>
                        <p>
                            44 - High Wycombe, Bucking-hamshire
                        </p>
                        <div class="like_block"><i class="fa fa-heart"></i> 
                            [[users.total_votes]]
                        </div>
                        <div class="wrap_btn">
                            <button class="page_btn" type="button">
                                <i class="fa fa-heart"></i> Vote Me
                            </button>
                            <button class="page_btn" type="button">
                                <i class="fa fa-comments"></i> Comments
                            </button>
                        </div> 
                    </div>
                </div>
            @endif
    </li>   
</ul>
<div>
    {{$competitionuser->links()}}
</div>
