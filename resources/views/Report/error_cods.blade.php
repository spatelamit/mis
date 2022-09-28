@include('header')
    <div class="top-nav clearfix">
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="http://mis.secureip.in/assets/images/user-png.png">
                    <span class="username"> {{ session()->get('Name') }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>





<section id="main-content">
    <section class="wrapper">
    
    
    
 <div class=" market-updates">
<div class="stats-info-agileits mb-20"> 
 <form method="POST" action="{{url('/csv_upload_data')}}" enctype="multipart/form-data">
              @csrf          
        <div class="row">
          <div class="col-md-2"> <input type="file" id="real-file" hidden="hidden" name="file"> </div>
           <div class="col-md-2"> <button type="submit" class="btn btn-primary">Upload CSV</button> </div>
          <!-- <span id="custom-text">No file chosen, yet.</span>  -->
        </div>
    
    </form>

</div>
</div>   
    
    
    
    
    
<div class="stats-info-agileits mb-20"> 

 <h4 class="mb-20">Add Error Code</h4>

<form method="POST" action="{{ url('add_error_code') }}" id="error_code" enctype="multipart/form-data">
            @csrf
            @if(session()->get('edit_data'))
            
            
            	<div class="col-md-3">
            	<label class="form-label" for="form3Example1c">operator_code</label>
                <input type="text" name="operator_code" class="form-control" value="{{ session()->get('edit_data')->operator_code }}" />
                </div>
                
                <div class="col-md-3">
				 <label class="form-label" for="form3Example3c">custom_code</label>
                <input type="text" name="custom_code" class="form-control" value="{{ session()->get('edit_data')->custom_code }}"/>
                </div>
               
               
               <div class="col-md-3">
				 <label class="form-label" for="form3Example4c">description</label>
                <input type="text" name="description" class="form-control" value="{{ session()->get('edit_data')->description }}"/>
                </div>
                
                
               <div class="col-md-3">
				 <label class="form-label" for="form3Example4c">selfdescription</label>
                <input type="text" name="selfdescription" class="form-control" value="{{ session()->get('edit_data')->selfdescription }}"/>
                </div>
                
                
               <div class="col-md-3">

                <input type="hidden" name="id" value="{{ session()->get('edit_data')->id }}" />

                <button type="submit" class="btn btn-primary btn-lg">Edit</button>
                </div>
            @else
				
                
                <div class="col-md-2">
                <label class="form-label" for="form3Example1c">Operator Code</label>
                <input type="text" name="operator_code" class="form-control" />
                </div>
                
                
				<!-- <div class="col-md-2">
                 <label class="form-label" for="form3Example3c">Custom code</label>
                <input type="text" name="custom_code" class="form-control" />
                </div> -->
                  <div class="col-md-6">
                 <label>Custom Code</label>
                 <select id="custom_code" name="custom_code" class="form-control code-select2"  required="">
                    @foreach( $data['custom_code'] as $code)
                     <option value="{{$code->custom_code}}">{{$code->custom_code}}-{{$code->description}}</option>
                     @endforeach
                 </select>
                </div>
                
               <div class="col-md-3">
				 <label class="form-label" for="form3Example4c">Description</label>
                <input type="text" name="description" class="form-control" />
                </div>
               
               <div class="col-md-3">
				 <label class="form-label" for="form3Example4c">Selfdescription</label>
                <input type="text" name="selfdescription" class="form-control" />
               </div>

               <div class="col-md-1 mt-20"> <button type="submit" class="btn btn-primary">Submit</button> </div>
            @endif
        </form>
        
       <div class="col-md-1 mt-20">  <a href="{{ url('upload_errorcode_csv') }}" class="btn btn-info">Import</a> </div>
       <div class="cl"></div>
</div>


<div class="cl"></div>

<div class="stats-info-agileits mb-20"> 
 <h4 class="mb-20">Error Code</h4>
<div class="table-responsive ">
                       
                        <table id="example" class=" table table-responsive display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>operator_code</th>
                                    <th>custom_code</th>
                                    <th>description</th>
                                    <th>selfdescription</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['operator_code_list'] as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->operator_code }}</td>
                                        <td>{{ $log->custom_code }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->selfdescription }}</td>
                                        <td>
                                            <a href="{{ url('edit_error_code/' . $log->id) }}" class="btn btn-info"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">edit</a>
                                            <a href="{{ url('delete/' . $log->id) }}"
                                                class="btn btn-info">delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                    {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
</div>



<section id="main-content">
    <section class="wrapper">
        
        
        
        {{-- model start --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
{{-- table design end --}}
@include('footer')