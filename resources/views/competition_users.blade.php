<ul class="profil_ul">
@if($competitionuser->isEmpty())
  <div class = "no_competition_found">
    There is currently no active competition.
  </div><br><br>
@else
<?php $vote_rank = 0; $temp_vote = 0; ?>
@foreach($competitionuser as $user)
   <?php //echo '<pre>';print_r($user);die;?>
    <li>
      @if(!Auth::user())
        <div class="wrap_profile" onclick = 'newwin()'>
            <?php if($temp_vote != $user->total_votes)
                {
                    $vote_rank++;
                    $temp_vote = $user->total_votes;
                }
            ?>  

              <?php if($vote_rank == 1){ ?>
                      <div class="first_place"><?php echo $vote_rank; ?><sup>st</sup></div>
                      <div class = "first_place_amount">
                        Wins:$<input type ="text" value ="{{$user->vote_prize->vote_amount}}" class="edit_amount" readonly = "true">
                      </div>
                        <?php }
                   else if($vote_rank == 2){ ?>
                      <div class = "second_place"><?php echo $vote_rank; ?><sup>nd</sup></div>
                      <div class="second_place_amount">
                        Wins:$<input type ="text" value ="50" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else if($vote_rank == 3){ ?>
                      <div class = "third_place"><?php echo $vote_rank; ?><sup>rd</sup></div>
                      <div class="third_place_amount">
                        Wins:$<input type ="text" value ="25" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else{ ?>
                        <div class = "fourth_place">
                          <?php echo "#".$vote_rank; ?>
                        </div> 
                <?php } ?>
          <div class="img-pro">
            <img src="{{ URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)}}"><br/>
          </div>
          <div class="profile_content">
            <h1>
              <a> {{$user->username}}</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block" >
              <div id="increase_vote_{{$user->user_id}}"><i class="fa fa-heart"></i>{{ $user->total_votes }}</div>
              <div id="increase_vote_ajax_{{$user->user_id}}" style="display:none;"><i class="fa fa-heart"></i></div>
            </div>
            <div class="wrap_btn">
              <button class="page_btn" type="button">
                <i class="fa fa-heart"></i> Vote Me
              </button>
              <button class="page_btn" type="button">
                <i class="fa fa-comments"></i> Comments
              </button>
            </div>
            <div class="comment_count">
              {{$user->total_comment}}
            </div>
            <div>
             <i onclick = "deleteconfirmation({{$user->competition_id}})" class = "fa fa-trash trash_btn"></i>
            </div>
          </div>
        </div>
      @else
      <div ng-controller = "UserCompetitionController">
        <div class="wrap_profile">
                <?php if($temp_vote != $user->total_votes)
                {
                    $vote_rank++;
                    $temp_vote = $user->total_votes;
                }
        ?>  

              <?php if($vote_rank == 1){ ?>
                      <div class="first_place"><?php echo $vote_rank; ?><sup>st</sup></div>
                      @if(Auth::user()->username == 'Admin')
                      <div class = "first_place_amount" id="first_place_amount">
                        <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "{{$user->user_id}}">
                            Wins:$<input type ="text" value ="{{$user->vote_prize->vote_amount}}" onblur="firstplace_amount_fun({{$user->user_id}})" id = "firstplace_amount_{{$user->user_id}}"  class="edit_amount">
                      </div>
                      <!-- <div class = "first_place_amount" id="firstplace_amount_ajax_{{$user->user_id}}" style="display:none;">
                      </div> -->
                      @else
                      <div class = "first_place_amount">
                        Wins:$<input type ="text" value ="{{$user->vote_prize->vote_amount}}" class="edit_amount" readonly = "true">
                      </div>
                      @endif
                        <?php }
                   else if($vote_rank == 2){ ?>
                      <div class = "second_place"><?php echo $vote_rank; ?><sup>nd</sup></div>
                      <div class="second_place_amount">
                        Wins:$<input type ="text" value ="50" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else if($vote_rank == 3){ ?>
                      <div class = "third_place"><?php echo $vote_rank; ?><sup>rd</sup></div>
                      <div class="third_place_amount">
                        Wins:$<input type ="text" value ="25" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else{ ?>
                        <div class = "fourth_place">
                          <?php echo "#".$vote_rank; ?>
                        </div> 
                <?php } ?>
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
            <div class="like_block" >
              <div id="increase_vote_{{$user->user_id}}"><i class="fa fa-heart"></i>{{ $user->total_votes }}</div>
              <div id="increase_vote_ajax_{{$user->user_id}}" style="display:none;"><i class="fa fa-heart"></i></div>
            </div>
            <div class="wrap_btn">
              @if($total_voters_count < 3 && !in_array ($user->user_id, $voter_count) && Auth::user()->id != $user->user_id || Auth::user()->username == 'Admin' && date('d/m/Y') != $showdate)
                <button class="page_btn" type="button" onclick="confirm_vote_popup({{$user->competition_id}},{{$user->user_id}},'{{$user->username}}')">
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              @else
                <button class="page_btn" type="button" disabled>
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              @endif
              
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