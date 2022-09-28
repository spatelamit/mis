{{-- @include('header')

<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">Edit SMSC's</a></li>
        
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
         
                       
                            
                                    <form role="form" action="/smscupdate" method="post">
                                        @csrf
                                      
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label>Smsc's</label>
                                                    <input type="text" name="SmscId" class="form-control"  placeholder="Enter Smsc name" value="" pattern=".{0}|.{5,15}" required title="Either 0 OR (5 to 15 chars)">
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
                                                        <input type="text" name="Description" class="form-control"  placeholder="Enter Description" value="" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label>Is Mix Routing</label>
                                                      <div class="checkbox">
                                                            <label><input type="checkbox" name="IsMixRouting" id="IsMixRouting" value="1" >Is Mix Routing</label>
                                                      </div>
                                                </div>
                                               <div class="form-group"  id="SelectMixBox" style="display: none;">
                                                    <label>Mix The Route</label>
                                                      <select name="MixRoutes[]" class="form-control" multiple>
                                                        <option value="" >Select SMSC</option>
                                                  @foreach( $smsclist as $key)
                                                        <option  value="{{$key->SmscId}}" >{{$key->SmscId}}</option>
                                                        @endforeach
                                                      </select>

                                               </div>
                                            </div>
                                            
                                             <div class="col-md-2">
                                             <div class="form-group ">
                                                    <label>Status</label>
                                                      <div class="radio">
                                                        <label>
                                                          <input type="radio" name="Status" value="1"   checked="">Active                        
                                                        </label>

                                                        <label>
                                                          <input type="radio" name="Status" value="0" >
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
   </div>
 </section>
</section> --}}