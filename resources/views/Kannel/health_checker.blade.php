<?php 
    $main=array();
    $time = array();
    foreach ($data as $value) {
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
