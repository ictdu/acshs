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
        Class<small>Add class.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('section.index') }}">Classes</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <!-- Default box -->  
    <a href="{{ route('section.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all classes</a><br><br>
    
    {{-- Show the errors, if any --}}
    @if ($errors->any())
        <div class="callout callout-danger">
            {{-- <h4>dsasdadsa</h4> --}}
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form method="post" action="{{ route('section.store') }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new class</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

        <div class="form-group col-xs-12">
          <label>Name</label>
          <input type="text" name="name" class="form-control">
        </div>

        <div class="form-group col-xs-12">
          <label>School Year</label>
          <select class="form-control js-single" name="schoolyear_id">
            <option value="none">Select school year</option>
            @foreach($schoolyears as $row)
              <option value="{{ $row->id }}">{{ $row->year }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-xs-12">
          <label>Track</label>
          <select class="form-control js-single" name="track_id">
            <option value="none">Select track</option>
            @foreach($tracks as $row)
              <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-xs-12">
          <label>Year Level</label>
          <select class="form-control js-single" name="year_level">
            <option value="none">Select year level</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
        </div>

        <div class="form-group col-xs-12">
          <label>Semester</label>
          <select class="form-control js-single" name="semester">
            <option value="none">Select semester</option>
            <option value="1">1st</option>
            <option value="2">2nd</option>
          </select>
        </div>

        <div class="form-group col-xs-12">
          <label>Adviser</label>
          <select class="form-control js-single" name="adviser">
            <option value="none">Select adviser</option>
            @foreach($teachers as $row)
              <option value="{{ $row->id }}">{{ $row->firstname. ' ' .$row->middlename. ' ' .$row->lastname . ' (Employee id: ' .$row->employee_id. ')'}}</option>
            @endforeach
          </select>
        </div>

   

        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
      </form>
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
</script>
@endsection
