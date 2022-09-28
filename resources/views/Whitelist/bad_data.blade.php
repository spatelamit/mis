@include('header')

</header>


<section id="main-content">
    <section class="wrapper">
        <div class=" market-updates">
            <div class="stats-info-agileits">
                <div class="table-responsive ">
                    {{-- <form action="">
                        <input class="form-control" type="mobile" name="mobile" placeholder="917697588851"> &nbsp;
                        
                        <button type="submit" class="btn btn-info">Submit</button>
                      </form> --}}
                    <h4 class="mb-15">Bad Data Collection</h4>
                    <table id="example" class="table table-bordered table-striped responsive display nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Number</th>
                                <th>Error Code</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($baddata as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->mobile }}</td>
                                    <td>{{ $log->code }}</td>

                                    <td>
                                        <a href="{{ 'deletebaddata/' . $log->mobile }}"  class="btn btn-danger"><i
                                            class="fa fa-trash "></i></a>
                                    </td>

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
