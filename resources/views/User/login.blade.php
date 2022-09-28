<!DOCTYPE html>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title> Login </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel='stylesheet'/>
        <link href="{{asset('/assets/css/style.css')}}" rel='stylesheet' type='text/css'/>
        <link href="{{asset('/assets/css/style-responsive.css')}}" rel='stylesheet'/>

        <!-- font CSS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <style>

            .app.app-fh{
              height: 100%;
            }
            .app {
              float: left;
              width: 100%;
              min-height: 48em;
              position: relative;
            }
            .app, body {
              overflow-x: hidden;
            }

            input.ggg {
              width: 100%;
              padding: 15px 0px 15px 15px;
              border: 1px solid #ccc;
              outline: none;
              font-size: 14px;

              margin: 14px 0px;
              background: #fff;
            }
            .w3layouts-main span {
              font-size: 16px;
              color: #000;
              float: left;
              width: 32%;
              margin-top: 8px;
            }
            .box_se {
            width: 30%;
            height: 200px;
            margin: 40px auto;
            top: 35%;
            left: 35%;
            position: absolute;
            }

            input{
                color:#000;}

            input::-webkit-input-placeholder { /* Edge */
              color: #000;
            }

            input:-ms-input-placeholder { /* Internet Explorer 10-11 */
             color: #000;
            }

            input::placeholder {
             color: #000;
            }
            input::placeholder {
              color: #000 !important;
            }
            .logo {
              width: 100%;
              text-align: center;
            }
        </style>

    </head>
    <body style="background-color:#f5f2eb;">
        <div class="app app-fh" style="background: url(../assets/images/login-bg.png) center center no-repeat fixed">
            <div class="log-w3" >
                <div class="w3layouts-main">
                    <div class="logo">
                        <img src="{{asset('/assets/images/logo.png')}}">
                    </div>
                    <h2>SMPP Login</h2>
                    <form action="{{ url('loginAction') }}" method="post">
                        @csrf
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('fail'))
                            <div class="alert alert-info">{{ Session::get('fail') }}</div>
                        @endif
                        <input class="ggg" name="username" placeholder="Username" required>
                        <input type="password" class="ggg" name="password" placeholder="PASSWORD" required>
                        <div class="clearfix"></div>
                        <input type="submit" value="Sign In" name="login">
                    </form>
                </div>
                <div class="box_se effect5" ></div>
            </div>
        </div>
        <script src="{{asset('/assets/js/bootstrap.js')}}"></script>
    </body>
</html>
