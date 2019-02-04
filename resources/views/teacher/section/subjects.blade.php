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
                            <li class="active"><a style="color:white;" href="{{ route('teacher.dashboard') }}"><i class="icon-list"></i> Classes</a></li>
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
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#">Grade & Section: {{ $section['year_level']. ' - ' .$section['name'] }}
                                </a></li>
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#">Semester: {{ $section['semester'] == 1 ? '1ST':'2ND' }}
                                </a></li>
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#">Track: {{ $section['track'] }}
                                </a></li>
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#">School Year: {{ $section['schoolyear'] }}
                                </a></li>
                            </ul>
                            <!--/.widget-nav-->
                            
                            
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a style="background-color: #222123;color: #767676;-webkit-transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;transition: all .2s ease-in-out; cursor: context-menu;" href="#"><i class="menu-icon icon-book"></i>Subjects</a></li>
                                @foreach($sectionSubjects as $row)
                                <li><a href="{{ route('teacher.section.subject', [$section['id'] ,$row->subject_id]) }}">{{ $row->subject_code }} (Input Students Grades)</a>
                                </li>
                                @endforeach
                            </ul>
                            
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="module">
                                <div class="module-head">
                                    <h3><i class="menu-icon icon-user"></i> Students</h3>
                                </div>
                                <div class="module-body table">
                                    <table id="studentTable" cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    LRN
                                                </th>
                                                <th>
                                                    NAME
                                                </th>
                                                <th>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sectionStudents as $row)
                                            <tr>
                                                <td>{{ $row->lrn }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td><a href="{{ route('teacher.section.student', [$section['id'], $row->id]) }}" class="btn btn-xs btn-primary">View Grades</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    LRN
                                                </th>
                                                <th>
                                                    NAME
                                                </th>
                                                <th>
                                                  
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
        <script>
            sortTable(1);
            function sortTable(n) {
              var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
              table = document.getElementById("studentTable");
              switching = true;
              // Set the sorting direction to ascending:
              dir = "asc"; 
              /* Make a loop that will continue until
              no switching has been done: */
              while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                  // Start by saying there should be no switching:
                  shouldSwitch = false;
                  /* Get the two elements you want to compare,
                  one from current row and one from the next: */
                  x = rows[i].getElementsByTagName("TD")[n];
                  y = rows[i + 1].getElementsByTagName("TD")[n];
                  /* Check if the two rows should switch place,
                  based on the direction, asc or desc: */
                  if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch = true;
                      break;
                    }
                  } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch = true;
                      break;
                    }
                  }
                }
                if (shouldSwitch) {
                  /* If a switch has been marked, make the switch
                  and mark that a switch has been done: */
                  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                  switching = true;
                  // Each time a switch is done, increase this count by 1:
                  switchcount ++; 
                } else {
                  /* If no switching has been done AND the direction is "asc",
                  set the direction to "desc" and run the while loop again. */
                  if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                  }
                }
              }
            }      
        </script>
      
    </body>
