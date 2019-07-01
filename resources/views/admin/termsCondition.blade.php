@extends('layouts.master')

@section('meta')
    <title>Terms and condition</title>
@endsection

@section('scripts')

@endsection

@section('content')
<script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
<div>
    <div ng-controller="PostController">
    <div ng-init='listPost();'>   
        <div class="container">
            <h1>Content Managment System</h1>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-primary btn-xs pull-right" ng-click="initAddPost()">Add CMS</button>
                    <h3 class="panel-title">All Post</h3>
                </div>
                <div class="panel-body">
                    
                    <table ng-if="posts.length > 0" class="table table-bordered table-responsive table-striped">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <tr ng-repeat='post in posts'>
                            <td>[[ $index+1 ]]</td>
                            <td>[[ post.title ]]</td>
                            <td>[[ post.description ]]</td>
                            <td>
                                <button ng-click ="edit($index)" class="btn btn-primary btn-xs">Edit</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Model -->
        <div class="modal fade" tabindex="-1" role="dialog" id="new_post">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create New Post</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" ng-model="post.name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Post Details:</label>
                            <textarea ck-editor ng-model="post.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" ng-click="publishPost()" class="btn btn-primary">Publish</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!--- Model -->
        <div class="modal fade" tabindex="-1" role="dialog" id="update_post">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Post</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="alert alert-danger" ng-if="errors.length > 0">
                            <li ng-repeat="error in errors">
                                [[ error ]]
                            </li>
                        </ul>   
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" ng-model="update_post.title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Post Details:</label>
                            <textarea ck-editor ng-model="update_post.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" ng-click="updatePost()" class="btn btn-primary">Publish Changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Modal -->

    </div>
    </div>
</div>
@endsection

