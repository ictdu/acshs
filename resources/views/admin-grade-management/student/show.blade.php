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
        Student Information
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('student.index') }}">Students</a></li>
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
              <label>{{ $student->firstname. ' ' .$student->middlename. ' ' .$student->lastname }}</label>
            </div>

            <div class="col-md-4">
              <label>LRN:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->lrn }}</label>
            </div>

            <div class="col-md-4">
              <label>Track:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->track->name }}</label>
            </div>

            <div class="col-md-4">
              <label>Gender:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->gender }}</label>
            </div>

            <div class="col-md-4">
              <label>Birthday:</label>
            </div>
            <div class="col-md-8">
              <label>{{ date('M d, Y', strtotime($student->birthday)) }}</label>
            </div>

            <div class="col-md-4">
              <label>Contact:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->contact == ''? 'None':$student->contact }}</label>
            </div>

            <div class="col-md-4">
              <label>Address1:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->address1 == ''? 'None':$student->address1 }}</label>
            </div>

            <div class="col-md-4">
              <label>Address2:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->address2 == ''? 'None':$student->address2 }}</label>
            </div>

            <div class="col-md-4">
              <label>Barangay:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->barangay == ''? 'None':$student->barangay }}</label>
            </div>

            <div class="col-md-4">
              <label>Municipality:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->municipality == ''? 'None':$student->municipality }}</label>
            </div>

            <div class="col-md-4">
              <label>Province:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->province == ''? 'None':$student->province }}</label>
            </div>

            <div class="col-md-4">
              <label>Guardian:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $student->guardian == ''? 'None':$student->guardian }}</label>
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
                <th></th>
                <th>Name</th>
                <th>School Year</th>
                <th>Track</th>
                <th>Year Level</th>
                <th>Semester</th>
                <th>Adviser</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sections as $row)
              <tr>
                <td><a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#Modal{{$row->id}}">View Grades</a></td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->schoolyear }}</td>
                <td>{{ $row->track }}</td>
                <td>{{ $row->year_level }}</td>
                <td>{{ $row->semester == 1? '1ST SEMESTER':'2ND SEMESTER' }}</td>
                <td>{{ $row->adviser }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  
  @foreach($sections as $row)
  <!-- Modal -->
  <div class="modal fade" id="Modal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">{{ $row->year_level. ' - ' .$row->name }}</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>SUBJECT CODE</th>
                <th>DESCRIPTION</th>
                <th>GRADE</th>
                <th>TEACHER</th>
              </tr>
            </thead>
            <tbody>
              @foreach($row->grades as $grade)
              <tr>
                <td>{{ $grade->subject_code }}</td>
                <td>{{ $grade->subject_description }}</td>
                <td>{{ $grade->student_grade }}</td>
                <td>{{ $grade->teacher_name }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach

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