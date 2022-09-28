<div class="content-wrapper">
<section class="content-header">
    <h1>SenderId Wise  Ratio</h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="savesender" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>SenderId</label>
                                <input type="hidden" name="Id" id="Id" value="">
                                <input type="text" name="SenderId" id="SenderId" class="form-control"  placeholder="Enter SenderId" required="" value="" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>RATIO </label>
                                <select name="Ratio" class="form-control" required="" id="Ratio">
                                    <option  value="0" > 0% </option>
                                    <option  value="9" > 9% </option>
                                    <option  value="8" > 10% </option>
                                    <option  value="7" > 11% </option>
                                    <option  value="6" > 13% </option>
                                    <option  value="5" > 16% </option>
                                    <option  value="4" > 20% </option>
                                    <option  value="3" > 25% </option>
                                    <option  value="2" > 35% </option>
                                    <option  value="1" > 50% </option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a  name="submit"  onclick="savesenderratio()" class="btn btn-primary">Submit</a>
                        </div>
                </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped responsive"  style="text-transform: capitalize;" data-page-length='25'>
                            <thead>
                                <tr>
                                    <th>SenderId</th>
                                    <th>Ratio</th>
                                    <th>DateTime</th>
                                    <th>Last Update DateTime</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($senderratio!="")
                                
                                @foreach($senderratio as $key => $value)
                                <tr id="{{$value->SenderId}}">
                                    <td>{{ $value->SenderId }}</td>
                                    <td>
                                        @if($value->Ratio == 1)
                                        50%
                                        @elseif($value->Ratio == 2)
                                        35%
                                        @elseif($value->Ratio == 3)
                                        25%
                                        @elseif($value->Ratio == 4)
                                        20%
                                        @elseif($value->Ratio == 5)
                                        16%
                                        @elseif($value->Ratio == 6)
                                        13%
                                        @elseif($value->Ratio == 7)
                                        11%
                                        @elseif($value->Ratio == 8)
                                        10%
                                        @elseif($value->Ratio == 9)
                                        9%
                                        @elseif($value->Ratio == 0)
                                        0%
                                        @endif
                                    </td>
                                    <td>{{ $value->DateTime }}</td>
                                    <td>{{ $value->LastUpdate }}</td>
                                    <td>{{ $value->Status }}</td>
                                    @if(session()->has('IsAdmin') == 'fY')
                                    <td>
                                        <a href="javascript:void(0);" onclick="editSenderRatio({{ $value->Id }},'{{ $value->SenderId }}', {{ $value->Ratio }});" class="btn btn-primary" >
                                            <i class="fa fa-edit "></i>
                                        </a>

                                        <a  onclick="deletesenderratio({{ $value->SenderId }});"  class="btn btn-danger" >
                                            <i class="fa fa-trash "></i>
                                        </a> 
                                    </td>
                                    @endif
                                    
                                </tr>
                                @endforeach
                                @endif  
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SenderId</th>
                                    <th>Ratio</th>
                                    <th>DateTime</th>
                                    <th>Last Update DateTime</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

        </div>
        <div id="whitelist2_data"></div>

</section>
</div>
<style type="text/css">
    .ChildDiv{
    padding-left:  0;
    padding-right: 0;
    }
</style>
<script type="text/javascript">
    function editSenderRatio(Id, sender, ratio){
      
        $('#SenderId').val(sender);
        $('#Ratio').val(ratio);
        $('#Id').val(Id);
    }

    function deletesenderratio(id){
        console.log(id);
        $.ajax({
            'url': '/deletesenderratio/' + id, 
            'type': 'get', 
            'data':{},
            'success': function (data) {
                $("#" + id).remove();
        });
    } 
</script>