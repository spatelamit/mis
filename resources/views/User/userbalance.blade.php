<section class="content">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Fill Balance Details</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="http://smpp.bulk24sms.com/updatebalance" method="post">
            <div class="box-body">

<div class="col-md-12"><h3>Total Available Balance :  ₹ 7,354,936.00</h3></div>
              
                  <input type="hidden" name="TotalBalance" value="7354936">
                  <input type="hidden" name="MemberId" value="65">
              
              <div class="col-md-6">
                <div class="form-group ">
                  <label>Username/UserId</label>
                  <input type="text" disabled="" name="Username" class="form-control" placeholder="Enter Username" value="airtrans">
                </div>
              </div>


                <div class="col-md-6">
                <div class="form-group">
                <label>Balance Type </label>
                <select name="FundType" class="form-control" required="">
                  <option value="">Select</option>
                  <option value="Add">(+) Add</option>
                  <option value="Reduce">(-) Reduce</option>
                </select>
              </div>
              </div>

              <div class="col-md-6">
                <div class="form-group ">
                  <label>Balance to be Add/Reduce</label>
                  <input type="number" name="Balance" class="form-control" placeholder="Enter  Ex ₹ 10000 Balance" value="" required="">
                </div>
              </div>



              <div class="col-md-6">
                <div class="form-group ">
                  <label>Date / Time(Optional)</label>
                  <input type="text" name="DateTime" class="form-control" placeholder="YYYY-MM-DD H:i:s a" value="2022-08-29 05:01:43 pm">
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group ">
                  <label>Description</label>
                 <textarea name="Description" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                </div>
              </div>

              </div>


            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>

    </div>
  </section>