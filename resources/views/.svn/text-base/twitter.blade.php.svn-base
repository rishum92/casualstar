@extends('layouts.master')

@section('meta')
  <title>Auto-Tweet » CasualStar</title>
@endsection

<!--<!DOCTYPE html>
<html>
<head>
	<title>Laravel 5 - Twitter API</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>-->
@section('content')
<div data-ng-controller="ProfileController" class="container"> 
<section class="row myclass" data-ng-if="userLoaded" style="background-image:url([[getCoverPhotoUrl(user.cover)]])">
    @if($reg_twit == 1)
	<div class="row service-row text-center">
		<h3 class="text-danger">Sync now to start promoting on your Twitter</h3>
	<br>	<b style="color:#0084b4; font-size:14px;" >Automatically let your Twitter followers know whenever you receive a new tribute or a new subscription to your Private Galley.<br/>This will help to promote your profile to a wider audience, and also generate you more tributes.</b>
	<br><br></div> 
	
	<div class="row service-row text-primary text-center">
		<!--<a href="{{ URL::route('auth.loginTwit', 'twitter') }}"><button class="main-btn stroke-btn">{{ Lang::get('messages.loginTwt') }}</button></a>-->
		<a href="{{ URL::route('auth.loginTwit', 'twitter') }}"><button class="main-btn stroke-btn">Sync with Twitter</button></a>
	</div>
	@endif
	@if($post_twit == 1)
	<div class="row service-row text-primary text-center">
		<h1 class="">Post Tweet</h2>
		<fieldset>
		<form method="POST" role="form" class="form-horizontal bordered" action="{{ route('post.tweet') }}" enctype="multipart/form-data">
		<input type="hidden" name="uid" value="[[user.id]]" />

			{{ csrf_field() }}

			@if(count($errors))
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.
					<br/>
					<ul>
						@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div class="form-group">
				
				<div class="col-sm-10">
					<textarea class="form-control" placeholder="Enter Text Less Than 140 Characters" name="tweet" id="tweet_post" maxlength="140" style="resize:none;"></textarea>
				</div>
			</div>
			<!--<div class="form-group">
				<label class="control-label col-sm-2" for="tweet_images">Multiple Images:</label>
				<div class="col-sm-10">
					<input type="file" name="images[]" placeholder="Multiple Images" multiple class="form-control" id="tweet_images" />
				</div>
			</div>-->
			<div class="form-group text-center">
				<button class="btn btn-info"><span class="glyphicon glyphicon-pushpin"></span> Post</button>
			</div>
		</fieldset>
	</div>
	<div class="clearfix"></div>
  <section class="main admin-main" ng-if="user.gender=='female'">
   <div class="row service-list" id="service-list" style="margin-right: 0px;margin-left: 0px;">
            <div class="col-md-12">
                <button class="options-toggle service-list-header "> Auto tweet Settings <i class="ion-arrow-down-b"></i></button>

            </div>
            <div class="col-md-12">
                <div class=" service-list-inner">
                    <div class="col-md-1"></div>
                    <div class="box col-md-12 ">
                        <div class="box-body">
							<div class="row _custom_service_box_color">
							
								<div class="col-md-3 _custom_service_row">
										 Functions
								</div>
								<div class="col-md-3 _custom_service_row" >
										  Enable/Disable
								</div>
								<div class="col-md-3 _custom_service_row" >
										  Limits Per Day
								</div>
								<div class="col-md-3 _custom_service_row">
										  Save
								</div>
							</div>
							<div class="row _custom_service_box_color">
								<div class="col-md-3 _custom_service_row">New Tribute Received Tweet</div>
								<div class="col-md-3 _custom_service_row">
									<button ng-if="user.twit_enable==false" mwl-confirm="" title="{{ Lang::get('Enable Auto Tweet For New Tribute Received?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwit(user, 'TR', 1)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-success text-center">Click To Enable</button>
					
									<button ng-if="user.twit_enable==true" mwl-confirm="" title="{{ Lang::get('Disable Auto Tweet For New Tribute Received?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwit(user, 'TR', 0)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-danger text-center">Click To Disable</button>
								</div>
								<div class="col-md-3 _custom_service_row">
									<select class="form-control " name="twit_limit_save">
										<option ng-selected="user.twit_limit==-1" value="-1" >No Limit</option>
										<option ng-selected="user.twit_limit==20" value="20">20</option>
										<option ng-selected="user.twit_limit==16" value="16">16</option>
										<option ng-selected="user.twit_limit==12" value="12">12</option>
										<option ng-selected="user.twit_limit==8" value="8">8</option>
									</select>
								</div>
								<div class="col-md-3 _custom_service_row">
									<button mwl-confirm="" title="{{ Lang::get('Set Limit For New Subscription to Private Gallery?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwitLimit(user,'PG')" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-success text-center"><span>Save</span></button>
								</div>
								
							</div>
							<div class="row _custom_service_box_color">
								<div class="col-md-3 _custom_service_row">New Subscription to Private Gallery Tweet</div>
								<div class="col-md-3 _custom_service_row">
									<button ng-if="user.twit_private_enable==false" mwl-confirm="" title="{{ Lang::get('Enable Auto Tweet For New Subscription To Private Gallery?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwit(user, 'PG', 1)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-success text-center">Click To Enable</button>
					
									<button ng-if="user.twit_private_enable==true" mwl-confirm="" title="{{ Lang::get('Disable Auto Tweet For New Subscription To Private Gallery?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwit(user, 'PG', 0)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-danger text-center">Click To Disable</button>
								</div>
								<div class="col-md-3 _custom_service_row">
									<select class="form-control " name="twit_pvt_limit_save">
										<option ng-selected="user.twit_private_limit==-1" value="-1" >No Limit</option>
										<option ng-selected="user.twit_private_limit==20" value="20">20</option>
										<option ng-selected="user.twit_private_limit==16" value="16">16</option>
										<option ng-selected="user.twit_private_limit==12" value="12">12</option>
										<option ng-selected="user.twit_private_limit==8" value="8">8</option>
									</select>
								</div>
								<div class="col-md-3 _custom_service_row">
									<button mwl-confirm="" title="{{ Lang::get('Set Limit For New Subscription to Private Gallery?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="enableTwitLimit(user,'PG')" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-success text-center"><span>Save</span></button>
								</div>
								
							</div>
                            <!-- /.box-body -->
						</div>
                        


                    </div>
				
                </div>
            </div>
        </div>
  </section>
  @endif
  </section>
</div>
@endsection
<!--</body>
</html>-->