<ul class="profil_ul">
@if(empty($competitionuser)) 
  <div style = "font-size:30px;text-align:center;">
    There is currently no active competition.
  </div><br><br>

@else
@foreach($competitionuser as $user)
  <?php //echo"<pre>"; print_r($user); //die; ?>
    <li>
      @if(!Auth::user())
        <div class="wrap_profile" onclick = 'newwin()'>
          <div class="img-pro">
            <img src="{{ URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)}}"><br/>
          </div>
          <div class="profile_content">
            <h1>
              <a> {{$user->username}}</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block"><i class="fa fa-heart"></i> 
              {{$user->total_votes}}
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
      <div ng-controller = "UserCompetitionController">
        <div class="wrap_profile">
          @if($user->total_votes >= 100)
          <div class="first_place">
            1<sup>st</sup>
          </div>
          @if(Auth::user()->username == 'Admin')
          <div class = "first_place_amount">
            <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "{{$user->user_id}}">
            <input type ="text" value ="Wins:$100" id = "firstplace_amount"  class="edit_amount">
          </div>
          @else
          <div class = "first_place_amount">
            <input type ="text" value ="Wins:$100" class="edit_amount" readonly = "true">
          </div>
          @endif
          @elseif($user->total_votes >= 75)
          <div class = "second_place">
            2<sup>nd</sup>
          </div>
          <div class="second_place_amount">
            <input type ="text" value ="Wins:$50" class="edit_amount" readonly = "true">
          </div>
          @elseif($user->total_votes >= 50)
          <div class="third_place">
            3<sup>rd</sup>
          </div>
          <div class ="third_place_amount">
            <input type ="text" value ="Wins:$25" class="edit_amount" readonly = "true">
          </div>
          @elseif($user->total_votes >= 3)
          @for($i =4; $i <= 10; $i++)
               <!-- <div class = "fourth_place">
                  #{{$i}}
                </div> -->
          @endfor
          @endif
          <?php //echo '<pre>';print_r($user);//exit;?>
          <div class="img-pro">
            <img  onclick = 'imagemodal({{$user->user_id}})' src="{{ URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)}}">
            <br/>
          </div>
          <div class="profile_content">
            <h1>
              <a href = "{{(url('users/'.$user->username))}}">
                {{$user->username}}
              </a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block">
              <i class="fa fa-heart"></i>
                {{$user->total_votes}}
            </div>
            <div class="wrap_btn">
            <?php //echo '<pre>';print_r($voter_count);?>
              @if($voter_count < 2 || !in_array ($user->user_id, $voter_count) && Auth::user()->id != $user->user_id || Auth::user()->username == 'Admin' && date('d/m/Y') != $showdate)
                <button class="page_btn" type="button" onclick="confirm_vote_popup({{$user->competition_id}},{{$user->user_id}})">
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              @else
                <button class="page_btn" type="button" disabled>
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              @endif
              @include('modals.commentcompetition')
              <button onclick = "profilecomment({{$user->user_id}})"
                class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
              </button>
            </div>
            <div class="comment_count">
              {{$user->total_comment}}
            </div>
            @if($user->user_id == Auth::user()->id || Auth::user()->username == 'Admin') 
              <div>
                <i onclick = "deleteconfirmation({{$user->competition_id}})" class = "fa fa-trash trash_btn"></i>
              </div>
            @endif 
          </div>
        </div>
      </div>
    @endif
  </li>
  @endforeach
  @endif
</ul>
<div>
  {{ $competitionuser->links() }}
</div>