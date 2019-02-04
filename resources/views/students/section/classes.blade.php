<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student</title>
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
        </style>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.html">@if(!$schoolnameEmpty) {{ $publicSchoolname->name }} @else SPCFPartners @endif</a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li class="active"><a style="color:white;" href="{{ route('student.classes') }}"><i class="icon-list"></i> Classes</a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('edmin/images/default-user.jpg') }}" class="nav-avatar" />{{ Auth::guard('student')->user()->firstname. ' ' .Auth::guard('student')->user()->lastname }} 
                                <b class="caret"></b> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('student.information') }}">Edit Profile</a></li>
                                    <li><a href="{{ route('student.password') }}">Change Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('student.logout') }}">Logout</a></li>
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
                    
                    <!--/.span12-->
                    <div class="span12">
                        <div class="content">
                            
                            <div class="module">
                                <div class="module-head">
                                    <h3>Classes</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th class="schoolyear">
                                                    School Year
                                                </th>
                                                <th class="name">
                                                    Name
                                                </th>
                                                <th>
                                                    Grade
                                                </th>
                                                <th>
                                                    Track
                                                </th>
                                                <th>
                                                    Semester
                                                </th>
                                                <th>
                                                    Adviser
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($sections as $row)
                                            <tr>
                                              <td>{{ $row->schoolyear }}</td>
                                              <td class="name">{{ $row->name }}</td>
                                              <td>{{ $row->year_level}}</td>
                                              <td>{{ $row->track }}</td>
                                              <td>{{ $row->semester == 1? '1ST':'2ND' }}</td>
                                              <td>{{ $row->adviser }}</td>
                                              <td><a href="{{ route('student.class', $row->id) }}" class="btn btn-warning btn-xs">View Grades</a></td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    School Year
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Grade
                                                </th>
                                                <th>
                                                    Track
                                                </th>
                                                <th>
                                                    Semester
                                                </th>
                                                <th>
                                                    Students
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
                <b class="copyright">
                  Powered by Systems Plus College Foundation
                </b>
            </div>
        </div>
        <script src="{{ asset('edmin/scripts/jquery-1.9.1.min.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/jquery-ui-1.10.1.custom.min.js') }}" ></script>
        <script src="{{ asset('edmin/bootstrap/js/bootstrap.min.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/flot/jquery.flot.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/flot/jquery.flot.resize.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/datatables/jquery.dataTables.js') }}" ></script>
        <script src="{{ asset('edmin/scripts/common.js') }}" ></script>
        <script>
          $('.datatable-1').dataTable();
        </script>
      
    </body>
