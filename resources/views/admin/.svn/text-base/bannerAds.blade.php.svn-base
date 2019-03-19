@extends('layouts.master')

@section('meta')
    <title>CasualStar Admin: Banner ads</title>
@endsection

@section('scripts')

@endsection

@section('content')
<div data-ng-controller="AdminBannerAdsController">
    <section class="main admin-main banner-ads">
        <div class="wrap">
            <div class="description">
                <h1>Admin: Banner ads</h1>
                <h3>Active banner ads: <b>[[totalActiveBannerAdRequests]]</b></h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Type</th>
                        <th>Days</th>
                        <th>Date live</th>
                        <th>Extra promotions</th>
                        <th>Created</th>
                        <th>Notes</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat='bannerAdRequest in activeBannerAdRequests'>
                        <td>[[bannerAdRequest.user.username]]</td>
                        <td>[[bannerAdRequest.user.email]]</td>
                        <td>[[bannerAdRequest.type]]</td>
                        <td>[[bannerAdRequest.banner_ads.length]]</td>
                        <td>[[bannerAdRequest.banner_ads[0].day]]</td>
                        <td>
                            <i class="fa fa-check" ng-if="bannerAdRequest.extra_promotions == 1"></i>
                            <i class="fa fa-close" ng-if="bannerAdRequest.extra_promotions == 0"></i>
                        </td>
                        <td>[[formatDate(bannerAdRequest.created_at)]]</td>
                        <td class="center-column"><textarea class="banner-ad-request-admin-notes" ng-model="bannerAdRequest.notes" ng-keyup="updateNotes(bannerAdRequest)" ng-model-options="{updateOn: 'blur'}" placeholder="Notes"></textarea></td>
                        <td>
                            <button type="button" class="item-action" ng-click="openBannerAdRequestModal(bannerAdRequest)"><i class="fa fa-eye"></i></button>
                            {{--<button type="button" class="item-action" mwl-confirm="" title="Remove banner ad?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="removeBannerAd(bannerAdRequest)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="fa fa-close"></i></button>--}}
                            <button type="button" class="item-action" ng-click="openModal('removeBannerAdRequest', 'banner_ad_request_id', bannerAdRequest.id)"><i class="fa fa-close"></i></button>
                        </td>
                    </tr>
                    <tr ng-if='activeBannerAdRequests.length == 0'>
                        <td colspan="9">
                            <p>No banner ad requests to show.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <nav>
                    <paging
                            class="small pagination"
                            page="pageActiveBannerAdRequests"
                            page-size="perPageActiveBannerAdRequests"
                            total="totalActiveBannerAdRequests"
                            paging-action="changePageActiveBannerAdRequests(page, pageSize, total)">
                    </paging>
                </nav>
            </div>
            <hr>
            <div class="row calendar-view">
                <div class="col-md-6">
                    <h4>[[monthInView]] [[year]]</h4>
                </div>
                <div class="col-md-6">
                    <div class="btn-group ads-calendar-buttons">
                        <button
                                class="btn btn-primary"
                                mwl-date-modifier
                                date="viewDate"
                                ng-click="setMonths('prev')"
                                decrement="calendarView">
                            Previous month
                        </button>
                        <button
                                class="btn btn-default"
                                mwl-date-modifier
                                date="viewDate"
                                set-to-today>
                            Today
                        </button>
                        <button
                                class="btn btn-primary"
                                mwl-date-modifier
                                date="viewDate"
                                ng-click="setMonths('next')"
                                increment="calendarView">
                            Next month
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 admin-calendar">
                    <mwl-calendar
                            events="events"
                            view="calendarView"
                            view-date="viewDate"
                            cell-modifier="cellModifier(calendarCell)"
                            on-timespan-click="selectDay(calendarCell)"
                            excluded-days="excludedDays"
                            on-view-change-click="viewChangeClicked(calendarNextView)"
                    >
                    </mwl-calendar>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <h3>Banner ad requests: <b>[[totalBannerAdRequests]]</b></h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Type</th>
                        {{--<th>Status</th>--}}
                        <th>Days</th>
                        <th>Date to go live</th>
                        <th>Extra promotions</th>
                        <th>Created</th>
                        <th>Notes</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat='bannerAdRequest in bannerAdRequests'>
                        <td>[[bannerAdRequest.user.username]]</td>
                        <td>[[bannerAdRequest.user.email]]</td>
                        <td>[[bannerAdRequest.type]]</td>
                        {{--<td>[[bannerAdRequest.status]]</td>--}}
                        <td>[[bannerAdRequest.banner_ads.length]]</td>
                        <td>[[bannerAdRequest.banner_ads[0].day]]</td>
                        <td>
                            <i class="fa fa-check" ng-if="bannerAdRequest.extra_promotions == 1"></i>
                            <i class="fa fa-close" ng-if="bannerAdRequest.extra_promotions == 0"></i>
                        </td>
                        <td>[[formatDate(bannerAdRequest.created_at)]]</td>
                        <td class="center-column"><textarea class="banner-ad-request-admin-notes" ng-model="bannerAdRequest.notes" ng-keyup="updateNotes(bannerAdRequest)" ng-model-options="{updateOn: 'blur'}" placeholder="Notes"></textarea></td>
                        <td>
                            <button type="button" class="item-action" ng-click="openBannerAdRequestModal(bannerAdRequest)"><i class="fa fa-eye"></i></button>
                            <a download href="/banner-ads-resources/videos/[[bannerAdRequest.banner_ad_resources[0].resource]]"><button ng-if="bannerAdRequest.type == 'video'" type="button" class="item-action"><i class="fa fa-download"></i></button></a>
                            <button ng-if="bannerAdRequest.status == 'review' && bannerAdRequest.type == 'video'" type="button" class="item-action" ng-click="openModal('approveVideoBannerAdRequest', 'banner_ad_request_id', bannerAdRequest.id)"><i class="fa fa-check"></i></button>
                            <button ng-if="bannerAdRequest.status == 'review' && bannerAdRequest.type == 'images'" type="button" class="item-action" mwl-confirm="" title="Approve request?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="approveRequest(bannerAdRequest)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="fa fa-check"></i></button>
                            <button ng-if="bannerAdRequest.status == 'review'" type="button" class="item-action" ng-click="openModal('denyBannerAdRequest', 'banner_ad_request_id', bannerAdRequest.id)"><i class="fa fa-close"></i></button>
                        </td>
                    </tr>
                    <tr ng-if='bannerAdRequests.length == 0'>
                        <td colspan="9">
                            <p>No banner ad requests to show.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <nav>
                    <paging
                            class="small pagination"
                            page="pageBannerAdRequests"
                            page-size="perPageBannerAdRequests"
                            total="totalBannerAdRequests"
                            paging-action="changePageBannerAdRequests(page, pageSize, total)">
                    </paging>
                </nav>
            </div>
        </div>
    </section>
    <div class="modal fade" id="bannerAdRequestModal" tabindex="-1" role="dialog" aria-labelledby="bannerAdRequestModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="bannerAdRequest" ng-submit="submitModal('bannerAdRequest')" files="true" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
                        <h2>Booking details</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4">
                                        <h1>Username:</h1>
                                        <p>[[modalBannerAdRequest.user.username]]</p>
                                    </div>
                                    <div class="col-4">
                                        <h1>E-mail:</h1>
                                        <p>[[modalBannerAdRequest.user.email]]</p>
                                    </div>
                                    <div class="col-4">
                                        <h1>Type: </h1>
                                        <p>[[modalBannerAdRequest.type]]</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <h1>Status: </h1>
                                        <p>[[modalBannerAdRequest.status]]</p>
                                    </div>
                                    <div class="col-4">
                                        <h1>Live date: </h1>
                                        <p>[[modalBannerAdRequest.banner_ads[0].day]]</p>
                                    </div>
                                    <div class="col-4">
                                        <h1 ng-if="modalBannerAdRequest.banner_ads.length > 1">Dates (continued):</h1>
                                        <p><span ng-repeat="(key, bannerAd) in modalBannerAdRequest.banner_ads" ng-if="key > 0">[[bannerAd.day]]</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <slick id="adminSlick" ng-if="modalBannerAdRequest && modalBannerAdRequest.type == 'images' && modalBannerAdRequest.banner_ad_resources.length > 1" settings="slickConfig">
                            <img ng-repeat="(key, image) in modalBannerAdRequest.banner_ad_resources" src="/banner-ads-resources/images/[[image.resource]]">
                        </slick>
                        <img class="banner-ad-single-photo" ng-if="modalBannerAdRequest && modalBannerAdRequest.type == 'images' && modalBannerAdRequest.banner_ad_resources.length == 1" src="/banner-ads-resources/images/[[modalBannerAdRequest.banner_ad_resources[0].resource]]">
                        <iframe ng-if="modalBannerAdRequest.status == 'active' && modalBannerAdRequest.type == 'video'" width="560" height="315" ng-src="[[modalBannerAdRequest.banner_ad_resources[0].resource | trusted]]" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <video controls="true" ng-if="modalBannerAdRequest.status == 'review' && modalBannerAdRequest.type == 'video'" ng-src="[[ '/banner-ads-resources/videos/' + modalBannerAdRequest.banner_ad_resources[0].resource]]"></video>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="bannerAdRequest.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approveVideoBannerAdRequestModal" tabindex="-1" role="dialog" aria-labelledby="approveVideoBannerAdRequestModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="approveVideoBannerAdRequest" ng-submit="submitModal('approveVideoBannerAdRequest')" files="true" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
                        <h2>Approve video banner ad request</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="name" ng-model="approveVideoBannerAdRequest['data'].resource" class="form-control" required>
                            <div ng-show="approveVideoBannerAdRequest.resource.$invalid && !approveVideoBannerAdRequest.resource.$pristine" class="help-block with-errors">Link is required</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="approveVideoBannerAdRequest.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="removeBannerAdRequestModal" tabindex="-1" role="dialog" aria-labelledby="removeBannerAdRequestModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="removeBannerAdRequest" ng-submit="submitModal('removeBannerAdRequest')" files="true" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
                        <h2>Remove banner ad</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Reason</label>
                            <input type="text" name="name" ng-model="removeBannerAdRequest['data'].reason" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="removeBannerAdRequest.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="denyBannerAdRequestModal" tabindex="-1" role="dialog" aria-labelledby="denyBannerAdRequestModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="denyBannerAdRequest" ng-submit="submitModal('denyBannerAdRequest')" files="true" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
                        <h2>Deny banner ad request</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Reason</label>
                            <input type="text" name="name" ng-model="denyBannerAdRequest['data'].reason" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="denyBannerAdRequest.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection