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
        <div class="cl"></div>

        <div class="stats-info-agileits mb-20">
            <h4 class="mb-20">Balance History</h4>
            <div class="table-responsive ">

                <table id="example" class=" table table-responsive display nowrap" style="width:100%">
                    <thead>
                        <tr>
                        <tr>
                            <th>Sno.</th>
                            <th>UserName</th>
                            <th>BalanceType</th>
                            <th>DateTime</th>
                            <th>Balance</th>
                            <th>NewBalance</th>
                            <th>Description</th>
                            <th>PayBy</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $val)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $val->Username }}</td>
                                <td>{{ $val->FundType }}</td>
                                <td>{{ $val->DateTime }}</td>
                                <td>{{ $val->Balance }}</td>
                                <td>{{ $val->NewBalance }}</td>
                                <td>{{ $val->Description }}</td>
                                <td>{{ $val->PaymentBy }}</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
            {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
        </div>




        {{-- table design end --}}
        @include('footer')
