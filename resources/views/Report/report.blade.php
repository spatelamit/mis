@include('header')

<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a class="active" href="#tab-1" data-toggle="tab">Summery History</a> </li>
            <li><a href="#tab-2" data-toggle="tab">Detailed Report</a></li>
            <li><a href="#tab-3" data-toggle="tab">Download Detailed Report</a></li>
            <!-- <li><a onclick="getReportTab('reportlist')">Download Detailed Report</a></li> -->
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
                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <div id="report_data">

                            <h4 class="mb-20">All Summary History</h4>
                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-striped responsive"
                                    style="text-transform: capitalize;">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Username</th>
                                            <th>Date</th>
                                            <th>Submit</th>
                                            <th>Delivered</th>
                                            <th>Failed</th>
                                            <th>Pending</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['summeryhistory'] as $val)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $val->Username }}</td>
                                                <td>{{ $val->Date }}</td>
                                                <td>{{ $val->Submit }}</td>
                                                <td>{{ $val->Delivered }}</td>
                                                <td>{{ $val->Failed }}</td>
                                                <td>{{ $val->Submit - ($val->Delivered + $val->Failed) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $data['summeryhistory']->withQueryString()->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab-2">

                <div class=" market-updates">
                    <div class="stats-info-agileits">

                        <h4 class="mb-10"> Delivery Reports </h4>

                        <form action="javascript:void(0)" id="DeliveryReportID" method="POST">
                            @csrf


                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group col-md-3 ">
                                        <label>From :</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right datetimepicker"
                                                name="from" required="" value="<?php echo date('Y-m-d') . ' 00:00:00'; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 ">
                                        <label>To :</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>

                                            <input type="text" class="form-control pull-right datetimepicker"
                                                name="to" required="" value="<?php echo date('Y-m-d') . ' 23:59:59'; ?>">
                                        </div>
                                    </div>
                                     @if(session()->get('IsAdmin') != 'Y')
                                         @foreach ($data['getAllMembers'] as $key => $value)
                                         <input type="hidden" class="form-control" name="Username" value="{{ $value->Username }}">
                                          @endforeach
                                    @else
                                    <div class="form-group col-md-3">

                                        <div class="form-group">
                                            <label>Select Username</label>
                                            <select class="form-control user-select2" name="Username" id="Username"
                                                required="">
                                                <option value="all">All Users</option>
                                                @foreach ($data['getAllMembers'] as $key => $value)
                                                    <option value="{{ $value->Username }}">{{ $value->Username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group col-md-3">
                                        <label>Msg ID</label>
                                        <input type="text" class="form-control" placeholder="MsgId" name="MsgId">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group col-md-3">
                                        <label>Sender</label>
                                        <input type="text" class="form-control" placeholder="Sender Id"
                                            name="Sender">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" placeholder="Mobile" name="Mobile">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label>Select Status</label>
                                            <select class="form-control select2" name="type" id="type">
                                                <option value="">Status</option>
                                                <option value="1">Delivered</option>
                                                <option value="2">Failed</option>
                                                <option value="16">Reject</option>
                                                <option value="923">Sent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 mt-20">
                                        <input type="submit" name="" onclick="DeliveryReportPdu()"
                                            value="Get Reports" class="btn btn-primary mt25" id="GetDeliveryPdu">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="DeliveryReportPdu"></div>


                        <div class="cl"></div>

                    </div>
                </div>


            </div>
            <div class="tab-pane" id="tab-3">

                <div class=" market-updates">
                    <div class="stats-info-agileits">

                        <h4 class="mb-20"> Download / Request Reports </h4>

                        <form action="javascript:void(0)" id="reportlist_form" method="POST">
                            @csrf

                            <div class="row">

                                <div class="form-group col-md-3">
                                    
                  <label>Date </label>
                             <?php 
            if(session()->get('IsAdmin') != 'Y'){ 
            $j = 15;
            }
            else{
             $j=60;
            }
            ?>
              <select name="Date"  class="form-control pull-right" >
                <?php
                  for ($i=2; $i < $j; $i++) { 
                    ?>
                    <option><?php echo date('Y-m-d', strtotime('-'.$i.' days')); ?></option>
                    <?php
                  }
                ?>
                
              </select>
                  
         


                                </div>


                               
                                    <!-- select -->

                                    
                                    @if(session()->get('IsAdmin') != 'Y')
                                         @foreach ($data['getAllMembers'] as $key => $value)
                                         <input type="hidden" class="form-control" name="Username" value="{{ $value->Username }}">
                                          @endforeach
                                    @else
                                     <div class="form-group col-md-3 full_width">
                                    <label>Select Username</label> <br />
                                      <select class="form-control " name="Username" id="Username"
                                        required="" style="width:100%;">

                                        @foreach ($data['getAllMembers'] as $key => $value)
                                            <option value="{{ $value->Username }}">{{ $value->Username }}</option>
                                        @endforeach
                                    </select>
                                     </div>
                                    @endif
                                  

                               


                                <div class="form-group col-md-3">
                                    <label>Sender (Optional)</label>
                                    <input type="text" class="form-control" placeholder="SenderId"
                                        name="Sender">
                                </div>


                                <div class="form-group col-md-3 mt-20">
                                    <button type="submit" class="btn btn-primary mt25">Submit</button>
                                </div>

                            </div>

                        </form>


                    </div>

                    <div class="stats-info-agileits mt-20">
                        <div class="box-body" id="reporttable">

                            <table id="reporttablelist" class="table table-bordered table-striped displya "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Username</th>
                                        <th>Sender </th>
                                        <th>Report Date</th>
                                        <th>Requested DateTime </th>
                                        <th>Report Status </th>
                                        <th>Download </th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                     @foreach ($data['ReportsList'] as $val)
                                    <tr id="{{ $val->Id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $val->Username }}</td>
                                        <td>{{ $val->Sender }}</td>
                                        <td>{{ $val->Date }}</td>
                                        <td>{{ $val->RequestedDate }}</td>
                                        @if($val->ReportStatus=="Pending")
                                        <td>Pending</td>
                                        @else
                                        <td>
                                            {{ $val->ReportStatus }}
                                        </td>
                                        @endif
                                        @if($val->ReportPath=="NA")
                                        <td>
                                            <a>
                                <i class=" btn btn-primary fa fa-download"> {{ $val->ReportPath }}</i>
                            </a>
                                           </td>
                                            @else
                                             <td>
                                                <a target="_BLANK"  href="reports/archive/{{ $val->ReportPath }}" >
                                <i class=" btn btn-primary fa fa-download">{{ $val->ReportPath }}</i>
                        </a>
                                            </td>
                                            @endif
                                        <td><a onclick="reportdel('{{ $val->Id }}')" 
                                                class="btn btn-info">delete</a></td>
                                    </tr>
                                    @endforeach


                                </tbody>

                            </table>
                        {!! $data['ReportsList']->withQueryString()->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>


                </div>







            </div>
        </div>
    </section>
</section>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    jQuery('.datetimepicker').datetimepicker({
        //or 1986/12/08
    });

    
    $(document).ready(function() {
        $('.user-select2').select2({
            placeholder: 'Select an users',
            allowClear: true,
        });
         $("#dates").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        });
    });


</script>
<script type="text/javascript" >
   function reportdel(id) {
     
        $.ajax({
            'url': '/reportdelete/'+id,
            'type': 'get',
            'data': {},
            'success': function(response) {
               
                $("#" + id).remove();
            }
        });


    }
</script>
@include('footer')
