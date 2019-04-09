<ul class = "profil_ul" ng-controller="UserCompetitionController">
  <span ng-repeat="users in competition_user">
    <li ng-repeat="comp in users">
      @if(Auth::user())
       <div class="wrap_profile">
          <div class="img-pro" lightgallery data-src="[[getPhotoUrl(comp.user_profile)]]">
            <a href="[[getPhotoUrl(comp.user_profile)]]" class="lightGallery">
              <img ng-if="[[getPhotoPreviewUrl(comp.user_profile != '')]]" data-ng-src="[[getPhotoPreviewUrl(comp.user_profile)]]"/>
            </a>
          </div>
          <div class="profile_content">
            <h1>
              <a href="/users/[[comp.username]]">
                [[comp.username]]
              </a>
            </h1>
            <p>   
              44 - High Wycombe, Bucking-hamshire
            </p>
            <div class="like_block">
              <i class="fa fa-heart"></i> 
                [[comp.total_votes]]
            </div>
            <div class="wrap_btn">
              @include('modals.vote_popup')
              <button class="page_btn" type="button" ng-click ="openModal('vote_popup')">
                <i class="fa fa-heart"></i> Vote Me
              </button>
              @include('modals.commentcompetition')
              <button ng-controller = "CommentController" ng-click="viewThisPhoto([[comp.user_profile]])"
              class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
              </button>
            </div>
            @if(Auth::user()->username == 'Admin') 
              <i ng-click = "deleteconfirmation([[comp.competition_id]])" style="float:right; color:#d61857;" class = "fa fa-trash"></i>
            @endif 
          </div>
        </div>
      @else
        <div class="wrap_profile" onclick = 'newwin()'>
          <div class="img-pro">
            <img data-ng-src="[[getPhotoUrl(comp.user_profile)]]"><br/>
          </div>
          <div class="profile_content">
            <h1>
              <a>[[comp.username]]</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block"><i class="fa fa-heart"></i> 
              [[comp.total_votes]]
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
  </span>
</ul>
<div>
{{$competitionuser->links()}}
</div>