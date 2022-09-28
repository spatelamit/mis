<?php
$Submit = 0;
$Delivered  =0;
$Pending  =0;
$Failed  =0;

    foreach ($RepushData['RepushCounts'] as $key => $value) {
     
        $Submit +=$value->Count;

        if($value->dlr_mask==1){
            $Delivered = $value->Count;
        }
        if($value->dlr_mask==2 OR $value->dlr_mask==16){
            $Failed += $value->Count;
        }
     
        if($value->dlr_mask==8  OR $value->dlr_mask==923){
            $Pending += $value->Count;
        }
   }
    $Statics = array(
        'Submit'=>$Submit,
        'Delivered'=>$Delivered,
        'Failed'=>$Failed,
        'Pending'=>$Pending
    );
?>
    <div class="row"> 
        <div class="col-md-6"> 
            <!-- DONUT CHART -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Statics</h3>
                </div>
                <div class="box-body chart-responsive">
                    <p style="font-size: 18px; font-weight: bold">
                    Submit : {{ $Statics['Submit'] }} | Delivered : {{ $Statics['Delivered'] }} | Failed : {{  $Statics['Failed'] }} | Pending : {{ $Statics['Pending'] }}</p>

                    <div class="chart" id="myChart" style="height: 300px; position: relative;"></div>


                </div>
            
            </div>
        </div>
        @if(count($RepushData['RepushCounts']) != 0)
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Re Push Selected Data</h3>
                </div>
                <form action="javascript:void(0)" method="POST" >
                    <div class="box-body">
        
                        <input type="hidden" name="ReUsername" value="{{ $RepushData['RepushEnquire']->Username }}">
                        <input type="hidden" name="ReStartDate" value="{{ $RepushData['RepushEnquire']->startDate }}">
                        <input type="hidden" name="ReEndDate" value="{{ $RepushData['RepushEnquire']->endDate }}">

  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select MO/MT</label>
                                    <select class="form-control select2"  name="MOMT" id="MOMT" required="">
                                        <option value="">Select</option>
                                        <option value="MT">MT</option>
                                        <option value="MO" selected="">MO</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Limit</label>
                                <input type="text" name="Limit" class="form-control"  placeholder="Enter Limit" value="">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Sender</label>
                                <input type="text" name="ReSender" class="form-control"  placeholder="Enter Sender" value="{{ $RepushData['RepushEnquire']->sender}}">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Mobile</label>
                                <input type="text" name="ReReceiver" class="form-control"  placeholder="Enter Mobile" value="{{ $RepushData['RepushEnquire']->receiver }}">
                            </div>
                        </div>  
                        <div class="col-md-6" id="RouteDiv">
                            <div class="form-group ">
                                <label>Select Smsc</label>
                                <select name="SMSC" class="form-control"  id="ReSmscId">
                                    <option value="" >All SMSC</option>
                                    @foreach($SmscList as $key => $value)
                                    <?php
                                    $select = '';
                                        if($RepushData['RepushEnquire']->SmscId == $value->SmscId){
                                            $select = 'Selected';
                                        }
                                    ?>
                                    <option  value="{{ $value->SmscId }}" {{$select}} >{{ $value->SmscId }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="RouteDiv">
                            <div class="form-group ">
                                <label>Dlr Mask</label>
                                <select name="dlr_mask" class="form-control"  id="ReSmscId">
                                    <option  value="1" selected>Make Delivered</option>
                                    <option  value="2">Make Failed</option>
                                    <option  value="0">Original</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" name="Repush" value="Push" class="btn btn-primary mt25" id="Repush">
                        </div>
                    </div>
                </form>
                <div id="PushSuccessBox"></div>

            </div>
        </div>
        @else
        <h2>No Data is there</h2>
        @endif
    </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    const config = {
      type: 'pie',
      data: {
        labels: [
            'Red',
            'Blue',
            'Yellow'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
          }]
        },
    };
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, config);

</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#Repush").click(function(){
        if($('#MOMT').val()!==""){
            if($('#MOMT').val()=="MT"){
                if($('#SmscId').val()==""){
                    alert('Select SMSC NAME FIRST ');
                    return false;
                }

            }


            // $("#Repush").attr('disabled','disabled');   
            // $("#Repush").attr('value','Pushing...');   

            $.ajax({
                type: 'POST',
                url: '<?php echo 'pushselecteddata';?>',
                data: $('form').serialize(),
                success: function (data) {
                    $("#PushSuccessBox").html(data);
                     //$("#Repush").prop('disabled', false);
                    $("#Repush").attr('value','Pushed Successfully'); 
                }
            });
        }

    });
});

</script>
 
      

