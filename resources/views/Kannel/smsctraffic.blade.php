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
                        @if(isset($data)) 
                        @foreach($data as $key => $value)  
                        <?php 
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