@extends('teacher-layout')

@section('after_styles')
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Sections <small> View all sections</small>
      </h1>
          </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">wew</div>
                </div> -->

                <div class="box-body">
                  <table id="section-table" class="table table-stripped table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Year Level</th>
                        <th>A.Y.</th>
                        <th>Subject</th>
                        <th>Students</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($sections as $section)
                      <tr>
                        <td>{{ $section->section_name }}</td>
                        <td>{{ $section->year_level_name }}</td>
                        <td>{{ $section->academic_year }}</td>
                        <td>{{ $section->subject_name }}</td>
                        <td>{{ $section->students }}</td>
                        <td><a href="{{ route('teacher.view.section.students', [$section->section_id, $section->subject_id]) }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> View Students</a></td>
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
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#section-table').DataTable();
    } );
  </script>
@endsection