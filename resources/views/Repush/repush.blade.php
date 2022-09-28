@include('header')
    <div class="nav notify-row" id="top_menu">
        <div id='cssmenu'>
            <ul>
                <!-- <li><a onclick="getReportTab('summeryhistory')">Summery History</a> </li> -->
                
            </ul>
        </div>
    </div>
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

<h4 class="mb-20"> Repush MT / MO Counts</h4>

<form action="javascript:void(0)" method="POST">
                @csrf
                
                <div class="row">
                
                <div class="col-md-4">
                <label>Date Time Picker:</label>
                <div class="input-group date">
                    <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                    <input type="text" name="datetimes" id="RepushDateTime" class="form-control pull-right">
                </div>
                </div>
                
                
                <div class="col-md-2">
                <label>Select Username</label>
                <select class="form-control select2"  name="Username" id="Username" required="">
                    <option value="all">All Users</option>
                    @foreach($getAllMembers as $key => $value)
                    <option value="{{ $value->Username }}">{{ $value->Username }}</option>
                    @endforeach
                </select>
                </div>
                
                
                <div class="col-md-2">
                <label>Sender</label>
                <input type="text" class="form-control" placeholder="Sender Id" name="sender" value="">
                </div>
                
                
                <div class="col-md-2">
                <label>Number</label>
                <input type="text" class="form-control" placeholder="Number" name="receiver" value="">
                </div>
                
                
                
                <div class="col-md-2">
                <label>SmscId</label>
                <select class="form-control select2"  name="SmscId" id="SmscId" required="">
                    <option value="all">All SmscIds</option>
                    @foreach($SmscList as $key => $value)
                    <option value="{{ $value->SmscId }}">{{ $value->SmscId }}</option>
                    @endforeach
                </select>
                </div>
                
                
                <div class="col-md-12 text-right">
                <input type="submit" name="" value="Get Repush Data" class="btn btn-primary mt25" id="getRepushData">
                </div>
                
                </div>
            </form>
            
            
            
             <div id="getRepushDataBox" class="mt-10"></div>


</div>
</div>

    
    
    
    
    
    
    
        
        
       
    </section>
</section>
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
@include('footer')