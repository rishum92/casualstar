@extends('layouts.master')

@section('meta')
  <title>CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content') 
<div data-ng-controller="CompitionController">
  <section class="main admin-main">
    <div class="wrap">
        <h3>Compitions</h3>
        <button ng-click="openModal('compition', '', '')" class="item-action btn btn-danger">Create Compition</button>
      <div class="table-responsive" ng-init="filterCompitions()">
        <table class="table">
          <thead> 
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Sub Title</th>
              <th>Expiry</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='compition in compitions' data-ng-if="compition.title"> 
              <td>[[compition.id]]</td>
              <td>[[compition.title]]</td>
              <td>[[compition.sub_title]]</td>
              <td>[[compition.expiry_date]]</td>
              <td>
              <button ng-click="openModal('compition', 'compition',compition)" class="btn btn-info">Edit</button>
              <a href="/admin/compition-users/[[compition.id]]" class="btn btn-danger">View Users </a>
              <button ng-click="deleteCompition(compition)" class="btn btn-info">Delete</button>  
              </td>
            </tr>
          </tbody>
        </table>
        <nav>
          <paging
          class="small pagination"
          page="pageUsers" 
          page-size="perPageUsers" 
          total="totalCompitions"
          paging-action="changePageCompitions(page, pageSize, total)">
          </paging>
        </nav>
      </div>
    </div>
    @include('modals.compition')
  </section>
</div>