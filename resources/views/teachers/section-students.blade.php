@extends('teacher-layout')

@section('after_styles')
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/parsley.css') }}">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ $section->name }} <small> View students</small>
      </h1>
          </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{ session('success') }}
                    </div>
            @endif
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><small>Subject: </small>{{ $subject->name }}</div>
                </div>

                <div class="box-body">
                  <form id="grade-form" method="POST" data-parsley-validate>
                    {{ csrf_field() }}
                    <table id="student-table" class="table table-stripped table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Firstname</th>
                          <th>Middlename</th>
                          <th>Lastname</th>
                          <th>Gender</th>
                          <th>Birthday</th>
                          <th>Contact</th>
                          <th>Address</th>
                          <th>Grade</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                          @foreach($section->students as $student)
                          
                          <tr>
                            <td>{{ $student->s_id }}</td>
                            <td>{{ $student->firstname }}</td>
                            <td>{{ $student->middlename }}</td>
                            <td>{{ $student->lastname }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->birthday }}</td>
                            <td>{{ $student->contact }}</td>
                            <td>{{ $student->address1 }}</td>
                            <td>
                              
                                <input type="text" name="{{ $student->s_id }}" class="form-control input-sm" size="5" @foreach($grades as $grade) @if($section->id == $grade->section_id && $student->s_id == $grade->student_id && $subject_id == $grade->subject_id && Auth::user()->id == $grade->teacher_id) value="{{ $grade->grade }}" @if($grade->not_editable == 1) disabled @endif @endif @endforeach data-parsley-length="[0, 100]" data-parsley-type="digits">
                              
                            </td>
                          </tr>
                          @endforeach
                        
                      </tbody>
                    </table>                   
                  </form>
                  <hr>
                  @if($section->students->count() > 0)
                    <button form="grade-form" formaction="{{ route('student.grade.update', [$section->id, $subject_id]) }}" class="pull-right btn btn-success btn-sm"><i class="fa fa-save"></i> Save Grade</button>
                    <a href="{{ route('teacher.import.csv', [$section->id, $subject->id]) }}" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-upload"></i> Upload Csv</a>
                    <a href="{{ route('exportcsv', [$section->id, $subject->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Export Student</a>
                  @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
<script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#student-table').DataTable();
    } );
  </script>
  
@endsection

