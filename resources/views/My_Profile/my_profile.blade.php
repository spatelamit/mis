@include('header')
<div class="nav notify-row" id="top_menu">
    <div id='cssmenu'>
        {{-- <ul>
            <li class="active"><a href="#tab-1" data-toggle="tab">View SMSC's</a></li>

        </ul> --}}
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
        <div class=" market-updates">


            <div class="row">

                <div class="col-md-3">
                    <div class="stats-info-agileits text-center">
                        <img src="http://mis.secureip.in/assets/images/images.jpg" class="twPc-avatarImg img-fluid">

                        <div class="list-inline_as">
                            <ul class="row">
                                <li class="col-md-12">
                                    <h3><i class="fa fa-user" aria-hidden="true"></i> <span> {{ $users[0]->Fullname }}
                                        </span></h3>
                                </li>

                                <li class="col-md-12">
                                    <p><i class="fa fa-phone" aria-hidden="true"></i> <span>
                                            {{ $users[0]->Mobile }}</span></p>
                                </li>

                                <li class="col-md-12">
                                    <p> <i class="fa fa-envelope" aria-hidden="true"></i> <span> {{ $users[0]->Email }}
                                        </span></p>
                                </li>

                                <li class="col-md-6">
                                    <p> <i class="fa fa-map-marker" aria-hidden="true"></i> <span>
                                            {{ $users[0]->Address }} </span></p>
                                </li>

                                <li class="col-md-6">
                                    <p><i class="fa fa-building" aria-hidden="true"></i> <span> {{ $users[0]->City }}
                                        </span></p>
                                </li>

                                <li class="col-md-6">
                                    <p> <i class="fa fa-university" aria-hidden="true"></i> <span>
                                            {{ $users[0]->State }} </span></p>
                                </li>

                                <li class="col-md-6">
                                    <p> <i class="fa fa-globe" aria-hidden="true"></i> <span> {{ $users[0]->Country }}
                                        </span></p>
                                </li>
                            </ul>
                        </div>



                    </div>
                </div>


                <div class="col-md-9">
                    <div class="stats-info-agileits">

                        <h4 class="mb-5"> Password Reset </h4>


                        <form class="form-horizontal" method="POST" action="{{ url('/update_Password') }}">
                            @csrf

                            
                            <input type="hidden" name="Id" value="{{ $users[0]->Id }}" class="form-control"
                            placeholder="Id">

                            <div class="col-md-3">
                                <label>Current Password</label>
                                <input type="password" name="CurrentPassword" class="form-control"
                                    placeholder="Current Password">

                            </div>



                            <div class="col-md-3">
                                <label>New Password</label>
                                <input type="password" name="NewPassword" class="form-control"
                                    placeholder="New Password">

                            </div>



                            <div class="col-md-3">
                                <label>Confirm Password</label>
                                <input type="password" name="ConfirmPassword" class="form-control"
                                    placeholder="Confirm Password">

                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-danger mt-20">Submit</button>
                            </div>


                        </form>
                       
                    </div>


                </div>



            </div>
        </div>
    </section>
</section>




@include('footer')
