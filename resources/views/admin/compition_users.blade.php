@extends('layouts.master')

@section('meta')
  <title>CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content') 
<div data-ng-controller="CompitionuserController">
  <section class="main admin-main">
    <div class="wrap">
        <h3>Users</h3>
      <div class="table-responsive" ng-init="filterCompititionUsers()">
            <input type="checkbox" ng-change="filterCompititionUsers()" data-ng-model="genderMale" name="gender" id="male" value="male">
            <label for="male"><i class="ion-male"></i> Male</label>
            <input type="checkbox" ng-change="filterCompititionUsers()" data-ng-model="genderFemale" name="gender" id="female" value="female">
            <label for="female"><i class="ion-female"></i> Female</label>
            <input type="text" class="form-control admin-search" ng-change="filterCompititionUsers()" ng-model-options="{ updateOn: 'default blur', debounce: {'default': 500, 'blur': 0} }" ng-model="searchUsers" placeholder="Search for users">
        <table class="table">
          <thead> 
            <tr>
              <th>Username</th>
              <th>E-mail</th>
              <th>Gender</th>
              <th>Created At</th>
              <th>No of votes</th>
              <th>No of Comments</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='Cuser in compitionusers' data-ng-if="user.username">
                
              <td><a href="/users/[[Cuser.username]]"><i data-ng-show="user.title == 'ADMIN'" class="fa fa-key"></i><i data-ng-if="Cuser.status == 0" class="fa fa-close"></i> [[Cuser.username]] </a></td>
              <td>[[Cuser.email]]</td>
              <td>[[Cuser.gender]]</td>
              <td>[[formatDate(Cuser.created_at)]]</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <nav>
          <paging
          class="small pagination"
          page="pageCompitionUsers" 
          page-size="perCompitionUsers" 
          total="totalUsers"
          paging-action="changePageUsers(page, pageSize, total)">
          </paging>
        </nav>
      </div>
    </div>
    @include('modals.emailUser')
  </section>
</div>