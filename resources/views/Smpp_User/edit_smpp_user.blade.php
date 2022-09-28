@include('header')
<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            {{-- <li class="active"><a href="#tab-1" data-toggle="tab">Add Users</a></li>
            <li><a href="#tab-2" data-toggle="tab">Users List</a> </li>
            <li><a href="#tab-3" data-toggle="tab">Routing</a></li> --}}

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





        <div class="tab-pane active" id="tab-1">
            <div class=" market-updates">
                <div class="stats-info-agileits">
                    <div class="col-md-12">
                        <h4 class="mb-10">Add SMPP User</h4>
                    </div>
                    <form  action="{{url('Updatesmppuser')}}" method="POST">
                        @csrf
                        <div class="box-body">
                            
                                    
                                    <input type="hidden" name="UserId" value="{{ $users->UserId }}"
                                        class="form-control">
                                        
                                
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Username(SMPP)</label>
                                    <input type="text" name="Username" value="{{ $users->Username }}"
                                        class="form-control" placeholder="Enter Username" required="" id="Username"
                                        minlength="5" maxlength="12" pattern=".{0}|.{5,15}" required
                                        title="Either 0 OR (5 to 15 chars)">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Smsc Id</label>
                                    <input type="text" name="SmscId" class="form-control"
                                        placeholder="Enter Smsc Id" value="{{ $users->SmscId }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Ip Address (White Listed)</label>
                                    <input type="text" name="IpAddress" class="form-control"
                                        placeholder="Enter IP 192.168.0.1;192.168.0.2" value="{{ $users->IpAddress }}">
                                    <span style="color:red;">Note : Separated By Semicolon(;)</span>
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Max Instances</label>
                                    <input type="Number" name="MaxInstances" class="form-control"
                                        placeholder="Enter MaxInstances" value="{{ $users->MaxInstances }}">
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Max Transceiver Instances</label>
                                    <input type="Number" name="MaxTransceiverInstances" class="form-control"
                                        placeholder="Enter MaxTransceiverInstances"
                                        value="{{ $users->MaxTransceiverInstances }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Throughput</label>
                                    <input type="Number" name="Throughput" class="form-control"
                                        placeholder="Enter Throughput" value="{{ $users->Throughput }}" required>
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Max transmitter Instances</label>
                                    <input type="Number" name="MaxTransmitterInstances" class="form-control"
                                        placeholder="Enter MaxTransmitterInstances"
                                        value="{{ $users->MaxTransmitterInstances }}">
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Max Receiver Instances</label>
                                    <input type="Number" name="MaxReceiverInstances" class="form-control"
                                        placeholder="Enter MaxReceiverInstances"
                                        value="{{ $users->MaxReceiverInstances }}">
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Throughput In</label>
                                    <input type="Number" name="ThroughputIn" class="form-control"
                                        placeholder="Enter ThroughputIn" value="{{ $users->ThroughputIn }}" required>
                                </div>
                            </div>
                            <div class="col-md-3 ChildDiv">
                                <div class="form-group ">
                                    <label>Throughput Out</label>
                                    <input type="Number" name="ThroughputOut" class="form-control"
                                        placeholder="Enter Throughput Out" value="{{ $users->ThroughputOut }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Mode</label>
                                    <select name="Mode" class="form-control">
                                        <option value="{{ $users->Mode }}" selected="">{{ $users->Mode }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>SessionTimeout (Seconds)</label>
                                    <input type="Number" name="SessionTimeout" class="form-control"
                                        placeholder="Enter SessionTimeout" value="{{ $users->SessionTimeout }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                  <label>Low Balance Alert</label>
                                  
                                  <input type="text" name="LowBalanceLimit" class="form-control"  placeholder="Enter Username" value="{{ $users->LowBalanceLimit }}"  id="BalanceAlert" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                        <label>IsOTP User</label>
                                      <div class="checkbox">
                                          <label><input type="checkbox" name="IsOTPUer" value="1" <?php if($users->IsOTPUser=='1'){ echo "checked";}?>  >Is OTP</label>
                                      </div>
                                     <!--  <div class="radio">
                
                                        <label>
                                          <input type="radio" class="minimal" name="IsOTPUer" value="1"  <?php //if($users->IsOTPUser=='1'){ echo "checked";}?>  >Active                        
                                        </label>
                                      </div> -->
                                    </div>
                               </div>
                               <div class="col-md-3">
                                <div class="form-group">
                                     <label>DND Filter</label>
                                   <div class="radio">
             
                                     <label>
                                       <input type="radio" class="minimal" name="dnd" value="1"  <?php if($users->dnd=='1'){ echo "checked";}?>  >DND Enable                        
                                     </label>
             
                                     <label>
                                       <input type="radio" class="minimal" name="dnd" value="0" <?php if($users->dnd=='0'){ echo "checked";}?>>
                                       DND Disable
                                     </label>
                                 </div>
                                 </div>
                             </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Default Smsc</label>
                                    <select name="DefaultSmsc" class="form-control" required="">
                                        <option value="{{ $users->Id }}" selected="">{{ $users->SmscId }}
                                        </option>


                                        {{-- <option value="{{ $users->Id }}">{{ $users->SmscId }} </option> --}}


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>RATIO </label>
                                    <select name="Ratio" class="form-control" required="">
                                        {{-- <option value="">{{ $users->Ratio }}</option> --}}
                                        <option value="" selected="">{{ $users->Ratio }}% </option>
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
                                        @if( $users->Status  == 1)
                                        <label>
                                            <input type="radio" name="Status" value="1" checked>
                                            Active </label>
                                            <label>
                                                <input type="radio" name="Status" value="0">
                                                De-active </label>
                                            @else
                                            <label>
                                                <input type="radio" name="Status" value="1">
                                                Active </label>
                                            <label>
                                            <input type="radio" name="Status" value="0" checked>
                                            De-active </label>
                                            
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                      <label>Session ReStart</label>
                                    <div class="radio">
              
                                      <label>
                                        <input type="radio" class="minimal" name="RSession" value="1" >ReStart Sessions                        
                                      </label>
              
                                      <label>
                                        <input type="radio" class="minimal" name="RSession" value="0" checked=""> Still Connected
                                      </label>
                                  </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                     <label>Is Approved Sender ID</label>
                                   <div class="checkbox">
                                       <label><input type="checkbox" name="IsApprovedSender" value="1" <?php if($users->IsApprovedSender=='1'){ echo "checked";}?>  >Is Approved</label>
                                   </div>
                                  
                                 </div>
                             </div>
                            <div class="col-md-12">
                                <hr />
                            </div>
                            <div class="col-md-12">
                                <h4 class="mt-10 mb-10"> Personal Details(MIS)</h4>
                            </div>

                            <div class="box-body">
                                
                                      
                                        <input type="hidden" name="id" value="{{ $users->Id }}"
                                            class="form-control" placeholder="Enter Username">
                                            
                                   
                                </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Fullname</label>
                                    <input type="text" name="Fullname" class="form-control" value="{{ $users->Fullname }}"
                                        placeholder="Enter Fullname">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Mobile</label>
                                    <input type="text" name="Mobile" class="form-control" value="{{ $users->Mobile }}"
                                        placeholder="Enter Mobile">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Username(MIS)</label>
                                    <input type="text" name="UsernameMIS" class="form-control"
                                        value="{{ $users->Username }}" placeholder="Enter Username" required=""
                                        id="UsernameMIS">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Email</label>
                                    <input type="Email" name="Email" class="form-control"
                                        placeholder="Enter Email" value="{{ $users->Email }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Company/Organization</label>
                                    <input type="text" name="CompanyOrganization" class="form-control"
                                        placeholder="Enter Company Organization Name"
                                        value="{{ $users->CompanyOrganization }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>City</label>
                                    <input type="text" name="City" class="form-control"
                                        placeholder="Enter City" value="{{ $users->City }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>State</label>
                                    <input type="text" name="State" class="form-control"
                                        placeholder="Enter State" value="{{ $users->State }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Country</label>
                                    <input type="text" name="Country" class="form-control"
                                        placeholder="Enter Country" value="{{ $users->Country }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group ">
                                    <label>Address</label>
                                    <textarea name="Address" class="form-control" rows="1" placeholder="Enter Address"
                                        value="">{{ $users->Address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Status(MIS)</label>
                                    <div class="radio">
                                        @if( $users->Status  == 1)
                                        <label>
                                            <input type="radio" name="StatusMIS" value="1" checked>
                                            Active </label>
                                            <label>
                                                <input type="radio" name="StatusMIS" value="0">
                                                De-active </label>
                                            @else
                                            <label>
                                                <input type="radio" name="StatusMIS" value="1">
                                                Active </label>
                                            <label>
                                            <input type="radio" name="StatusMIS" value="0" checked>
                                            De-active </label>
                                            
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 mt-20">
                            {{-- <input type="submit" name="submit" class="btn btn-primary" value="submit"> --}}
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </form>
                    <div class="cl"></div>
                </div>
            </div>
        </div>

    </section>
</section>
@include('footer')
