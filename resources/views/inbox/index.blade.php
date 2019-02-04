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
        Inboxes<small>All inboxes in the database.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('message.index') }}">Inboxes</a></li>
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
          {{-- button here --}}
          <button class="pull-right btn btn-danger" form="deleteAllForm"><i class="fa fa-trash"></i> Delete All</button>
          <form id="deleteAllForm" method="POST" action="{{ route('message.destroy.all') }}" onsubmit="return ConfirmDeleteAll()">
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            {{ method_field('DELETE') }}
          </form>
        </div>

        <div class="box-body overflow-hidden">

          <table id="crudTable" class="table table-striped table-hover display responsive" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($messages as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ strlen($row->message) >= 4 ? substr($row->message, 0, 20). '...' : $row->message }}</td>
                <td>{{ $row->created_at->toFormattedDateString() }}</td>
                <td><a href="#" class="btn btn-default btn-xs" id="viewMessage" data-id="{{ $row->id }}"><i class="fa fa-eye"></i> View</a> @if(Auth::user()->user_type == 1) <button type="submit" class="btn btn-xs btn-default" form="deleteMessage{{$row->id}}"><i class="fa fa-trash"></i> Delete</button>
                    <form id="deleteMessage{{$row->id}}" method="POST" action="{{ route('message.destroy', $row->id) }}" onsubmit="return ConfirmDelete()">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                            {{ method_field('DELETE') }}
                          </form>@endif</td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div>

  </div>

  <!-- Modal -->
  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">View Message</h4>
        </div>
        <div class="modal-body">
          {{-- modal content --}}
          <strong id="vname"></strong> <span class="small"><<span id="vemail"></span>></span>
          <span class="small pull-right" id="vdate"></span>
          <br>
          <span class="small" id="vcontact"></span>
          <p id="vmessage" style="margin-top: 20px;"></p>

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
  <script src="http://momentjs.com/downloads/moment.min.js"></script>

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
    // confirm delete
    function ConfirmDelete()
    {
    var x = confirm("Are you sure you want to delete this item?");
    if (x)
      return true;
    else
      return false;
    }

    function ConfirmDeleteAll()
    {
    var x = confirm("Are you sure you want to delete all inboxes?");
    if (x)
      return true;
    else
      return false;
    }

    // view message
    $('body').delegate('#crudTable #viewMessage', 'click', function(e) {
      var id = $(this).data(id);
      $.get("{{ route('message.show') }}", {id:id}, function(data) {
        $('#vname').html(data[0].name);
        $('#vemail').html(data[0].email);
        $('#vdate').html(data[0].created_at);
        $('#vcontact').html(data[0].contact);
        $('#vmessage').html(data[0].message);
        $('#messageModal').modal('show');
      });
    });
  </script>

@endsection

