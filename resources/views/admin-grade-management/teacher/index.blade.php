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
        Teachers<small>All teachers in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('teacher.index') }}">Teachers</a></li>
        <li class="active">List</li>
      </ol>
    </section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border">
            <a href="{{ route('teacher.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Teacher</a>
            <a href="{{ route('teacher.v-import') }}" class="btn btn-primary"><i class="fa fa-upload"></i> Add Teacher Using Csv</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teachers as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->employee_id }}</td>
                <td>{{ $row->firstname }}</td>
                <td>{{ $row->lastname }}</td>
                <td><a href="{{ route('teacher.show', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View</a><a href="{{ route('teacher.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> <button type="submit" class="btn btn-xs btn-default" form="resetTeacher{{$row->id}}"><i class="fa fa-lock"></i> Reset Password</button> @if(!in_array($row->id, $cantDelete))
                  <button type="submit" class="btn btn-xs btn-default" form="deleteTeacher{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>

                    {{-- delete form --}}
                    <form id="deleteTeacher{{$row->id}}" method="POST" action="{{ route('teacher.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                      {{ method_field('DELETE') }}
                    </form>@endif

                    {{-- reset pass form --}}
                    <form id="resetTeacher{{$row->id}}" method="POST" action="{{ route('teacher.resetpassword', $row->id) }}" onsubmit="return ConfirmReset()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                      {{ method_field('PUT') }}
                    </form></td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div><!-- /.box-body -->

      </div><!-- /.box -->
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
    $(document).ready( function () {
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
    } );

    /*$(document).ready( function () {
        $('#crudTable').DataTable({
          "order": [[ 0, "desc" ]]
        });
    } );*/

    // confirm delete
    function ConfirmDelete()
    {
    var x = confirm("Are you sure you want to delete this item?");
    if (x)
      return true;
    else
      return false;
    }

    // confirm reset
    function ConfirmReset()
    {
    var x = confirm("Are you sure you want to reset the password of this teacher?");
    if (x)
      return true;
    else
      return false;
    }
  </script>

@endsection

