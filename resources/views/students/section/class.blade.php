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

          .widget-menu>li>a.active {
            background-color: #325a88;
            color: #ffffff;
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
                    <div class="span3">
                        <div class="sidebar">

                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#"><i class="menu-icon icon-book"></i>Classes</a></li>
                                @foreach($sections as $row)
                                <li><a @if($row->id == $selectedSection['id']) class="active" @endif href="#">{{ $row->year_level. ' - ' .$row->name . ' ' . ($row->semester == 1? '1ST SEMESTER':'2ND SEMESTER'). ' (' .$row->schoolyear. ')' }}</a>
                                </li>
                                @endforeach
                            </ul>
                            
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        @if(Session::has('error'))
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>{{ Session::get('error') }}</strong>
                        </div>
                        @endif
                        <div class="content">
                            <div class="module">
                              <div class="module-body">
                                <div class="profile-head media">
                                    {{-- <a href="#" class="media-avatar pull-left">
                                        <img src="{{ asset('edmin/images/default-user.jpg') }}">
                                    </a> --}}
                                    <div class="media-body">
                                      <h1>Class Information</h1>
                                      <h4>{{ $selectedSection['year_level']. ' - ' .$selectedSection['name'] }} <small>{{ $selectedSection['semester'] == 1? '1ST SEMESTER':'2ND SEMESTER' }}</small></h4>
                                        <p class="profile-brief">
                                            {{ $selectedSection['schoolyear'] }}
                                        </p>
                                        <p class="profile-brief">
                                            Adviser: {{ $selectedSection['adviser'] }}
                                        </p>
                                        <p class="profile-brief">
                                            Track: {{ $selectedSection['track'] }}
                                        </p>
                                    </div>
                                  </div>
                                  <a style="margin-top: 10px;" href="{{ route('student.grades.pdf', $selectedSection['id']) }}" class="btn btn-success"> View as PDF</a>
                              </div>
                            </div>
                            <div class="module">
                                <div class="module-head">
                                    <h3 style="display: inline;"><i class="menu-icon icon-bar-chart"></i> Grades</h3>
                                </div>
                                <div class="module-body table">
                                  
                                    <table id="studentTable" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped  display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    SUBJECT CODE
                                                </th>
                                                <th>
                                                    DESCRIPTION
                                                </th>
                                                <th>
                                                    GRADE
                                                </th>
                                                <th>
                                                    TEACHER
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($studentGrades as $row)
                                            <tr>
                                                <td>{{ $row->subject_code }}</td>
                                                <td>{{ $row->subject_description }}</td>
                                                <td>{{ $row->student_grade }}</td>
                                                <td>{{ $row->teacher_name }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    SUBJECT CODE
                                                </th>
                                                <th>
                                                    DESCRIPTION
                                                </th>
                                                <th>
                                                    GRADE
                                                </th>
                                                <th>
                                                    TEACHER
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
