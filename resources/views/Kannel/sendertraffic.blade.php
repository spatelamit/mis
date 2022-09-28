<div class="content-wrapper">
    <div class="form-group col-md-12">
        <form id="sender_data">
            @csrf
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
                <div class="form-group">
                    <label>Select Type</label>
                    <select class="form-control select2" style="width: 100%;" name="type" id="type" required="">
                        <option value="service">USER</option>
                        <option value="smsc_id">OPERATOR</option>;         
                    </select>
                </div>
            </div>   
            <div class="form-group col-md-3 ">
                <a onclick="getsenderdata()" id="getsenderdata" class="btn btn-primary mt25">Get Record</a>
                <!-- <input type="submit" name="" value="Get Record" class="btn btn-primary mt25" onclick="getsenderdata()" id="getsenderdata"> -->
            </div> 
        </form>
    </div>
    <div class="" id="getsendertrafic"></div>
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