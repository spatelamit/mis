@include('header')

</header>


<section id="main-content">
<section class="wrapper">
 <div class=" market-updates">




        
         <div class="stats-info-agileits"> 
            <div class="table-responsive ">
                <h4 class="mb-15">SMPP Users Controller History</h4>
                <table id="example" class="table table-bordered table-striped responsive display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Username</th>
                            <th>Date Time</th>
                            <th>IP</th>
                            <th>Link</th>
                            <th>Content</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->Username }}</td>
                                <td>{{ $log->DateTime }}</td>
                                <td>{{ $log->Ip }}</td>
                                <td>{{ $log->Link }}</td>
                                <td>{{ $log->Content }}</td>
                                <td>{{ $log->Status}}</td>
                                 
                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
            </div>
            
            {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
       

</div>
</section>
</section>
{{-- table design end --}}
@include('footer')
