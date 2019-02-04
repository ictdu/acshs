<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher</title>
        <link rel="shortcut icon" href="@if(!$logoEmpty) {{ asset('img/logo/'.$publicLogo->image) }} @endif">
        <link type="text/css" href="{{ asset('edmin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('edmin/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('edmin/css/theme.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('edmin/images/icons/css/font-awesome.css') }}" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <style>
          .navbar .navbar-inner {
              background: #325a88;
              border-bottom: 1px solid #bbb;
              -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
              -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.15);
              box-shadow: 0 1px 2px rgba(0,0,0,0.15);
          }

          .navbar .brand {
              color: #fff;
              font-weight: bold;
              font-size: 20px;
              margin-right: 20px;
              padding: 20px;
          }

          .navbar .brand {
              float: left;
              display: block;
              margin-left: -20px;
              text-shadow: 0 1px 0 #333333;
          }

          .navbar .nav>li>a {
              padding: 20px 15px;
              font-weight: bold;
              color: #fff;
          }

          .navbar .nav>li>a {
              float: none;
              text-decoration: none;
              text-shadow: 0 1px 0 #333333;
          }

          .navbar .nav li.dropdown>.dropdown-toggle .caret {
              border-top-color: #ffffff;
              border-bottom-color: #777777;
          }

          .navbar .nav>li.active, .navbar .nav>li.active, .navbar .nav>li.active, .navbar .nav>li:hover {
              background: #324e6f;
          }

          .widget-menu>li>a.active {
            background-color: #325a88;
            color: #ffffff;
          }
        </style>
    </head>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.html">@if(!$schoolnameEmpty) {{ $publicSchoolname->name }} @else SPCFPartners @endif</a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li><a style="color:white;" href="{{ route('teacher.dashboard') }}"><i class="icon-list"></i> Classes</a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('edmin/images/default-user.jpg') }}" class="nav-avatar" />{{ Auth::guard('teacher')->user()->firstname. ' ' .Auth::guard('teacher')->user()->lastname }} 
                                <b class="caret"></b> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('teacher.information') }}">Edit Profile</a></li>
                                    <li><a href="{{ route('teacher.password') }}">Change Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('teacher.logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper" style="padding-bottom: 350px">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li><a class="active" href="{{ route('teacher.information') }}"><i style="color: white;" class="menu-icon icon-user"></i> Profile</a></li>
                                <li><a href="{{ route('teacher.password') }}"><i class="menu-icon icon-lock"></i> Change Password</a></li>
                            </ul>
                            <!--/.widget-nav-->
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-body">
                                <div class="profile-head media" style="padding-bottom: 15px;">
                                    <a href="#" class="media-avatar pull-left">
                                        <img src="{{ asset('edmin/images/default-user.jpg') }}">
                                    </a>
                                    <div class="media-body">
                                        <h4>
                                            {{ Auth::guard('teacher')->user()->firstname. ' ' .Auth::guard('teacher')->user()->middlename. ' ' .Auth::guard('teacher')->user()->lastname }}<small>{{ Auth::guard('teacher')->user()->employee_id }}</small>
                                        </h4>
                                        <p class="profile-brief">
                                            {{ Auth::guard('teacher')->user()->gender }}
                                        </p>
                                        <p class="profile-brief">
                                            {{ date("M d, Y", strtotime(Auth::guard('teacher')->user()->birthday)) }}
                                        </p>
                                    </div>
                                  </div>
                            </div>
                            
                            @if(Session::has('success'))
                            <div class="container-fluid">
                              <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>The changes have been saved.</strong>
                              </div>
                            </div>
                            @endif

                            <form class="form-horizontal" action="{{ route('teacher.information.submit') }}" method="POST">
                              {{ csrf_field() }}
                              <div class="control-group" style="padding-top: 20px;">
                                <label class="control-label" for="basicinput">Contact</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="contact" id="basicinput" value="{{ Auth::guard('teacher')->user()->contact }}" class="span3">
                                </div>

                                <label class="control-label" for="basicinput">Address1</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="address1" id="basicinput" value="{{ Auth::guard('teacher')->user()->address1 }}" class="span3">
                                </div>

                                <label class="control-label" for="basicinput">Address2</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="address2" id="basicinput" value="{{ Auth::guard('teacher')->user()->address2 }}" class="span3">
                                </div>

                                <label class="control-label" for="basicinput">Barangay</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="barangay" id="basicinput" value="{{ Auth::guard('teacher')->user()->barangay }}" class="span3">
                                </div>

                                <label class="control-label" for="basicinput">Municipality</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="municipality" id="basicinput" value="{{ Auth::guard('teacher')->user()->municipality }}" class="span3">
                                </div>

                                <label class="control-label" for="basicinput">Province</label>
                                <div class="controls" style="margin-bottom: 20px;">
                                  <input type="text" name="municipality" id="basicinput" value="{{ Auth::guard('teacher')->user()->province }}" class="span3">
                                </div>

                                <div class="control-group">
                                  <div class="controls">
                                    <button type="submit" class="btn btn-success">Save</button>
                                  </div>
                                </div>

                              </div>
                              <div class="control-group">
                                <div class="controls">
                                  
                                </div>
                              </div>
                            </form>
                            <!--/.module-body-->
                        </div>
                        <!--/.module-->
                    </div>
                    <!--/.content-->
                </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; 2014 Edmin - EGrappler.com </b>All rights reserved.
            </div>
        </div>
        <script src="{{ asset('edmin/scripts/jquery-1.9.1.min.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/jquery-ui-1.10.1.custom.min.js') }}" ></script>
        <script src="{{ asset('edmin/bootstrap/js/bootstrap.min.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/flot/jquery.flot.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/flot/jquery.flot.resize.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/datatables/jquery.dataTables.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/common.js') }}" ></script>
       
      
    </body>
