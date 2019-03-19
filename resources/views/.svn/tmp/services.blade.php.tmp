@extends('layouts.master') @section('meta')
<title>Services » CasualStar</title>
@endsection @section('content')
<script>
    var currency_code = "<?php echo Auth()->user()->currency_code; ?>";

</script>
<div data-ng-controller="ServiceController" class="service-container">
    <div class="loader" data-ng-if="loadingWinks" style="position: fixed;">
        <div class="spinner">
            <img src="img/ring.gif" alt="loader" />
        </div>
    </div>
    <div class="profile-gallery " style="background:#fff">
        <h2>Services</h2>

        <!-- Female only -->
        <!-- ngIf: user.gender == 'female' && user.photos.length == 0 -->

        <!-- Male only -->
        <!-- ngIf: user.gender == 'male' && user.photos.length == 0 -->

        <div class="add-gallery-photo" style="padding: 10px 0; background:rgba(214, 24, 87, 1);">
            <div class="row">
                <div class="col-md-2 ">
                </div>
                <div class="col-md-8 text-center">
                    <div class="form-group">
		<label style="color: #FFF;font-size: 18px;"><strong>*</strong>Select the currency you accept</label>
		<select name="currency_code" ng-model="currency_code" class="form-control" data-ng-change="updateUserCurrency()">
		  <option value="">--Select--</option>
		  <option ng-repeat="currency in currencyList" value="[[currency.code]]">[[currency.name]]([[currency.code]])</option>
		</select>
                    </div>
                </div>
            </div>


        </div>

        <div class="row service-list ">
            <div class="col-md-12">
                <button class="options-toggle service-list-header" ng-click="toggleServiceList()">Services to Offer  <i class="ion-arrow-down-b"></i></button>

            </div>
            <div class="col-md-12">
                <div class="service-list-inner" id="ServiceList">
                    <div class="col-md-1"></div>
                    <div class="box col-md-12 ">

                        <div class="box-bodyServices">
							<div class="row  _custom_service_box_color" ng-repeat="service in serviceList">
							<div class="row" ng-if="service.user_id==1">
                                <div class="col-md-3" style="padding:12px;font-size:17px ">

                                    [[service.service_name]]

                                </div>
                                <div class="col-md-2" style="padding-top:1px" ng-init="parseId(service)">
                                    <input type="number" ng-model="service.amount" class="form-control " placeholder="service fee" style="display:inline-block" ng-disabled="service.negotiate&&service.negotiate!='false'" ng-change="parseId(service)">
                                </div>
                                <div class="col-md-2" style="padding-top:1px">
                                    <select name="variable" ng-model="service.variable_name" class="form-control " >
		  <option value="">--Select--</option>
                         <option value="[[variable.variable_name]]" ng-repeat="variable in service.variable_list">[[variable.variable_name]]</option>
                        
                    </select>
                                </div>
                                <div class="col-md-2" style="padding-top:10px">
                                    <input type="checkbox" ng-model="service.negotiate" ng-disabled="service.amount" ng-init="service.negotiate=(service.negotiate == 'true')" style="display:inline-block;">&nbsp;&nbsp;Negotiate
                                </div>
                                <div class="col-md-3" style="padding-top:3px">
                                    <button ng-if="!service.usId" class="btn btn-info btn-sm" ng-click="addService(service)"><span class="glyphicon glyphicon-plus"></span>Add</button>
                                    <button ng-if="service.usId" class="btn btn-success btn-sm" ng-click="addService(service)"><span class="glyphicon glyphicon-ok"></span> Update</button>
                                    <button ng-if="service.usId" ng-click="removeService(service.usId,service.id)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Remove</button>
                                </div>
							</div>
							 @if(Auth()->user()->id != 1) 
							<div class="row" ng-if="service.user_id!=1 && service.user_id == {{Auth()->user()->id}}">
							<div class="col-md-3" style="padding:12px;font-size:17px ">

                                    [[service.service_name]]

                                </div>
                                <div class="col-md-2" style="padding-top:1px" ng-init="parseId(service)">
                                    <input type="number" ng-model="service.amount" class="form-control " placeholder="service fee" style="display:inline-block" ng-disabled="service.negotiate&&service.negotiate!='false'" ng-change="parseId(service)">
                                </div>
                                <div class="col-md-2" style="padding-top:1px">
                                    <select name="variable" ng-model="service.variable_name" class="form-control " >
		  <option value="">--Select--</option>
                         <option value="[[variable.variable_name]]" ng-repeat="variable in service.variable_list">[[variable.variable_name]]</option>
                        
                    </select>
                                </div>
                                <div class="col-md-2" style="padding-top:10px">
                                    <input type="checkbox" ng-model="service.negotiate" ng-disabled="service.amount" ng-init="service.negotiate=(service.negotiate == 'true')" style="display:inline-block;">&nbsp;&nbsp;Negotiate
                                </div>
                                <div class="col-md-3" style="padding-top:3px">
                                    <button ng-if="!service.usId" class="btn btn-info btn-sm" ng-click="addService(service)"><span class="glyphicon glyphicon-plus"></span>Add</button>
                                    <button ng-if="!service.usId" class="btn btn-warning btn-sm" ng-click="selectProduct_id(service)"><span class="glyphicon glyphicon-edit"></span>Edit</button>
                                    <button ng-if="!service.usId" class="btn btn-danger btn-sm" ng-click="selectProduct_id_del(service)"><span class="glyphicon glyphicon-remove"></span>Delete</button>
                                    <button ng-if="service.usId" class="btn btn-success btn-sm" ng-click="addService(service)"><span class="glyphicon glyphicon-ok"></span> Update</button>
                                    <button ng-if="service.usId" ng-click="removeService(service.usId,service.id)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Remove</button>
                                </div>
							</div>
							@endif
                            </div>
							@if(Auth()->user()->id != 1)
							<!--<div class="row  _custom_service_box_color" ng-show="[[getCountByUser({{Auth()->user()->id}})]]">-->
							<div class="row  _custom_service_box_color" ng-if="serviceList.length < 15">
								<button class="btn btn-info" ng-click="selectProduct()" ><span class="glyphicon glyphicon-plus"></span>Add New Services</button>
							</div>
							<div class="modal fade" tabindex="-1" role="dialog" id="product-detail">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" ng-bind="terms.heading">Add New Service Module</h4>
									</div>
									<div class="modal-body">
									<form class="form-horizontal" method="POST" >
									{{ csrf_field() }}
										<div class="form-group">
											<label class="col-sm-3 control-label">Service Name:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" ng-model="add_service_name" placeholder="Service Name" maxlength="16" />
											</div>
											<span class="text-danger text-left col-sm-12 col-sm-offset-3">
												<strong id="add_service_name-error"></strong>
											</span>
										</div>
										<div class="form-group" ng-show="false">
											<label class="col-sm-3 control-label">Fee amount:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" ng-model="add_fee_amount" valid-number maxlength="6" placeholder="Fee Amount"/>
											</div>
											<span class="text-danger text-left col-sm-12 col-sm-offset-3">
												<strong id="add_fee_amount-error"></strong>
											</span>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Variable:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" ng-model="add_variable" placeholder="Variable Name" maxlength="16" />
											</div>
											<span class="text-danger text-left col-sm-12 col-sm-offset-3">
												<strong id="add_variable-error"></strong>
											</span>
										</div>											
									</form>

									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary btn-sm" ng-if="terms.label == 'Save'" ng-bind="terms.label" ng-click="orderItem()">Save</button>
										<button type="submit" class="btn btn-primary btn-sm" ng-if="terms.label == 'Update'" ng-bind="terms.label" ng-click="orderItem_update()"></button>
										<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							@endif






                            <!-- /.box-body -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row service-list" id="service-list">
            <div class="col-md-12">
                <button class="options-toggle service-list-header " ng-click="toggleRequestServiceList()"> All Service Requests <i class="ion-arrow-down-b"></i></button>
                
<h3><p style='color: red; font '>Always receive PAYMENT FIRST, before completing any request for content or Services.<a href="https://www.casualstar.uk/faq">  Payment - How it Works.</center></a></div>
        <hr> </p></h3><br>
            <div class="col-md-12">
                <div class=" service-list-inner" id="RequestServiceList">
                    <div class="col-md-1"></div>
                    <div class="box col-md-12 ">
                        <div class="box-body">

						
                            <div class="row _custom_service_box_color" ng-if="requestedServiceList.length<1">
                                <div class="col-md-12" style="padding:12px;font-size:17px">
                                    No Requested Service Found
                                </div>
                            </div>
                            <div class="row _custom_service_box_color" ng-repeat="re_service in requestedServiceList" ng-if="requestedServiceList.length>0">
                                <div class="col-md-2" style="padding:12px;font-size:16px;">
                                    <a href="/users/[[re_service.user.username]]">
                              [[re_service.user.username]]
                                </a>

                                </div>
                                <div class="col-md-3 _custom_service_row">

                                    [[re_service.service_name]]<span ng-if="re_service.service_name=='Private Gallery Access'">--[[re_service.variable_name]]</span><span ng-if="re_service.service_name!='Private Gallery Access'">/ [[re_service.variable_name]]</span>
                                    <span ng-if="re_service.negotiate=='true'">/ Negotiate </span><span ng-if="re_service.negotiate=='false'">/ [[re_service.amount]] [[currency_code]]</span>

                                </div>
                                <div class="col-md-1 _custom_service_row">

                                    [[ re_service.created_at_human ]]

                                </div>
                                <div class="col-md-2 _custom_service_row">
                                    <span ng-if="re_service.status=='PENDING'" style="color:orange">Pending</span>
                                    <span ng-if="re_service.status=='COMPLETED'" style="color:blue"><span ng-if="re_service.service_name=='Private Gallery Access'">Granted</span><span ng-if="re_service.service_name!='Private Gallery Access'">Completed</span></span>
                                     <span ng-if="re_service.status=='EXPIRED'" style="color:orange">Expired</span>
                                </div>
                                <div class="col-md-4" style="padding-top:3px">
                                    <button ng-if="re_service.status=='PENDING'" class="btn btn-info btn-sm" ng-click="changeServiceRequestStatus(re_service.id,1)"><span class="glyphicon glyphicon-ok"></span> <span ng-if="re_service.service_name=='Private Gallery Access'">Give access</span><span ng-if="re_service.service_name!='Private Gallery Access'">Completed</span></button>
                                    <a  href="messages/[[re_service.user.username]]"> <button class="btn btn-success btn-sm" ng-click="addService(re_service)"><span class="glyphicon glyphicon-envelope"></span> Message </button>
                                    </a>
                                    <button ng-if="re_service.status=='PENDING'" ng-click="changeServiceRequestStatus(re_service.id,2)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Deny </button>
                                     <button ng-if="re_service.status=='COMPLETED'&&re_service.service_name!='Private Gallery Access'" ng-click="changeServiceRequestStatus(re_service.id,3)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                     <button ng-if="re_service.status=='EXPIRED'&&re_service.service_name=='Private Gallery Access'" ng-click="changeServiceRequestStatus(re_service.id,3)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        


                    </div>
				
                </div>
            </div>
			<div class="col-md-12">
				<nav>
					<paging
					class="small pagination"
					page="pageBrowse" 
					page-size="perPageBrowse" 
					total="totalBrowse"
					paging-action="changePage(page, pageSize, total)">
					</paging>
				</nav>
			</div>
        </div>



    </div>
</div>

@endsection
