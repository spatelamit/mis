@include('header')
<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">Add Users</a></li>
            <li><a href="#tab-2" data-toggle="tab">Users List</a> </li>
            <li><a href="#tab-3" data-toggle="tab">Routing</a></li>


            <!-- <li><a onclick="getSmppTab('addUsers')">Add Users</a> </li>
            <li><a onclick="getSmppTab('usersList')">Users List</a></li>
            <li><a onclick="getSmppTab('routing')">Routing</a></li> -->
        </ul>
    </div>
</div>
</header>

<section id="main-content">
    <section class="wrapper">

        <div class="tab-content">
            <div class="tab-pane active" id="tab-1">

                <div class="market-updates">
                    <div class="stats-info-agileits">

                        <h4 class="mb-20">Smpp Users Balance</h4>

                        <div class="table-responsive ">
                            <table id="example" class="table table-bordered table-striped responsive display nowrap">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Username</th>
                                        <th>TotalBalance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $log->Username }}</td>
                                            <td>{{ $log->Credits }}</td>
                                            <td>
                                                <a class="btn btn-info" data-toggle="modal"
                                                    data-target="#Addbalance{{ $log->UserId }}">Add/Reduce Balance</a>





                                                <div class="modal fade  come-from-modal right"
                                                    id="Addbalance{{ $log->UserId }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">



                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"> Add / Reduce Balance </h4>
                                                            </div>



                                                            <div class="modal-body">
                                                                <form action="{{ url('updatebalance') }}"
                                                                    method="post">

                                                                    @csrf


                                                                    <input type="hidden" name="TotalBalance"
                                                                        value="{{ $log->Credits }}">
                                                                    <input type="hidden" name="MemberId"
                                                                        value="{{ $log->UserId }}">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group ">
                                                                            <label>Username/UserId</label>
                                                                            <input type="text" disabled=""
                                                                                name="Username" class="form-control"
                                                                                placeholder="Enter Username"
                                                                                value="{{ $log->Username }}" readonly>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Balance Type </label>
                                                                            <select name="FundType" class="form-control"
                                                                                required="">
                                                                                <option value="">Select</option>
                                                                                <option value="Add">(+) Add</option>
                                                                                <option value="Reduce">(-) Reduce
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group ">
                                                                            <label>Balance to be Add/Reduce</label>
                                                                            <input type="number" name="Balance"
                                                                                class="form-control"
                                                                                placeholder="Enter  Ex ₹ 10000 Balance"
                                                                                value="" required="">
                                                                        </div>
                                                                    </div>



                                                                    <div class="col-md-6">
                                                                        <div class="form-group ">
                                                                            <label>Date / Time(Optional)</label>
                                                                            <input type="text" name="DateTime"
                                                                                class="form-control"
                                                                                placeholder="YYYY-MM-DD H:i:s a"
                                                                                value="2022-08-29 05:01:43 pm">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-12">
                                                                        <div class="form-group ">
                                                                            <label>Description</label>
                                                                            <textarea name="Description" class="form-control" rows="2" placeholder="Enter Description"></textarea>
                                                                        </div>
                                                                    </div>




                                                                    <div class="col-md-12 mb-20 text-right">
                                                                        <button type="submit"
                                                                            class="btn btn-primary ">Submit</button>
                                                                    </div>
                                                                    <div class="cl"></div>
                                                                </form>
                                                            </div>
                                                            <div class="cl"></div>
                                                        </div>
                                                    </div>
                                                </div>




                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                        {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}

                        {{-- table design end --}}

                    </div>
                </div>



                <div class="stats-info-agileits mt-20">
                    <h4> Total Available Balance : ₹ 7,354,936.00</h4>
                </div>


                <div class="stats-info-agileits mt-20">

                    <h4 class="mb-20"> Balance Add / Reduce </h4>


                    <div class="cl"></div>

                </div>






                <script type="text/javascript">
                    function userbalance(UserId) {
                        $.ajax({
                            type: "GET",
                            url: "userbalance/" + UserId,
                            success: function(msg) {
                                console.log(msg);
                                $("#modal-balance").html(msg);
                            }
                        });
                    }
                </script>


            </div>


            <div class="tab-pane" id="tab-2">




            </div>
        </div>





        </div>





    </section>
</section>

@include('footer')
