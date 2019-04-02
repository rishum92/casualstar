<ul class="profil_ul">
  @if(empty($competitonsetitionuser)) 
  <div style = "font-size: 30px;text-align:center;">
      There is currently no active competition.
  </div><br><br>
  @else
  <?php //echo"<pre>"; print_r($user); //die; ?>
    <li ng-repeat="competitons in competitonsetition_users">
      [[competitons]]
      @if(!Auth::user())
        <div class="wrap_profile" onclick = 'newwin()' >
          <div class="img-pro">
            <img src="{{ URL::asset('img/competitonsetition_user/'.$user->username.'/previews/'.$user->user_profile)}}"><br/>
          </div>
          <div class="profile_content">
            <h1><a> [[competitons.username]]</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
              <div class="like_block"><i class="fa fa-heart"></i> 
                [[competitons.total_votes]]
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
       @else
        <div> 
          <div class="wrap_profile">
            <div ng-if ="([[competitons.total_votes]] >= 100)">
              <div class="first_place">
                1<sup>st</sup>
              </div>
              @if(Auth::user()->username == 'Admin')
                <div class = "first_place_amount">
                  <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "{{$user->user_id}}">
                  <input type ="text" value ="Wins:$100" id = "firstplace_amount"  class="edit_amount">
                </div>
            </div>
              @else
                <div class = "first_place_amount">
                  <input type ="text" value ="Wins:$100" class="edit_amount" readonly>
              @endif
              <div ng-if ="([[competitons.total_votes]] >= 75)">
                <div class = "second_place">
                  2<sup>nd</sup>
                </div>
                <div class="second_place_amount">
                  <input type ="text" value ="Wins:$50" class="edit_amount" readonly>
                </div>
              </div>
             <div ng-if ="([[competitons.total_votes]] >= 50)">
                <div class="third_place">
                  3<sup>rd</sup>
                </div>
                <div class ="third_place_amount">
                  <input type ="text" value ="Wins:$25" class="edit_amount" readonly>
                </div>
              </div>
              <div class="img-pro">
                <img onclick = 'imagemodal([[competitons.user_id]])' src="{{ URL::asset('img/competitonsetition_user/'.[[competitons.username]].'/previews/'.[[competitons.user_profile]])}}">
                <br/>
              </div>
                <div class="profile_content">
                  <h1>
                    <a href="/users/[[competitons.username]]">
                      [[competitons.username]]
                    </a>
                  </h1>
                  <p>44 - High Wycombe, Bucking-hamshire
                  </p>
                  <div class="like_block">
                    <i class="fa fa-heart"></i>
                      [[competitons.total_votes]]
                  </div>
                  <div class="wrap_btn">
                   
                    <button class="page_btn" type="button" onclick="confirm_vote_popup([[competitons.competitonsetition_id]],[[competitons.user_id]])">
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                      <button class="page_btn" type="button" disabled>
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                    @include('modals.commentcompetitonsetition')
                      <button data-ng-click="viewThisPhoto({{$user->user_id}})"
                      class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                      </button>
                  </div>
                  <div ng-if = "[[competitons.user_id]] == Auth::user()->id || Auth::user()->username == 'Admin')">
                    <div>
                      <input type="hidden" name="hidden_username" id = "hidden_username" value = "{{$user->username}}"> 
                      <i onclick = "deleteconfirmation({{$user->competitonsetition_id}})" class = "fa fa-trash onclicktext"></i>
                    </div>
                  
                  </div>
              </div>
            @endif
    </li>

  @endif
</ul>
