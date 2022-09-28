
<div class="content-wrapper">
    <section class="content">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title">All Summary History</h3>
            </div>
            <div class="box-body">

              
                <div class="table-responsive">
        			<table id="" class="table table-bordered table-striped "  style="text-transform: capitalize;" >
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Username</th>
                                <th>Date</th>
                                <th>Submit</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                                <th>Pending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $val->Username }}</td>
                                <td>{{ $val->Date }}</td>
                                <td>{{ $val->Submit }}</td>
                                <td>{{ $val->Delivered }}</td>
                                <td>{{ $val->Failed }}</td>
                                <td>{{ ($val->Submit) - ($val->Delivered + $val->Failed) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $data->withQueryString()->links('pagination::bootstrap-4') !!} 
            </div>
        </div>
    </section>
</div>