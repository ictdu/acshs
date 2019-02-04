@extends('backpack::layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/admindashboard.css') }}">
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

@endsection

@section('header')
    <section class="content-header">
      <h1>
        Students<small>Import students in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('student.index') }}">Students</a></li>
        <li class="active">Import</li>
      </ol>
    </section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-8 col-md-offset-2">
      <div class="box">
        <div class="box-header hidden-print with-border">
            <div class="col-md-4">
              <form id="submitForm" method="POST" action="{{ route('student.c-import') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label for="exampleInputFile">Import Student</label>
                  <input type="file" id="exampleInputFile" name="sel_file">
                  <p class="help-block">Upload a csv file only!</p>
                </div>
                {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#pleaseWaitDialog">Start ></button> --}}
                <!-- Button trigger modal -->
                <button id="start" type="button" class="btn btn-primary">
                  Submit
                </button>
              </form>
            </div>
            <div class="col-md-8">
              <label>Please follow the format below or download the template. <a class="btn btn-xs btn-primary" href="{{ route('student.downloadtemplate') }}"><i class="fa fa-download"></i> Download Template</a></label>
              <img src="{{ asset('img/student_sample_template.jpg') }}" style="width: 100%; margin-bottom: 20px;">
              <div class="alert alert-info" role="alert">
                If you are having a problem in the LRN column follow these 
                <a href="#" class="alert-link" data-toggle="modal" data-target="#instructionModal">instructions</a>
              </div>
              <div class="alert alert-info" role="alert">
                To find the Track ID go to
                <a href="{{ route('track.index') }}" class="alert-link" >Track List</a>
              </div>
            </div>
        </div>
      </div><!-- /.box -->
    </div>

  </div>

  <!-- Processing Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1>Processing...</h1>
        </div>
        <div class="modal-body">
          
          <div class="progress">
            <div id="dynamic" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              <span id="current-progress"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Instruction Modal -->
  <div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Fix LRN column</h4>
        </div>
        <div class="modal-body">
          <label>1. Right click column A and select Formart Cells.</label>
          <img src="{{ asset('img/tutorial/student-lrn/first.jpg') }}" style="width: 100%; margin-bottom: 20px;">

          <label>2. A new window will popup go to Number tab, select number in the category then set the decimal places to 0.</label>
          <img src="{{ asset('img/tutorial/student-lrn/second.jpg') }}" style="width: 100%;">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('after_scripts')

  <!-- DATA TABLES SCRIPT -->
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>

  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

  <script>

    $(document).ready(function() {
        $("#start").click(function(){
          $('#myModal').modal({backdrop: 'static', keyboard: false}) 
          
          $(function() {
            var current_progress = 0;
            var interval = setInterval(function() {
                current_progress += 2;
                $("#dynamic")
                .css("width", current_progress + "%")
                .attr("aria-valuenow", current_progress)
                .text(current_progress + "%");
                if (current_progress >= 100)
                    clearInterval(interval);
                    $('#submitForm').get(0).submit();
            }, 50);
          });

          // $('#submitForm').get(0).submit();
        }); 
    });

    $('#teacherTable').DataTable();
      
  </script>

@endsection

