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
        School Years<small>All school years in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('schoolyear.index') }}">School Years</a></li>
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
            <a href="{{ route('schoolyear.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add School Year</a>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive" cellspacing="0">
            <thead>
              <tr>
                {{-- <th>ID</th> --}}
                <th>School Year</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($schoolyears as $row)
              <tr>
                {{-- <td>{{ $row->id }}</td> --}}
                <td>{{ $row->year }}</td>
                <td><a href="{{ route('schoolyear.show', $row->id) }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> View</a><a href="{{ route('schoolyear.edit', $row->id) }}" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                  @if(!in_array($row->id, $schoolyearCantBeDelete))
                  <button type="submit" class="btn btn-xs btn-default" form="deleteSchoolYear{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                  @endif
                    <form id="deleteSchoolYear{{$row->id}}" method="POST" action="{{ route('schoolyear.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                      {{ method_field('DELETE') }}
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
        $('#crudTable').DataTable({
          "order": [[ 0, "desc" ]]
        });
    } );

    // confirm delete
    function ConfirmDelete()
    {
    var x = confirm("Are you sure you want to delete this item?");
    if (x)
      return true;
    else
      return false;
    }
  </script>

@endsection

