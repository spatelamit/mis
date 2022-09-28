@include('header')

<form  method="post" enctype="multipart/form-data" id="upload_csv_form">
    @csrf
    <div class="form-group">
      <label for="exampleFormControlFile1">Please Select File</label>
      <input type="file" name="uploaded_file" class="form-control-file" id="exampleFormControlFile1">
    </div>
    <div class="form-group">
     <input type="submit" name="submit" value="submit" class="btn btn-primary">
   </div>
</form>

<div id="csv_upload_data"></div>
@include('footer')