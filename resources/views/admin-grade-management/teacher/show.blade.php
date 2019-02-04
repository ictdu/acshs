@extends('backpack::layout')

@section('after_styles')
<!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
  }

  .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 35px;
    user-select: none;
    -webkit-user-select: none;
  }

  .select2-container--default .select2-selection--single {
      background-color: #fff;
      border: 1px solid #d2d6de;
      border-radius: 4px;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Teacher Information
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('teacher.index') }}">Teachers</a></li>
        <li class="active">Show</li>
      </ol>
    </section>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4">
      <div class="box">
        <div class="box-header hidden-print with-border">
          <h5><i class="fa fa-user"></i></h5>
        </div>

        <div class="box-body overflow-hidden">
          <div class="row">
            <div class="col-md-4">
              <label>Name: </label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->firstname. ' ' .$teacher->middlename. ' ' .$teacher->lastname }}</label>
            </div>

            <div class="col-md-4">
              <label>Employee ID:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->employee_id }}</label>
            </div>

            <div class="col-md-4">
              <label>Gender:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->gender }}</label>
            </div>

            <div class="col-md-4">
              <label>Birthday:</label>
            </div>
            <div class="col-md-8">
              <label>{{ date('M d, Y', strtotime($teacher->birthday)) }}</label>
            </div>

            <div class="col-md-4">
              <label>Contact:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->contact == ''? 'None':$teacher->contact }}</label>
            </div>

            <div class="col-md-4">
              <label>Address1:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->address1 == ''? 'None':$teacher->address1 }}</label>
            </div>

            <div class="col-md-4">
              <label>Address2:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->address2 == ''? 'None':$teacher->address2 }}</label>
            </div>

            <div class="col-md-4">
              <label>Barangay:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->barangay == ''? 'None':$teacher->barangay }}</label>
            </div>

            <div class="col-md-4">
              <label>Municipality:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->municipality == ''? 'None':$teacher->municipality }}</label>
            </div>

            <div class="col-md-4">
              <label>Province:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $teacher->province == ''? 'None':$teacher->province }}</label>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="box">
        <div class="box-header hidden-print with-border">
          <h5><i class="fa fa-list"></i> Classes</h5>
        </div>

        <div class="box-body overflow-hidden">
          <table id="sectionTable" class="table table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>School Year</th>
                <th>Track</th>
                <th>Year Level</th>
                <th>Semester</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sections as $row)
              <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->schoolyear }}</td>
                <td>{{ $row->track }}</td>
                <td>{{ $row->year_level }}</td>
                <td>{{ $row->semester == 1? '1ST SEMESTER':'2ND SEMESTER' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
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
    // datatable init
    /*$(document).ready( function () {
        $('#crudTable').DataTable({
          "order": [[ 0, "desc" ]],
          "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false,
                  "searchable": false
              }
          ]
        });
    } );*/

    $(document).ready( function () {
        $('#sectionTable').DataTable({
          "order": [[ 1, "desc" ]]
        });
    } );
  </script>

@endsection