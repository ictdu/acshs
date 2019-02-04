@extends('backpack::layout')

@section('after_styles')
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
        Class<small>Manage subjects and teachers.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('section.index') }}">Classes</a></li>
        <li class="active">Manage Subjects and Teachers</li>
      </ol>
    </section>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4">
      <div class="box">
        <div class="box-header hidden-print with-border">
          <h5><i class="fa fa-list"></i></h5>
        </div>

        <div class="box-body overflow-hidden">
          <div class="row">
            <div class="col-md-4">
              <label>Name: </label>
            </div>
            <div class="col-md-8">
              <label>{{ $section['name'] }}</label>
            </div>

            <div class="col-md-4">
              <label>School Year:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $section['schoolyear'] }}</label>
            </div>

            <div class="col-md-4">
              <label>Track:</label>
            </div>
            <div class="col-md-8">
              <label>{{ $section['track'] }}</label>
            </div>

            <div class="col-md-4">
              <label>Year Level
            </div>
            <div class="col-md-8">
              <label>{{ $section['year_level'] }}</label>
            </div>

            <div class="col-md-4">
              <label>Semester</label>
            </div>
            <div class="col-md-8">
              <label>{{ $section['semester'] == 1 ? '1st':'2nd' }}</label>
            </div>

            <div class="col-md-4">
              <label>Adviser</label>
            </div>
            <div class="col-md-8">
              <label>{{ $section['adviser'] }}</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="box">
        <div class="box-header hidden-print with-border">
          <button class="btn btn-default" id="addRowBtn"><i class="fa fa-plus"></i> Add Row</button>
        </div>

        <div class="box-body overflow-hidden">
          <form method="POST" action="{{ route('section.subject-teacher.store', $section['id']) }}">
            {{ csrf_field() }}
            <table id="subjectTeacherTable" class="table">
                <thead>
                    <tr>
                        <th style="width: 45%;">Subject</th>
                        <th style="width: 45%;">Teacher</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($ssts as $sst)
                  <tr>
                    <td>
                      <select class="form-control js-single" name="subject_1">
                        <option value="none">Select subject</option>
                        @foreach($subjects as $row)
                          <option @if($sst->subject_id == $row->id) selected @endif value="{{ $row->id }}">{{ $row->description. ' (' .$row->code. ')' }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control js-single" name="teacher_1">
                        <option value="none">Select Teacher</option>
                        @foreach($teachers as $row)
                          <option @if($sst->teacher_id == $row->id) selected @endif value="{{ $row->id }}">{{ $row->firstname. ' ' .$row->lastname. ' (' .$row->employee_id. ')' }}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                  @endforeach
                  @if($ssts->count() == 0)
                  <tr>
                    <td>
                      <select class="form-control js-single" name="subject_1">
                        <option value="none">Select subject</option>
                        @foreach($subjects as $row)
                          <option value="{{ $row->id }}">{{ $row->description. ' (' .$row->code. ')' }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control js-single" name="teacher_1">
                        <option value="none">Select Teacher</option>
                        @foreach($teachers as $row)
                          <option value="{{ $row->id }}">{{ $row->firstname. ' ' .$row->lastname. ' (' .$row->employee_id. ')' }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td></td>
                  </tr>
                  @endif
                </tbody>
            </table>
            <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
          </form>
        </div>
      </div>
    </div>

  </div>

@endsection

@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.js-single').select2();
  });

  $("#addRowBtn").on('click',function() {
    // table length
    var rowLength = $('#subjectTeacherTable tbody tr').length + 1;
    console.log(rowLength);

    // console.log('wew');
      /*// alert('working!');
    var $book_id = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".ir")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>*/

    var markup = "<tr><td><select name='subject_"+rowLength+"' class='form-control js-single'><option value='none'>Select subject</option>@foreach($subjects as $row)<option value='{{$row->id}}'>{{$row->description. ' (' .$row->code. ')'}}</option>@endforeach</select></td><td><select name='teacher_"+rowLength+"' class='form-control js-single'><option value='none'>Select Teacher</option>@foreach($teachers as $row)<option value='{{$row->id}}'>{{$row->firstname. ' ' .$row->lastname. ' (' .$row->employee_id. ')'}}</option>@endforeach</select></td><td><button id='delete-row' type='button' class='btn btn-danger'><i class='fa fa-trash'></i></button></td></tr>";
    $("#subjectTeacherTable tbody").append(markup);
    $('.js-single').select2();
  });

  $('#subjectTeacherTable').on('click', '#delete-row', function() {
      $(this).closest('tr').remove();
  });
</script>
@endsection