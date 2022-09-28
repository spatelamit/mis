@include('header')

<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">View SMSC's</a></li>

        </ul>
    </div>
</div>
<div class="top-nav clearfix">
    <ul class="nav pull-right top-menu">
        <li>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="http://mis.secureip.in/assets/images/user-png.png">
                <span class="username"> {{ session()->get('Name') }}</span>
                <b class="caret"></b>
            </a>
        </li>
    </ul>
</div>
</header>

<section id="main-content">
    <section class="wrapper">




        <div class="market-updates">



            <div class="stats-info-agileits">

                <h4 class="mb-5">Smsc's (Routes) </h4>
                <div class="row">



                    <form role="form" action="/smscsave" method="post">
                        @csrf

                        <div class="col-md-2">
                            <div class="form-group ">
                                <label>Smsc's</label>
                                <input type="text" name="SmscId" class="form-control" placeholder="Enter Smsc name"
                                    value="" pattern=".{0}|.{5,15}" required title="Either 0 OR (5 to 15 chars)">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group ">
                                <label>Route Category</label>
                                <select name="routeCategory" class="form-control">
                                    <option value="Transactional" selected="">Transactional</option>
                                    <option value="Promotional">Promotional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label>Description's</label>
                                <input type="text" name="Description" class="form-control"
                                    placeholder="Enter Description" value="" required="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group ">
                                <label>Is Mix Routing</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="IsMixRouting" id="IsMixRouting"
                                            value="1">Is Mix Routing</label>
                                </div>
                            </div>
                            <div class="form-group" id="SelectMixBox" style="display: none;">
                                <label>Mix The Route</label>
                                <select name="MixRoutes[]" class="form-control" multiple>
                                    <option value="">Select SMSC</option>
                                    @foreach ($smsclist as $key)
                                        <option value="{{ $key->SmscId }}">{{ $key->SmscId }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group ">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="Status" value="1" checked="">Active
                                    </label>

                                    <label>
                                        <input type="radio" name="Status" value="0">
                                        De-active
                                    </label>
                                </div>
                            </div>

                        </div>





                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <!-- /.box -->

                </div>



            </div>

            <div class="stats-last-agile mt-20">



                <table id="example" class="table table-bordered table-striped responsive" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>SmscId</th>
                            <th>Description</th>
                            <th>DateTime</th>
                            <th>LastUpdate</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($smsclist as $val)
                            <tr id="{{ $val->Id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $val->SmscId }}</td>
                                <td>{{ $val->Description }}</td>
                                <td>{{ $val->DateTime }}</td>
                                <td>{{ $val->LastUpdate }}</td>



                                <td>
                                    <a data-target="#updatesmsc{{ $val->Id }}" data-toggle="modal" class="btn btn-primary"><i
                                            class="fa fa-edit "></i></a>
                                    <a href="{{ 'deletesmsc/' . $val->Id }}"  class="btn btn-danger"><i
                                            class="fa fa-trash "></i></a>

                                            

                                    {{-- model start --}}

                                    <div class="modal fade  come-from-modal right" id="updatesmsc{{ $val->Id }}"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">



                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Update SMSC </h4>
                                                </div>



                                                <div class="modal-body">
                                                    <form  action="{{'updatesmsc'}}" method="POST">

                                                        @csrf
                                                        <div class="box-body">
                                        
                                                       
                                                        <div class="col-md-6">
                                                          <div class="form-group ">
                                                            <label>SMSC ID</label>
                                                            <input type="hidden" name="Id" value="{{ $val->Id }}">
                                                            <input type="text" name="SmscId" class="form-control" placeholder="Enter Username" required="" value="{{ $val->SmscId }}">
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group ">
                                                            <label>Route Category</label>
                                                            <select name="routeCategory" class="form-control">
                                                                <option value="{{ $val->routeCategory }}" selected="">Transactional</option>
                                                               <option value="Transactional">Transactional</option>
                                                               <option value="Promotional">Promotional</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group ">
                                                            <label>Description </label>
                                                            <input type="text" name="Description" class="form-control" placeholder="Enter Description" value="{{ $val->Description }}">
                                                          </div>
                                                        </div>  
                                        
                                                        <div class="col-md-6">
                                                           <div class="form-group">
                                                                <label>Status</label>
                                                                <div class="radio">
                                                                    @if( $val->Status  == 1)
                                                                    <label>
                                                                        <input type="radio" name="Status" value="1" checked>
                                                                        Active </label>
                                                                        <label>
                                                                            <input type="radio" name="Status" value="0">
                                                                            De-active </label>
                                                                        @else
                                                                        <label>
                                                                            <input type="radio" name="Status" value="1">
                                                                            Active </label>
                                                                        <label>
                                                                        <input type="radio" name="Status" value="0" checked>
                                                                        De-active </label>
                                                                        
                                                                        @endif
                                                                </div>
                                        
                                        
                                        
                                                      
                                                      </div>
                                        
                                        
                                                      <div class="box-footer">
                                                        <input type="submit"  class="btn btn-primary">
                                                      </div>
                                        
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


        </div>
        </div>










    </section>
</section>

<script type="text/javascript">
    // $(document).ready(function(){
    //       $('#IsMixRouting').change(function(){
    //         if($('#IsMixRouting').val()=="1"){
    //         $('#SelectMixBox').hide();    
    //         }else{
    //           $('#SelectMixBox').show();    
    //         }

    //     });




    //   });

    $(document).ready(function() {
        $('#IsMixRouting').click(function() {
            if ($(this).prop("checked") == false) {
                $('#SelectMixBox').hide();
            } else if ($(this).prop("checked") == true) {
                $('#SelectMixBox').show();
            }
        });
    });
</script>
<script type="text/javascript">
    function SmscDelete(id) {

        $.ajax({
            'url': '/deletesmsc/' + id,
            'type': 'get',
            'data': {},
            'success': function(response) {

                $("#" + id).remove();
            }
        });


    }
</script>
@include('footer')
