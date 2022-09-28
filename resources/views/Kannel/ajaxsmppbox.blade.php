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



<div class="box-header with-border">
    <div class="col-md-12">
        <h2> SmppBox User's </h2>
    </div>
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