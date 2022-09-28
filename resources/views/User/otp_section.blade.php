@include('header')

<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">OtpSender/Content</a></li>
            <li><a href="#tab-2" data-toggle="tab">Spam_Content</a> </li>


        </ul>
    </div>
</div>
<div class="top-nav clearfix">
    <ul class="nav pull-right top-menu">
        <li>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="http://mis.secureip.in/assets/images/user-png.png">
                <span class="username"> {{ session()->get('Name') }}</span>
                <b class="caret"></b>
            </a>
        </li>
    </ul>
</div>

</header>


<section id="main-content">
    <section class="wrapper">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1">

                <div class=" market-updates">
                    <div class="stats-info-agileits">
                        <form method="POST" action="{{ url('/otp_sender') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label>Otp Sender</label>
                                    <input type="text" name="otpsender" class="form-control"
                                        placeholder="Enter Otp Sender" value="" required="">
                                </div>



                                <div class="form-group col-md-3">
                                    <label>Otp Content</label>
                                    <input type="text" name="otpcontent" class="form-control"
                                        placeholder="Your otp is ##OTP##. Please dont share with anyone."
                                        required="">
                                    <font color="red"> Note : please enter like your otp is ##OTP## </font>
                                    <br>
                                    <font color="red">##OTP## IS mandatory </font>
                                    <br>

                                    <p style="color:red; font-size: 18px; font-weight: bold;">Your OTP will be set in
                                        place of
                                        ##OTP##</p>
                                </div>


                                <div class="form-group col-md-3">
                                    <label>Description's</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Enter Description">
                                </div>
                                <div class="col-md-3 mt-20">
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="stats-info-agileits">
                        <h4 class="mb-15">Otp Sender / Content </h4>
                        <div class="table-responsive ">

                            <table id="example" class="table table-bordered table-striped responsive display nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>OtpSender</th>
                                        <th>OtpContent</th>
                                        <th>DateTime</th>
                                        <th>Description</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['otpsender'] as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $log->OtpSender }}</td>
                                            <td>{{ $log->OtpContent }}</td>
                                            <td>{{ $log->DateTime }}</td>
                                            <td>{{ $log->Description }}</td>
                                            <td><a href="{{ url('delete_otp_sender/' . $log->Id) }}"
                                                    class="btn btn-info">delete</a></td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                        {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
                    </div>
                </div>
            </div>
            <div class="cl"></div>
        


           <div class="tab-pane" id="tab-2">
            <div class=" market-updates">
                <div class="stats-info-agileits">
                    <div class="col-md-12">
                        <h4 class="mb-10">Otp Spam Content </h4>
                       
                        <form role="form" action="{{url('Black_Keyword')}}" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="col-md-6">
                                <div class="form-group ">
                                  <label></label>
                                  <input type="text" name="blackKeyword" class="form-control" placeholder="Enter Black Keyword" required="" id="blackKeyword">
                                </div>
                              </div>
              
                             
                              <div class="col-md-6">
              
                                  <div class="box-footer">
                                    <input type="submit" name="submit" class="btn btn-primary" value="submit">
                                  </div>
                              </div>
                          </div>
                          </form>
                    </div>
                    <div class="col-md-12">
                        <table id="example" class="table table-bordered table-striped  responsive"
                            data-page-length='50'>
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Username</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>MsgData</th>
                                    <th>Time</th>
                                    {{-- @if (session()->get('IsAdmin') == 'Y')
                                        <th>Action</th>
                                    @endif --}}
                                </tr>
                            </thead>
                            <tbody>

                               
                                    @foreach ($data['smpp_spam_content'] as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $loop->Username }}</td>
                                            <td>{{ $value->SenderId }}</td>
                                            <td>{{ $value->receiver }}</td>
                                            <td>{{ $value->msgData }}</td>
                                            <td>{{ $value->Time }}</td>
                                            {{-- @if (session()->get('IsAdmin') == 'Y')
                                                <td><a
                                                        href="editsmppuser/{{ $value->UserId }}"class="btn btn-primary">
                                                        <i class="fa fa-edit"></i> </a>
                                                    <a onclick="return userEyeView({{ $value->UserId }})"
                                                        class="btn btn-success" data-toggle="modal"
                                                        data-target="#modal-success"> <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            @endif --}}
                                        </tr>
                                    @endforeach
                                
                            </tbody>

                            <tfoot>
                                {{-- <tr>
                                    <th>S.no</th>
                                    <th>Username</th>
                                    <th>Operator name</th>
                                    @if (session()->get('IsAdmin') == 'Y')
                                        <th>Action</th>
                                    @endif
                                </tr> --}}
                            </tfoot>
                        </table>
                    </div>
                    <div class="cl"></div>
                </div>
            </div>
            <div class="modal modal-default fade" id="modal-success"></div>
            {{-- <script type="text/javascript">
                function userEyeView(UserId) {
                    $.ajax({
                        type: "GET",
                        url: "usereyeview/" + UserId,
                        success: function(msg) {
                            $("#modal-success").html(msg);
                        }
                    });
                }
            </script> --}}
           </div>
        </div>


    </section>
</section>
{{-- table design end --}}
@include('footer')
