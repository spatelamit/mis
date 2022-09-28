@include('header')
<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">Add Users</a></li>
            <li><a href="#tab-2" data-toggle="tab">Users List</a> </li>
            <li><a href="#tab-3" data-toggle="tab">Routing</a></li>

            <!-- <li><a onclick="getSmppTab('addUsers')">Add Users</a> </li>
                <li><a onclick="getSmppTab('usersList')">Users List</a></li>
                <li><a onclick="getSmppTab('routing')">Routing</a></li> -->
        </ul>
    </div>
</div>
<div class="top-nav clearfix">
    <ul class="nav pull-right top-menu">
        <li> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <img alt=""
                    src="http://mis.secureip.in/assets/images/user-png.png"> <span class="username">
                    {{ session()->get('Name') }}</span> <b class="caret"></b> </a> </li>
    </ul>
</div>
</header>
<section id="main-content">
    <section class="wrapper">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1">
                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div class="col-md-12">
                            <h4 class="mb-10">Add SMPP User</h4>
                        </div>
                        <form role="form" action="/savesmppuser" method="post">
                            @csrf
                            <div class="box-body">
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Username(SMPP)</label>
                                        <input type="text" name="Username" class="form-control"
                                            placeholder="Enter Username" required="" id="Username" minlength="5"
                                            maxlength="12" pattern=".{0}|.{5,15}" required
                                            title="Either 0 OR (5 to 15 chars)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Password(SMPP)</label>
                                        <input type="text" name="Password" class="form-control"
                                            placeholder="Enter Password" required id="Password" minlength="5"
                                            maxlength="8" pattern=".{0}|.{5,8}" required
                                            title="Either 0 OR (5 to 8 chars)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Smsc Id</label>
                                        <input type="text" name="SmscId" class="form-control"
                                            placeholder="Enter Smsc Id" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Ip Address (White Listed)</label>
                                        <input type="text" name="IpAddress" class="form-control"
                                            placeholder="Enter IP 192.168.0.1;192.168.0.2" value="">
                                        <span style="color:red;">Note : Separated By Semicolon(;)</span>
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Max Instances</label>
                                        <input type="Number" name="MaxInstances" class="form-control"
                                            placeholder="Enter MaxInstances" value="5">
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Max Transceiver Instances</label>
                                        <input type="Number" name="MaxTransceiverInstances" class="form-control"
                                            placeholder="Enter MaxTransceiverInstances" value="5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Throughput</label>
                                        <input type="Number" name="Throughput" class="form-control"
                                            placeholder="Enter Throughput" value="1000" required>
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Max transmitter Instances</label>
                                        <input type="Number" name="MaxTransmitterInstances" class="form-control"
                                            placeholder="Enter MaxTransmitterInstances" value="5">
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Max Receiver Instances</label>
                                        <input type="Number" name="MaxReceiverInstances" class="form-control"
                                            placeholder="Enter MaxReceiverInstances" value="5">
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Throughput In</label>
                                        <input type="Number" name="ThroughputIn" class="form-control"
                                            placeholder="Enter ThroughputIn" value="600" required>
                                    </div>
                                </div>
                                <div class="col-md-3 ChildDiv">
                                    <div class="form-group ">
                                        <label>Throughput Out</label>
                                        <input type="Number" name="ThroughputOut" class="form-control"
                                            placeholder="Enter Throughput Out" value="400">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mode</label>
                                        <select name="Mode" class="form-control">
                                            <option value="all" selected="">All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>SessionTimeout (Seconds)</label>
                                        <input type="Number" name="SessionTimeout" class="form-control"
                                            placeholder="Enter SessionTimeout" value="150" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Default Smsc</label>
                                        <select name="DefaultSmsc" class="form-control" required="">
                                            <option value="">Select SMSC</option>

                                            @foreach ($SmscList as $key => $value)
                                                <option value="{{ $value->Id }}">{{ $value->SmscId }} </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>RATIO </label>
                                        <select name="Ratio" class="form-control" required="">
                                            <option value="0" selected=""> 0% </option>
                                            <option value="9"> 9% </option>
                                            <option value="8"> 10% </option>
                                            <option value="7"> 11% </option>
                                            <option value="6"> 13% </option>
                                            <option value="5"> 16% </option>
                                            <option value="4"> 20% </option>
                                            <option value="3"> 25% </option>
                                            <option value="2"> 35% </option>
                                            <option value="1"> 50% </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>SMPP Account Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="Status" value="1">
                                                Active </label>
                                            <label>
                                                <input type="radio" name="Status" value="0" checked>
                                                De-active </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mt-10 mb-10"> Personal Details(MIS)</h4>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Fullname</label>
                                        <input type="text" name="Fullname" class="form-control"
                                            placeholder="Enter Fullname">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Mobile</label>
                                        <input type="text" name="Mobile" class="form-control"
                                            placeholder="Enter Mobile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Username(MIS)</label>
                                        <input type="text" name="UsernameMIS" class="form-control"
                                            placeholder="Enter Username" required="" id="UsernameMIS">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Password(MIS)</label>
                                        <input type="text" name="PasswordMIS" class="form-control"
                                            placeholder="Enter Password" id="PasswordMIS">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="Email" name="Email" class="form-control"
                                            placeholder="Enter Email" value="test@gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Company/Organization</label>
                                        <input type="text" name="CompanyOrganization" class="form-control"
                                            placeholder="Enter Company Organization Name" value="Test Pvt. Ltd.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>City</label>
                                        <input type="text" name="City" class="form-control"
                                            placeholder="Enter City" value="Indore">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>State</label>
                                        <input type="text" name="State" class="form-control"
                                            placeholder="Enter State" value="MP">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label>Country</label>
                                        <input type="text" name="Country" class="form-control"
                                            placeholder="Enter Country" value="INDIA">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label>Address</label>
                                        <textarea name="Address" class="form-control" rows="1" placeholder="Enter Address">INDORE</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Status(MIS)</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="StatusMIS" value="1">
                                                Active </label>
                                            <label>
                                                <input type="radio" name="StatusMIS" value="0" checked>
                                                De-active </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mt-20">
                                <input type="submit" name="submit" class="btn btn-primary" value="submit">
                            </div>
                        </form>
                        <div class="cl"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab-2">
                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div class="col-md-12">
                            <h4 class="mb-10"> SMPP Users List </h4>
                        </div>
                        <div class="col-md-12">
                            <table id="example" class="table table-bordered table-striped  responsive"
                                data-page-length='50'>
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Username</th>
                                        <th>Operator name</th>
                                        @if (session()->get('IsAdmin') == 'Y')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($getAllMembers != '')
                                        @foreach ($getAllMembers as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->Username }}</td>
                                                <td>{{ $value->Operator }}</td>
                                                @if (session()->get('IsAdmin') == 'Y')
                                                    <td><a
                                                            href="editsmppuser/{{ $value->UserId }}"class="btn btn-primary">
                                                            <i class="fa fa-edit"></i> </a>
                                                        <a onclick="return userEyeView({{ $value->UserId }})"
                                                            class="btn btn-success" data-toggle="modal"
                                                            data-target="#modal-success"> <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Username</th>
                                        <th>Operator name</th>
                                        @if (session()->get('IsAdmin') == 'Y')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="cl"></div>
                    </div>
                </div>
                <div class="modal modal-default fade" id="modal-success"></div>
                <script type="text/javascript">
                    function userEyeView(UserId) {
                        $.ajax({
                            type: "GET",
                            url: "usereyeview/" + UserId,
                            success: function(msg) {
                                $("#modal-success").html(msg);
                            }
                        });
                    }
                </script>
            </div>
            <div class="tab-pane" id="tab-3">
                <style type="text/css">
                    .btn.bt_w {
                        padding: 6px 44px;
                    }
                </style>
                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div class="col-md-12">
                            <h4 class="mb-10"> SMPP Users List </h4>
                        </div>
                        <div class="col-md-3"> <a class="btn btn-primary" href="updateAll">Update All</a> </div>
                        <div class="col-md-3">

                            <h1 id="changeRouting"></h1>
                        </div>
                        <div class="col-md-12 mt-15">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped responsive"
                                    style="text-transform: capitalize;" data-page-length='25'>
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Current name</th>
                                            <th>Default name</th>
                                            @if (session()->get('IsAdmin') == 'Y')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (isset($getAllMembers) && $getAllMembers != '')
                                            @foreach ($getAllMembers as $key => $value)
                                                <form id="changeRouting-{{ $value->UserId }}" method="post">
                                                    @csrf
                                                    <tr>
                                                        <td>{{ $value->Username }}</td>
                                                        <td>{{ $value->Operator }}</td>
                                                        <td>
                                                            <div class="form-group as_width ">
                                                                <input type="hidden" name="UserId"
                                                                    value="{{ $value->UserId }}">
                                                                <input type="hidden" name="Username" id="username"
                                                                    value="{{ $value->Username }}">
                                                                <select name="DefaultSmsc" class="form-control"
                                                                    required="">
                                                                    <option value="">Select SMSC </option>

                                                                    @if (isset($SmscList) && $getAllMembers != '')
                                                                        @foreach ($SmscList as $key => $val)
                                                                            <?php
                                                                            $select = '';
                                                                            if ($value->Operator == $val->SmscId) {
                                                                                $select = 'selected';
                                                                            }
                                                                            ?>
                                                                            <option value="{{ $val->Id }}"
                                                                                {{ $select }}>
                                                                                {{ $val->SmscId }} </option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </td>
                                                        @if (session()->get('IsAdmin') == 'Y')
                                                            <td><a class="btn bt_w btn-primary" id="changeRoutingdata"
                                                                    onclick="changeRouting({{ $value->UserId }})"> <i
                                                                        class="fa fa-save "></i> </a></td>
                                                        @endif
                                                    </tr>
                                                </form>
                                            @endforeach
                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Username</th>
                                            <th>Operator name</th>
                                            @if (session()->get('IsAdmin') == 'Y')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="cl"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</section>
@if (session()->has('success'))
    <script type="text/javascript">
        toastr.success("{{ session()->get('success') }}", "success", {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        });
    </script>
@elseif(session()->has('error'))
    <script type="text/javascript">
        toastr.error("{{ session()->get('error') }}", "error", {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        });
    </script>
@endif

@include('footer')
