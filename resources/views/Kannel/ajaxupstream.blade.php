<?php


$url ='http://10.10.2.44:13000/status.xml?password=foobar';

$curl2 = curl_init();
curl_setopt_array($curl2, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
]);
$resp2 = curl_exec($curl2);
curl_close($curl2);

$xml   = simplexml_load_string($resp2);
$array = json_decode(json_encode((array) $xml), true);
$array = array($xml->getName() => $array);
$smscs = $array['gateway']['smscs']['smsc'];

$i = 0;

$main=array();
// echo "<pre>";
// print_r($smscs);
//     die();
foreach ($smscs as $value) {
    $main[$value['id']]['name']=$value['id'];
    $main[$value['id']]['Ip'] =$value['name'];
    $main[$value['id']]['Status'] =$value['status'];
    if(!isset($main[$value['id']]['Session'])){
        $main[$value['id']]['Session'] = 0;
    }
    $main[$value['id']]['Session']+=1;
    if(!isset($main[$value['id']]['Sent'])){
        $main[$value['id']]['Sent'] = 0;
    }
    if(!isset($main[$value['id']]['Received'])){
        $main[$value['id']]['Received'] = 0;
    }
    if(!isset($main[$value['id']]['Failed'])){
        $main[$value['id']]['Failed'] = 0;
    }
    if(!isset($main[$value['id']]['Queue'])){
        $main[$value['id']]['Queue'] = 0;
    }

    $main[$value['id']]['Sent']+=$value['sms']['sent'];
    $main[$value['id']]['Received']+=$value['dlr']['received'];
    $main[$value['id']]['Failed']+=$value['failed'];
    $main[$value['id']]['Queue']+=$value['queued'];
    $TXD = explode(':', $value['name']);
 
    foreach ($TXD as $key => $val) {
        if ($key == 2) {
            $ifTx = explode('/',  $val);
           
        }
        
    }
    
    
    $ifTx = explode('/',  explode(':', $value['name'])[2]);

    if($ifTx[1]==0){
        if(!isset($main[$value['id']]['Tx'])){
            $main[$value['id']]['Tx'] = 0;
        }
        $main[$value['id']]['Tx']+=1;
    }else if($ifTx[0]==0){
        if(!isset($main[$value['id']]['Rx'])){
            $main[$value['id']]['Rx'] = 0;
        }
        $main[$value['id']]['Rx']+=1;
    }else{
        if(!isset($main[$value['id']]['TRx'])){
            $main[$value['id']]['TRx'] = 0;
        }
        $main[$value['id']]['TRx']+=1;
    }
    if(!isset($main[$value['id']]['outbound'])){
        $main[$value['id']]['outbound'] = 0;
    }
    if(!isset($main[$value['id']]['inbound'])){
        $main[$value['id']]['inbound'] = 0;
    }

    $main[$value['id']]['outbound']+= explode(',', $value['sms']['outbound'])[0];
    $main[$value['id']]['inbound']+= explode(',', $value['dlr']['inbound'])[0];
}


$prices = array_column($main, 'Sent');
array_multisort($prices, SORT_DESC, $main);



// echo "<pre>";
// print_r($main);
// die;

?>


<div class="box-header with-border heading">
  
    <div class="row">
        <div class="col-md-12">
            <h2> Upstream </h2>
        </div>
  
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p> Overall (TPS) MT : {{ explode(',',  $array['gateway']['sms']['outbound'])[0] }} /s</p>
        </div>
  
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p align="left"> MO : {{ explode(',',  $array['gateway']['dlr']['inbound'])[0] }} /s</p>
        </div>
  
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p>AMQPBOX : 
                @if(isset($array['gateway']['boxes']['box']['status']))
                    @if(strpos($array['gateway']['boxes']['box']['status'], 'on-line') !== false)
                        <small class=" btn-success p-1-3"> Online </small>
                    @else
                        <small class=" btn-danger p-1-3"> Disconnected +</small>
                    @endif
                @else
                    No Connection
                @endif
            </p>
        </div>
  
        <div class="col-md-6 col-sm-6 col-xs-12">
            <p> Overall MT Queue : 
                <strong class='btn-danger p-1-3'>
                    @if(isset($array['gateway']['boxes']['box']['queue']))
                        {{ $array['gateway']['boxes']['box']['queue'] }}
                    @endif
                </strong>
            </p>
        </div>
  
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="text-center">
                <p>Final DLR Queue :
                    <strong class=' btn-danger p-1-3'> 
                        {{ $array['gateway']['dlr']['queued'] }}
                    </strong>
                </p>
            </div>
        </div>
    </div>
</div>



<table id="example1" class=" table table-bordered table-striped responsive">
    <thead>
        <tr>
            <th>Name/Ip</th>
            <th>Session</th>
            <th>Queue</th>
            <th>TPS</th>
        </tr>
    </thead>
    <tbody>
        @if($main!="")
        @foreach ($main as $key => $value) 
            
        <tr>
            <td class="col-md-5 col-xs-5 pmy-0"> 
                <p>
                    {{ $value['name'] }} - 
                    <?php
                        $ipip = explode(":", $value['Ip']);
                        $allSmscs[] = $value['name'];
                        if(isset($ipip[3])){
                            print_r($ipip[3]);
                        }   
                    ?>
                    @if(explode(' ', $value['Status'])[0]=="online")  
                    <small class="btn-success p-1-3">online</small>                       
                    @else 
                        {{ $value['Status'] }}
                    @endif
                </p>
                <p>
                @if(isset($ipip[1]))
                    {{ $ipip[1] }}
                @endif
                 : 
                @if(isset($ipip[2]))
                    {{ $ipip[2] }}
                @endif
               </p>
                
            </td>




            <td class="col-md-2 col-xs-2">
                @if(isset($value['TRx'])) 
                    TRx: {{ $value['TRx'] }}
                @else
                    Tx: {{ $value['Tx'] }} <br> Rx: {{ $value['Rx'] }}
                @endif       
            </td>

                 
            <td class="col-md-3 col-xs-3" style="color:orange;">
                @if($value['Queue']==0)
                    {{ $value['Queue'] }} 
                @else 
                    <strong>{{ $value['Queue'] }}</strong>
                @endif
            </td>
                    
            <td class="col-md-2 col-xs-2">
                MT : {{ $value['outbound'] }}<br>MO : {{ $value['inbound'] }}
            </td>
        </tr>
        @endforeach
        @endif


    </tbody>
</table>

<strong>
    <?php echo(implode(',', $allSmscs)); ?>
</strong>