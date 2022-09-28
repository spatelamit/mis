@include('header')

</header>


<section id="main-content">
<section class="wrapper">

<div class=" market-updates">


{{-- table design end --}}



<div class="stats-info-agileits"> 
<form method="POST" action="{{url('/import-csv')}}" enctype="multipart/form-data">
          @csrf          
    <div class="row">
    
    <div class="col-md-3">
    <input type="file" id="real-file" hidden="hidden" name="file">
    </div>
    
    <div class="col-md-4">
     <button type="submit" class="btn btn-primary">Upload CSV</button>
    </div>
    
    
      
     
      <!-- <span id="custom-text">No file chosen, yet.</span>  -->
    </div>

</form>
</div>


<div class="stats-info-agileits mt-20"> 
<div class="table-responsive ">
                <h4 class="mb-20">Dlt Mmq Operator</h4>
                <table id="example" class="table table-bordered table-striped responsive display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Sender</th>
                            <th>PE_ID</th>
                            <th>Template_ID</th>
                            <th>Content</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->Sender }}</td>
                                <td>{{ $log->PE_ID }}</td>
                                <td>{{ $log->Template_ID }}</td>
                                <td>{{ $log->Content }}</td>
                               
                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
</div>


        
            
            {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
       
</div>

</div>
</section>
</section>
{{-- table design end --}}
@include('footer')
