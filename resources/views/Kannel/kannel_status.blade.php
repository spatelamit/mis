@include('header')
<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li  class="active" ><a  href="#tab-1"  data-toggle="tab" >smppbox</a></li>
            
            <li><a href="#tab-2"  data-toggle="tab" >Operator Health</a> </li>
            <li><a  href="#tab-3"  data-toggle="tab"  >Kannel</a></li>
            <li><a  href="#tab-4"  data-toggle="tab" > Kannel Monitor </a></li>
            <li><a href="#tab-5"  data-toggle="tab" > SMSC's Traffic</a></li>
            <li><a href="#tab-6"  data-toggle="tab" >SenderId Traffic</a></li>
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
            <span class="username">{{ session()->get('Name') }}</span>
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
    </ul>
</div>
</header>
<section id="main-content">
    <section class="wrapper">
        <div class="tab-content">

            <div class="tab-pane active" id="tab-1" >
                <?php
                    $url =  "http://10.10.2.61:14000/status.xml?password=foobar";
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $url,
                        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
                    ]);
                    $resp = curl_exec( $curl);
                    $resp  = json_encode($resp);
                    $resp  = str_replace(";", "", $resp);
                    $resp  = str_replace("&", "", $resp);
                    $resp  = json_decode($resp);
                    $xml   = simplexml_load_string($resp);
                    $array = json_decode(json_encode((array) $xml), true);
                    $array = array($xml->getName() => $array);
                    
                    $smpps = $array['gateway']['sessions']['session'];
                    
                    $i = 0;
                    
                    $main=array();
                    $ips = array();
                    foreach ($smpps as $value) {
                        
                        $main[$value['esme']]['name']=$value['esme'];
                        $main[$value['esme']]['Ip'] =$value['ip'];
                        $ips[] = $value['ip'];
                    
                        $main[$value['esme']]['Status'] =$value['status'];
                        
                        if (!isset($main[$value['esme']]['Session'])) {
                            $main[$value['esme']]['Session'] = 0;
                        }
                        $main[$value['esme']]['Session']+=1;
                        
                    
                        if($value['type']=='trans'){
                            if (!isset($main[$value['esme']]['Tx'])) {
                                $main[$value['esme']]['Tx'] = 0;
                            }
                            if (!isset($main[$value['esme']]['MT'])) {
                                $main[$value['esme']]['MT'] = '0';
                            }
                    
                            $main[$value['esme']]['Tx']+=1;
                            $main[$value['esme']]['MT']+=explode(' ', $value['status'])[16];
                        }
                        elseif($value['type']=='recv'){
                    
                            if (!isset($main[$value['esme']]['Rx'])) {
                                $main[$value['esme']]['Rx'] = 0;
                            }
                            if (!isset($main[$value['esme']]['MO'])) {
                                $main[$value['esme']]['MO'] = '0';
                            }
                            $main[$value['esme']]['Rx']+=1;
                            $main[$value['esme']]['MO']+=explode(' ', $value['status'])[19];
                        }else{
                            if (!isset($main[$value['esme']]['TRx'])) {
                                $main[$value['esme']]['TRx'] = 0;
                            }
                            if (!isset($main[$value['esme']]['MTMO'])) {
                                $main[$value['esme']]['MTMO'] = '0';
                            }
                            $main[$value['esme']]['TRx']+=1;
                            $main[$value['esme']]['MTMO']+=explode(' ', $value['status'])[16]+explode(' ', $value['status'])[19];
                        }
                        
                        // 
                        if (!isset($main[$value['esme']]['Queue'])) {
                            $main[$value['esme']]['Queue'] = 0;
                        }
                        if (!isset($main[$value['esme']]['received'])) {
                            $main[$value['esme']]['received'] = 0;
                        }
                        $main[$value['esme']]['Queue']+=explode(' ', $value['status'])[13];
                        $main[$value['esme']]['received']+=intval(explode(' ', $value['status'])[3]);    
                           
                    }
                    
                    $prices = array_column($main, 'received');
                    array_multisort($prices, SORT_DESC, $main);
                    ?>
                <div class="box-header with-border tab-pane active" id="tab-1">
                    <div class="col-md-12">
                        <h2> SmppBox User's </h2>
                    </div>
                    <table id="example1" class="table table-bordered table-striped responsive"  style="text-transform: capitalize;" data-page-length='25'>
                        <thead>
                            <tr>
                                <th>Name/Ip</th>
                                <th>Status</th>
                                <th>Session</th>
                                <th>Queue(MO)</th>
                                <th>TPS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($main as $key => $value)
                            <tr>
                                <td>{{ $value['name'] }}<br> {{ $value['Ip'] }}</td>
                                <td>
                                    @if(explode(' ', $value['Status'])[0]=="online")
                                    <small class="btn-success">{{ explode(' ', $value['Status'])[0] }}</small>
                                    @else
                                    <small class="btn-danger">{{ explode(' ', $value['Status'])[0] }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['TRx']))
                                    TRx: {{$value['TRx']}}
                                    @elseif(isset($value['Rx']))
                                    Rx: {{$value['Rx']}}
                                    @else
                                    TRx: 0 <br> Rx: 0
                                    @endif       
                                </td>
                                <td style="color:orange;">
                                    @if($value['Queue'] == 0)
                                    {{$value['Queue']}}
                                    @else
                                    <strong style="font-size: 22px">{{$value['Queue']}}</strong>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['MT']))
                                    MT : {{$value['MT']}}
                                    @elseif(isset($value['MO']))
                                    MO : {{$value['MO']}} 
                                    @elseif(isset($value['MTMO']))
                                    MTMO : {{$value['MTMO']}} 
                                    @else
                                    MT : 0 <br> MO : 0 
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <pre>
                            

                            <?php 
                        $ip = array_unique($ips);
                        foreach ($ip as $key => $value) {
                            echo $value."\n";
                        }
                        echo "Total IP - ". count($ip);
                        ?>
                        </pre>
                </div>
            </div>
            
            <div class="tab-pane " id="tab-2" >
                <?php 
                    $main=array();
                    $time = array();
                    foreach ($data['operator_health'] as $value) {
                        $main[$value->smsc_id]['label']=$value->smsc_id;
                        $main[$value->smsc_id]['fill']=false;
                    
                        //celetrans;strssmpp;strssmpp3;ILDOIND;MOINT;
                        //Mayanktglo;dev-ipmsg;fake_0;ipmsg;otpsim;Airtel_srts;Celetelcy 
                    
                        if($value->smsc_id == "strssmpp"){
                          $color = "green";
                        }elseif($value->smsc_id=="celetrans"){
                          $color = "blue";
                        }elseif($value->smsc_id=="strssmpp3"){
                          $color = "red";
                        }elseif($value->smsc_id=="ILDOIND"){
                          $color = "magenta";
                        }elseif($value->smsc_id=="Celetelcy"){
                          $color = "purple";
                        }elseif($value->smsc_id=="Shiv1"){
                          $color = "yellow";
                        }else{
                          $color = "grey";
                        }
                    
                        $main[$value->smsc_id]['borderColor']=$color;
                        $main[$value->smsc_id]['data'][]=$value->avrg;
                        $time[] =  $value->datetime;
                    }
                    
                    
                    
                    $graphdata = array();
                    foreach ($main as $key => $val) {
                        $graphdata[] = $val;
                    }
                    
                    $graphdata = json_encode($graphdata, JSON_PRETTY_PRINT);
                    $time = array_unique($time);
                    foreach ($time as $key => $value) {
                        $graphtime[] = date("H:i", $value);
                    }
                    ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <strong>
                        X Axis  = Time every 5 minutes |  Y Axis  = seconds Delay in Delivery  | Last 4 Hours reports 
                        </strong>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <a href="?day" class=" btn-success">Full Day</a>
                                <a href="health_checker" class=" btn-primary">Last Two Hour</a>
                                <a href="" class=" btn-warning">refresh</a>
                                <section class="content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <canvas id="myChart" style="width:90%; max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                <script>
                    var xValues = <?php echo json_encode($graphtime);?>;
                    new Chart("myChart", {
                        type: "line",
                        data: {
                          labels: xValues,
                          datasets: <?php echo $graphdata;?>
                        },
                        options: {
                          scales: {
                            xValues: {
                                type: 'time'
                            }
                          },
                           title: {
                            display: true,
                            text: ' Operator Health Monitor (lower line is best Operator) '
                          }
                        }
                    
                    });
                </script>
            </div>

            <div class="tab-pane" id="tab-3" >
                <div class="row active">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="stats-last-agile">
                            <div id="upstream"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="stats-last-agile">
                            <div id="smppbox"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="stats-last-agile">
                            <div id="rabbitmq" ></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        getResultUpstream();
                        setInterval("getResultUpstream()",10000);
                    });
                    function getResultUpstream(){   
                        jQuery.get("/ajaxupstream" ,function( data ) {
                            jQuery("#upstream").html(data);
                        });
                    }
                </script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        getResultSmppBox();
                        setInterval("getResultSmppBox()",20000);
                    });
                    function getResultSmppBox(){   
                        jQuery.get("/ajaxsmppbox" ,function( data ) {
                            jQuery("#smppbox").html(data);
                        });
                    }
                </script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        getResultRabbitMq();
                        setInterval("getResultRabbitMq()",30000);
                    });
                    function getResultRabbitMq(){   
                        jQuery.get("/ajaxrabbit" ,function( data ) {
                            jQuery("#rabbitmq").html(data);
                        });
                    }
                </script>
            </div>

            <div class="tab-pane " id="tab-4" >
            </div>
            
            <div class="tab-pane " id="tab-5" >
                <div class="content-wrapper">
                    <div>
                        <form id="smsc_data" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-3 ">
                                    <label>From :</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control" id="date" name="datetimes"  />
                                    </div>
                                </div>
                                <div class="form-group col-md-3 ">
                                    <a onclick="getsmscdata()" id="getsmscdata" class="btn btn-primary mt25">Get Record</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="" id="getsmsctrafic"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">SMSC History Count of Last Two Months</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example" class="table table-bordered table-striped" style="text-transform: capitalize;" data-page-length='25'>
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>SMSC's Name</th>
                                                <th>Submit</th>
                                                <th>Delivered</th>
                                                <th>Failed</th>
                                                <th>Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($data['smsc_data'])) 
                                            @foreach($data['smsc_data'] as $key => $value)  
                                            <?php 
                                                 $value->Sent;
                                                    $Submit = $value->Sent;
                                                    $Delivered = $value->Delivered;
                                                    $Failed = $value->Failed+$value->Reject;
                                                    $Sent = abs(($Delivered+$Failed)-$Submit);
                                                ?>       
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->Date }} </td>
                                                <td>{{ $value->SMSC_Name }}</td>
                                                <td>{{ $Submit }}</td>
                                                <td>{{ $Delivered }}</td>
                                                <td>{{ $Failed }}</td>
                                                <td>{{ $Sent }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>SMSC's Name</th>
                                                <th>Submit</th>
                                                <th>Delivered</th>
                                                <th>Failed</th>
                                                <th>Sent</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab-6" >
                <div class="content-wrapper">
                    <div class="form-group col-md-12">
                        <form id="sender_data" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-3 ">
                                <label>From :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control" id="date" name="datetimes"  />
                                </div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control select2" style="width: 100%;" name="type" id="type" required="">
                                        <option value="service">USER</option>
                                        <option value="smsc_id">OPERATOR</option>
                                               
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <a onclick="getsenderdata()" id="getsenderdata" class="btn btn-primary mt25">Get Record</a>
                            </div>
                        </form>
                    </div>
                    <div class="" id=""></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">SenderId Count</h3>
                                </div>
                                <div class="box-body" id="getsendertrafic">
                                    <table id="example" class="table table-bordered table-striped" style="text-transform: capitalize;" data-page-length='25'>
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>SMSC's Name</th>
                                                <th>Submit</th>
                                                <th>Delivered</th>
                                                <th>Failed</th>
                                                <th>Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($data['senderCounts'])) 
                                            @foreach($data['senderCounts'] as $key => $value)  
                                             <?php 
                                                 $value->Sent;
                                                    $Submit = $value->Sent;
                                                    $Delivered = $value->Delivered;
                                                    $Failed = $value->Failed+$value->Reject;
                                                    $Sent = abs(($Delivered+$Failed)-$Submit);
                                                 ?>       
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->type }} </td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $Submit }}</td>
                                                <td>{{ $Delivered }}</td>
                                                <td>{{ $Failed }}</td>
                                                <td>{{ $Sent }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>SMSC's Name</th>
                                                <th>Submit</th>
                                                <th>Delivered</th>
                                                <th>Failed</th>
                                                <th>Sent</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</section>
<script>
    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD hh:mm:ss A'
            }
        });
    });
</script>
@include('footer')
