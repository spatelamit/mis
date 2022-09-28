<?php error_reporting(0);?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="getsendertrafic">
                <div class="box-header">
                    <h3 class="box-title">Messages Summary's Only Date <?php echo date('Y-m-d'); ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example" class="table table-bordered table-striped responsive"  style="text-transform: capitalize;" data-page-length='25'>
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>{{ $data['col_name'] }}</th>
                                <th>Sender</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                                <th>Sent</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data['senderCounts']))
                            @foreach($data['senderCounts'] as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value['type'] }} </td>
                                <td>{{ $value['name'] }}</td>
                                <td>
                                    @if(isset($value['1']))
                                    {{ $value['1'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['2']))
                                    {{ $value['2']+$value['16'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if(isset($value['8']))
                                    {{ $value['8']+$value['923'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>