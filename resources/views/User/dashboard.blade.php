@include('header')

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
            <a href="https://mis.secureip.in/dashboard" class="btn btn-primary"><i class="fa fa-refresh"></i> Refresh</a>
            <h4 class="mb-20">Current Volume <?php echo date('d-m-M-Y');?> </h4>
           
            <div class="table-responsive ">

                <table id="example" class=" table table-responsive display nowrap" style="width:100%">
                    <thead>
                        <tr>
                        <tr>
                            <th>Sno.</th>
                            <th>UserName</th>
                            <th>Submition</th>
                            <th>Deliver</th>
                            <th>Failed</th>
                            <th>Pending</th>
                            
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($main as $value)
                        
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value['name'] }}</td>
                                <?php
                                $Delivered=(isset($value['1']) && $value['1'])?$value['1']:'0';
                                $Failed=(isset($value['2']) && $value['2'])?$value['2']:'0';
                                $Reject=(isset($value['16']) && $value['16'])?$value['16']:'0';
                                $Sent=(isset($value['8']) && $value['8'])?$value['8']:'0'; 
                                $Submit=(isset($value['923']) && $value['923'])?$value['923']:'0'; 
                                $Pending = $Submit+ $Sent;
                                $Total=$Delivered+$Failed+$Reject+$Pending;
                                ?>
                                <td><?php echo $Total; ?></td>
                                <td><?php echo $Delivered; ?> </td>
                                <td><?php echo $Failed; ?> </td>
                                <td><?php echo $Pending; ?> </td>
                            </tr>
                          
                        @endforeach

                    </tbody>

                </table>

            </div>
            {{-- {!! $query->links('pagination::bootstrap-4') !!} --}}
        </div>




        {{-- table design end --}}
        @include('footer')


