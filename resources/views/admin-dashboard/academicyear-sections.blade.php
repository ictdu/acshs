@extends('backpack::layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ $ay->start. ' - ' .$ay->end }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Academic Year</li>
      </ol>
    </section>
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div> -->
    
                <div class="box-body">
                  <table class="table table-stripped table-hover" id="ay-table">
                    <thead>
                      <tr>
                        <th>Section Name</th>
                        <th>Grade Level</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($sections as $row)
                      @if($ay->id == $row->academic_year_id)
                      <tr>
                        <td> {{ $row->name }} </td>
                        <td> @foreach($years as $year) @if($year->id == $row->year_id) {{ $year->name }} @endif @endforeach</td>
                        <td><a class="btn btn-xs btn-default" href="{{ route('section.students.view', $row->id) }}"><i class="fa fa-eye"></i> View Students</a></td>
                      </tr>
                      @endif
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
    $('#ay-table').DataTable();
    } );
  </script>
@endsection
