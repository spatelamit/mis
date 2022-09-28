@include('header')

<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">Sender Id Ratio</a></li>
            <li><a href="#tab-2" data-toggle="tab">Whitelist Number</a> </li>
            <li><a href="#tab-3" data-toggle="tab">Approved User Sender</a></li>
            <li><a href="#tab-4" data-toggle="tab"> Force Sender</a></li>
            {{-- <li><a href="#tab-5" data-toggle="tab"> Error Code</a></li>
                <li><a href="#tab-6" data-toggle="tab">DLT (MMOperators)</a></li>
                <li><a href="#tab-7" data-toggle="tab">User Control History</a></li> --}}



            {{-- <li><a onclick="getWhitelistTab('senderratio')">Sender Id Ratio</a> </li>
                <li><a onclick="getWhitelistTab('viewwhitelist')">Whitelist Number</a></li>
                <li><a onclick="getWhitelistTab('approvedUserSender')">Approved User Sender</a></li>
                <li><a onclick="getWhitelistTab('forceSender')">Force Sender</a> </li>
                <li><a onclick="getWhitelistTab('errorCode')">Error Code</a></li>
                <li><a onclick="getWhitelistTab('mmOperators')">DLT (MMOperators)</a></li>
                <li><a onclick="getWhitelistTab('userControlHistory')">User Control History</a> </li> --}}
        </ul>
    </div>
</div>



<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>

        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="http://mis.secureip.in/assets/images/user-png.png">
                <span class="username"> {{ session()->get('Name') }}</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
    </ul>
    <!--search & user info end-->
</div>
</header>

<section id="main-content">
    <section class="wrapper">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1">
                <div class="content-wrapper">
                    <section class="content-header">
                        <h1>SenderId Wise Ratio</h1>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-8">
                                <!-- general form elements -->
                                <div class="box box-primary">
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form role="form" id="savesender" method="POST">
                                        @csrf
                                        <div class="box-body">
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>SenderId</label>
                                                    <input type="hidden" name="Id" id="Id" value="">
                                                    <input type="text" name="SenderId" id="SenderId"
                                                        class="form-control" placeholder="Enter SenderId" required=""
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>RATIO </label>
                                                    <select name="Ratio" class="form-control" required=""
                                                        id="Ratio">
                                                        <option value="0"> 0% </option>
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
                                            <div class="box-footer">
                                                <a name="submit" onclick="savesenderratio()"
                                                    class="btn btn-primary">Submit</a>
                                            </div>
                                    </form>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example" class="table table-bordered table-striped responsive"
                                            style="text-transform: capitalize;" data-page-length='25'>
                                            <thead>
                                                <tr>
                                                    <th>SenderId</th>
                                                    <th>Ratio</th>
                                                    <th>DateTime</th>
                                                    <th>Last Update DateTime</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if ($data['senderratio'] != '')

                                                    @foreach ($data['senderratio'] as $key => $value)
                                                        <tr id="{{ $value->Id }}">
                                                            <td>{{ $value->SenderId }}</td>
                                                            <td>
                                                                @if ($value->Ratio == 1)
                                                                    50%
                                                                @elseif($value->Ratio == 2)
                                                                    35%
                                                                @elseif($value->Ratio == 3)
                                                                    25%
                                                                @elseif($value->Ratio == 4)
                                                                    20%
                                                                @elseif($value->Ratio == 5)
                                                                    16%
                                                                @elseif($value->Ratio == 6)
                                                                    13%
                                                                @elseif($value->Ratio == 7)
                                                                    11%
                                                                @elseif($value->Ratio == 8)
                                                                    10%
                                                                @elseif($value->Ratio == 9)
                                                                    9%
                                                                @elseif($value->Ratio == 0)
                                                                    0%
                                                                @endif
                                                            </td>
                                                            <td>{{ $value->DateTime }}</td>
                                                            <td>{{ $value->LastUpdate }}</td>
                                                            <td>{{ $value->Status }}</td>
                                                            @if (session()->has('IsAdmin') == 'fY')
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="editSenderRatio({{ $value->Id }},'{{ $value->SenderId }}', {{ $value->Ratio }});"
                                                                        class="btn btn-primary">
                                                                        <i class="fa fa-edit "></i>
                                                                    </a>

                                                                    <a onclick="deletesenderratio({{ $value->Id }},'{{ $value->SenderId }}');"
                                                                        class="btn btn-danger">
                                                                        <i class="fa fa-trash "></i>
                                                                    </a>
                                                                </td>
                                                            @endif

                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SenderId</th>
                                                    <th>Ratio</th>
                                                    <th>DateTime</th>
                                                    <th>Last Update DateTime</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>

                        </div>
                        <div id="whitelist2_data"></div>




                    </section>
                </div>
                <style type="text/css">
                    .ChildDiv {
                        padding-left: 0;
                        padding-right: 0;
                    }
                </style>

            </div>
            <div class="tab-pane" id="tab-2">

                <form role="form" id="whitelist" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="box-body">


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Number (with 91)</label>
                                <input type="number" name="Number" class="form-control" placeholder="Enter Number"
                                    required="">
                            </div>
                        </div>


                    </div>



                    <div class="box-footer">
                        <button type="submit" onsubmit="whitelist()" class="btn btn-primary">Submit</button>

                    </div>
                </form>

                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div id="report_data">

                            <h4 class="mb-20">All Summary History</h4>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped responsive"
                                    style="text-transform: capitalize;">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Number</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['whitelist_number'] as $val)
                                            <tr id={{ $val->WhiteListId }}>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $val->Number }}</td>
                                                <td>{{ $val->DateTime }}</td>
                                                <td>
                                                    <a onclick="deletewhitelistnumber({{ $val->WhiteListId }});"
                                                        class="btn btn-danger">
                                                        <i class="fa fa-trash "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- {!! $data['summeryhistory']->withQueryString()->links('pagination::bootstrap-4') !!} --}}
                        </div>
                    </div>
                </div>



            </div>

            <div class="tab-pane" id="tab-3">


                <form  id="approvedUserSenderId" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="box-body">


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>SenderId</label>
                                <input type="text" name="senderid" class="form-control"
                                    placeholder="Approved user Senderid" required="">
                            </div>
                        </div>


                    </div>



                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </form>

                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div id="report_data">

                            <h4 class="mb-20">White Sender Id's</h4>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped responsive"
                                    style="text-transform: capitalize;">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>WhiteSender</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['approved_User_SenderIds'] as $val)
                                            <tr id="{{ $val->Id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $val->senderId }}</td>

                                                @if($val->status=='1')
                                                <td>
                                                    
                                                    Active
                                                </td>
                                                    @else
                                                    <td>Inactive</td>
                                                    @endif
                                                
                                                <td>
                                                    <a onclick="deleteAUSID({{ $val->Id }});"
                                                        class="btn btn-danger">
                                                        <i class="fa fa-trash "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- {!! $data['summeryhistory']->withQueryString()->links('pagination::bootstrap-4') !!} --}}
                        </div>
                    </div>
                </div>


            </div>

            <div class="tab-pane" id="tab-4">

                <form id="Forcesender1" method="POST" action="javascript:void(0)">
                    @csrf
                    <div class="box-body">


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Force Sender</label>
                                <input type="text" name="ForceSender" class="form-control"
                                    placeholder="Enter Force Sender i.e. BLKSMS" value="" required="">
                            </div>
                        </div>



                        <div class="col-md-6">

                            <div class="form-group">


                                <label>Select Username</label>

                                <select name="UserId" class="form-control "
                                    >
                                    <option value="">Select User Name</option>
                                    <option value="65">airtrans</option>

                                    <option value="67">apitxt</option>

                                    <option value="58">B2BSMS</option>

                                    <option value="111">Basmpp</option>

                                    <option value="104">bsspapp</option>

                                    <option value="27">bsspotp</option>

                                    <option value="96">Btiildo</option>

                                    <option value="101">btiindia</option>

                                    <option value="22">bulk24sms</option>

                                    <option value="5">bulksms</option>

                                    <option value="14">CBTRN12</option>

                                    <option value="105">coderapp</option>

                                    <option value="20">CruxUser</option>

                                    <option value="112">ctextin</option>

                                    <option value="115">cybopromo</option>

                                    <option value="114">cybotrans</option>

                                    <option value="15">CYBTR18</option>

                                    <option value="10">demosmpp2</option>

                                    <option value="12">directself</option>

                                    <option value="53">dndtest</option>

                                    <option value="69">Errorcode</option>

                                    <option value="75">indiaotp</option>

                                    <option value="80">japan</option>

                                    <option value="113">konsolesmpp</option>

                                    <option value="2">mayank</option>

                                    <option value="84">mmoperator</option>

                                    <option value="86">Mmoperator2</option>

                                    <option value="85">mmsim</option>

                                    <option value="87">mmsim2</option>

                                    <option value="100">Moperatordl2</option>

                                    <option value="98">moperatordlt</option>

                                    <option value="6">newhp</option>

                                    <option value="7">newhp1</option>

                                    <option value="8">newhp2</option>

                                    <option value="108">Newildo</option>

                                    <option value="95">newnumeric</option>

                                    <option value="109">newsim</option>

                                    <option value="107">routetest</option>

                                    <option value="24">SHRMTR1</option>

                                    <option value="23">sid</option>

                                    <option value="60">simmodem</option>

                                    <option value="102">srtstest</option>

                                    <option value="103">srtstest1</option>

                                    <option value="66">stockfav</option>

                                    <option value="45">UAE</option>

                                    <option value="30">UNITED</option>

                                    <option value="92">universe</option>

                                    <option value="89">uptotel</option>

                                    <option value="46">USA</option>

                                    <option value="26">videocon</option>

                                    <option value="59">visvel</option>

                                    <option value="21">Vodafone</option>

                                    <option value="9">dndpromo</option>

                                    <option value="16">jotptest</option>

                                    <option value="13">jwlotp</option>

                                    <option value="18">MMJewel</option>

                                    <option value="52">SingaporeNXT</option>

                                </select>
                                

                            </div>
                            <p style="color: red; font-weight: bold;"> *** This Option is override the sender Id Of
                                Selected Username</p>

                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="Status" value="1" checked="">Active
                                    </label>

                                    <label>
                                        <input type="radio" name="Status" value="0">
                                        De-active
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                       
                    </div>
                </form>

                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div id="report_data">

                            <h4 class="mb-20">Force Sender </h4>
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped responsive"
                                    style="text-transform: capitalize;">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>ForceSender</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['ForceSender'] as $val)
                                            <tr id="{{ $val->Id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $val->ForceSender }}</td>
                                                <td>{{ $val->UserId }}</td>
                                                <td>{{ $val->Status }}</td>
                                                <td>{{ $val->DateTime }}</td>
                                                <td>
                                                    <a onclick="deleteForceSender({{ $val->Id }});"
                                                        class="btn btn-danger">
                                                        <i class="fa fa-trash "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- {!! $data['summeryhistory']->withQueryString()->links('pagination::bootstrap-4') !!} --}}
                        </div>
                    </div>
                </div>


            </div>

            <div class="tab-pane" id="tab-5">
            </div>

            <div class="tab-pane" id="tab-6">
            </div>

            <div class="tab-pane" id="tab-7">
            </div>

        </div>


        <div id="whitelist_data"></div>












    </section>
</section>
<script type="text/javascript">
    function editSenderRatio(Id, sender, ratio) {

        $('#SenderId').val(sender);
        $('#Ratio').val(ratio);
        $('#Id').val(Id);
    }

    function deletesenderratio(id,senderId) {
        console.log(senderId);
        $.ajax({
            'url': '/deletesenderratio/' + id +'/'+senderId,
            'type': 'get',
            'data': {},
            'success': function(data) {
                alert(senderId)
                $("#" + id).remove();

            }
        });
    }


    function deletewhitelistnumber(id) {
        console.log(id);
        $.ajax({
            'url': '/deletewhitelistnumber/' + id,
            'type': 'get',
            'data': {},
            'success': function(data) {
                $("#" + id).remove();
            }
        });
    }

    function deleteAUSID(id) {
       
        $.ajax({
            'url': '/deleteAUSenderId/' + id,
            'type': 'get',
            'data': {},
            'success': function(data) {
                $("#" + id).remove();
            }
        });
    }

    function deleteForceSender(id) {
        console.log(id);
        $.ajax({
            'url': '/deleteForceSender/' + id,
            'type': 'get',
            'data': {},
            'success': function(data) {
                // console.log(id);
                $("#" + id).remove();
            }
        });
    }
</script>
@include('footer')
