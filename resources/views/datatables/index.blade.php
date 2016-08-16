@extends('layouts.master')

@section('content')
    <div class="table-responsive">
        <table class="table stripe" id="users-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>D.O.B</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- View Stackoverflow details Modal -->
    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Stackoverflow Info</h4>
                    <h4 id="stackNoAccount" style="display: none;">
                        Please create a
                        <a href="https://stackoverflow.com/users/signup" target="_blank">Stackoverflow</a>
                        accout and update the user id in your details
                    </h4>
                    <h4 id="stackInvalidAccount" style="display: none;">
                        There is no info for your user id. Please provide a valid user id.
                    </h4>
                </div>
                <div class="modal-body">
                    <div>
                        <img id="loaderImg" class="col-md-offset-5" src="{{ URL('/images/ajax-loader.gif') }}">
                        <div class="panel panel-info" style="padding: 1%">
                            <div class="panel-heading">
                                <h3 id="display-name" class="panel-title"></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 " align="center">
                                        <img id="profile_pic" alt="User Pic" src="" class="img-circle img-responsive">
                                    </div>

                                    <div class=" col-md-9 col-lg-9 ">
                                        <table class="table table-user-information">
                                            <tbody>
                                            <tr>
                                                <td>Age</td>
                                                <td id="age"></td>
                                            </tr>
                                            <tr>
                                                <td>Reputation</td>
                                                <td id="reputation"></td>
                                            </tr>
                                            <tr>
                                                <td>Bronze Badges</td>
                                                <td id="b_badges"></td>
                                            </tr>

                                            <tr>
                                            <tr>
                                                <td>Silver Badges</td>
                                                <td id="s_badges"></td>
                                            </tr>
                                            <tr>
                                                <td>Gold Badges</td>
                                                <td id="g_badges"></td>
                                            </tr>
                                            <tr>
                                                <td>Location</td>
                                                <td id="location"></td>
                                            </tr>
                                            <tr>
                                                <td>Link</td>
                                                <td><a id="link" href="" target="_blank">Visit Your Stackoverflow profile</a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Details Modal -->
    <div id="viewDetailsModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">User Details</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="panel panel-info" style="padding: 2%">
                            <div class="panel-heading">
                                <h3 id="display-employee-name" class="panel-title"></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 " align="center">
                                        <img id="user_pic" alt="User Pic" src="" class="img-circle img-responsive">
                                    </div>

                                    <div class=" col-md-9 col-lg-9 ">
                                        <table class="table table-user-information">
                                            <tbody>
                                            <tr>
                                                <td>Marital Status</td>
                                                <td id="marital_status"></td>
                                            </tr>
                                            <tr>
                                                <td>Employment</td>
                                                <td id="employment_status"></td>
                                            </tr>
                                            <tr>
                                                <td>Address (R)</td>
                                                <td id="residence_address"></td>
                                            </tr>
                                            <tr>
                                                <td>Address (O)</td>
                                                <td id="office_address"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@push('scripts')
<script>
    // Send request to delete the account
    $(document).on('click', '.alert-delete', function (e) {
        $employeeId = $(this).parent().children('.getEmployeeId').val();
        bootbox.confirm('You are about to delete the account. Are you sure you want to do it ? ', function(result){

            if ( result) {

                $.ajax({
                    url: '/delete/'+$employeeId,
                    data: {
                    },
                    dataType : 'json',
                    type: "GET",
                    success: function (response) {

                        // If delete is success then reload the page
                        location.reload();
                    }
                });
            }else {
            }
        });
    });

    // Send request to restore the account
    $(document).on('click', '.alert-restore', function (e) {
        $employeeId = $(this).parent().children('.getEmployeeId').val();
        bootbox.confirm('You are about to restore the account. Are you sure you want to do it ? ', function(result){

            if ( result ) {

                $.ajax({
                    url: '/restore/'+$employeeId,
                    data: {
                    },
                    dataType : 'json',
                    type: "GET",
                    success: function (response) {

                        // If restore is success then reload the page
                        location.reload();
                    }
                });
            }else {
            }
        });
    });

    function showDatatables() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('details') !!}',
            lengthMenu: [5,10,15],
            columns: [
                { data: 'firstName', name: 'firstName'},
                { data: 'gender', name:'gender'},
                { data: 'dob', name:'dob',bSearchable:false,bSortable:false },
                { data: 'Phone', name:'Phone',bSearchable:false,bSortable:false},
                { data: 'email', name: 'email'},
                { data: 'photo', name: 'photo',bSearchable:false,bSortable:false},
                { data: 'Action', name: 'Action',bSearchable:false,bSortable:false}
            ]
        });
    }
</script>
<script>
    $(document).ready(function () {

        showDatatables();
    });
</script>
<script type="text/javascript" src="js/details.js"></script>
@endpush