
<div class="content-wrapper">
    <section class="content">
        <div class="col-md-12">
            <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Delivery Reports
                    </h3>
                </div>
                <div class="box-body">
                    <form action="javascript:void(0)" id="DeliveryReportID" method="POST">
                        @csrf
                        <div class="col-xs-12">
                            <div class="form-group col-md-3 ">
                                <label>From :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datetimepicker" name="from" required="" value="<?php echo (date('Y-m-d').' 00:00:00');?>"> 
                                </div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>To :</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    
                                    <input type="text" class="form-control pull-right" id="datetimepicker1" name="to" required="" value="<?php echo (date('Y-m-d').' 23:59:59');?>"> 
                                </div>
                            </div>
                           
                            <div class="form-group col-md-3">
                                
                                <div class="form-group">
                                    <label>Select Username</label>
                                    <select class="form-control select2"  name="Username" id="Username" required="">
                                        <option value="all">All Users</option>
                                        @foreach($getAllMembers as $key => $value)
                                        <option value="{{$value->Username}}">{{$value->Username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Msg ID</label>
                                <input type="text" class="form-control" placeholder="MsgId" name="MsgId">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group col-md-3">
                                <label>Sender</label>
                                <input type="text" class="form-control" placeholder="Sender Id" name="Sender">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Mobile</label>
                                <input type="text" class="form-control" placeholder="Mobile" name="Mobile">
                            </div>
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label>Select Status</label>
                                    <select class="form-control select2"  name="type" id="type">
                                        <option value="">Status</option>
                                        <option value="1">Delivered</option>
                                        <option value="2">Failed</option>
                                        <option value="16">Reject</option>
                                        <option value="923">Sent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="submit" name="" onclick="DeliveryReportPdu()" value="Get Reports" class="btn btn-primary mt25" id="GetDeliveryPdu">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="DeliveryReportPdu"></div>
    </section>
</div>