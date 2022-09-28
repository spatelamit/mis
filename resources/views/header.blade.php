<!DOCTYPE html>
<html>
	<head>
		<title>MIS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="{{asset('/assets/css/bootstrap.min.css')}}" rel='stylesheet' type='text/css'/>
		<link href="{{asset('/assets/css/style.css')}}" rel='stylesheet' type='text/css'/>
		<link href="{{asset('/assets/css/style-responsive.css')}}" rel='stylesheet' type='text/css'/>
		<link href="{{asset('/assets/css/menu_styles.css')}}" rel='stylesheet' type='text/css'/>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<!-- font-awesome icons -->
		<link href="{{asset('/assets/css/morris.css')}}" rel="stylesheet" type="text/css" />
		<link rel='stylesheet' type='text/css' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css
"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

		<script src="{{asset('/assets/js/jquery2.0.3.min.js')}}"></script>
		<script src="{{asset('/assets/js/morris.js')}}"></script>
		<script src="{{asset('/assets/js/menu-script.js')}}" ></script>
        
        
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" type="text/css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" type="text/css">
	</head>
<body>
	<section id="container">
		<aside>
  			<div id="sidebar" class="nav-collapse"> 
    			<!-- sidebar menu start-->
			    <div class="leftside-navigation">
			      	<ul class="sidebar-menu" id="nav-accordion">
						<li class="active">
							<a href="dashboard" class="active"><i class="fa fa-pie-chart"></i>
								<span>Dashboard</span>
							</a>
						</li>
						@if(session()->get('IsAdmin') == 'Y')
						<li>
							<a href="kannel_status"><i class="fa fa-snowflake-o"></i>
								<span> Kannel Status </span>
							</a>
						</li>

						<li>
							<a href="kannel_status"><i class="fa fa-snowflake-o"></i>
								<span> Daily Counts </span>
							</a>
						</li>


						<li>
							<a href="{{url('Otp_Section')}}"><i class="fa fa-thermometer-empty"></i>
								<span> OTP SECTION </span>
							</a>
						</li>
						<li>
							<a href="smpp_user"><i class="fa fa-users"></i>
								<span> SMPP Users </span>
							</a>
						</li>
							@endif
						<li>
							<a   href="report"><i class="fa fa-file-text-o"></i>
								<span> Reports </span>
							</a>
						</li>
							@if(session()->get('IsAdmin') == 'Y')
						<li>
							<a href="repush"><i class="fa fa-pause"></i>
								<span> Re-Push </span>
							</a>
						</li>
						<li> 
							<a href="{{url('Balance')}}"><i class="fa fa-inr"></i> 
								<span> Balance </span>
							</a>
						</li>
						<li> 
							<a href="{{url('BalanceHistory')}}"><i class="fa fa-inr"></i> 
								<span> BalanceHistory </span>
							</a>
						</li>
						<li>
							<a href="whitelist"> <i class="fa fa-list"></i>
								<span> White List </span>
							</a>
						</li>
						<li> 
							<a href="{{url('error_cods')}}"> <i class="fa fa-exclamation-triangle"></i>
								<span> Error Code </span>
							</a>
						</li>
						<li>
							<a href="{{url('Dlt_Mmq_Operator')}}"> <i class="fa fa-clipboard"></i>
								<span> DLT( MMOperators) </span>
							</a>
						</li>
						<li>
							<a href="{{url('User_Controller_History')}}"> <i class="fa fa-sliders"></i>
								<span> User Control History </span>
							</a>
						</li>
						<li>
							<a href="{{url('smsc')}}"><i class="fa fa-cloud-upload"></i>
								<span> SMSC's </span>
							</a>
						</li>
						
                        <li> 
							<a href="{{url('BadData')}}"><i class="fa fa-inr"></i> 
								<span>BadData_Collection</span>
							</a>
						</li>
						@endif
						<li>
							<a href="{{url('my_profile')}}"><i class="fa fa-user-circle-o"></i>
								<span> My Profile </span>
							</a>
						</li>
						<li>
							<a href="{{url('logout')}}"><i class="fa fa-power-off"></i>
								<span> Logout </span>
							</a>
						</li>
			      	</ul>
			    </div>
			    <!-- sidebar menu end--> 
			</div>
		</aside>
		<header class="header fixed-top clearfix"> 
		<!--logo start-->
		<div class="brand"> <a href="index.html" class="logo"> SMPP MIS </a>
		    <div class="sidebar-toggle-box">
		        <div class="fa fa-angle-left"></div>
		    </div>
		</div>
		<!--logo end-->