<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://10.10.1.158:15672/api/queues');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_USERPWD, 'mautic' . ':' . 'Tfy@#92H');
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$result = json_decode($result, true);
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="col-md-12">
                    <h2> Rabbit MQ (Queue) </h2>
                </div>
                <div class="ul_list">
                    <ul>
                    @foreach ($result as $key => $value)
                    @if($value['messages']>10)   
                        <li>
                            <div class="Queue">
                                <h2>
                                    <span >Queue</span> : <span class="q_name"> {{ $value['name'] }}</span> 
                                    <span style="margin-left:10px;">msg's</span> : <span class="q_name">{{ $value['messages'] }} </span>
                                </h2>
                            </div>
                        </li>
                    @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>