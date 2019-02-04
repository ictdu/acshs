@extends('backpack::layout')

@section('after_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  .required-field {
    color: red;
  }

  .capital {
    text-transform: capitalize;
  }

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
        Student<small>Edit student.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('student.index') }}">Students</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <!-- Default box -->  
    <a href="{{ route('student.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all students</a><br><br>
    
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

      <form method="post" action="{{ route('student.update', $student->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

        <div class="form-group col-xs-6">
          <label>LRN<span class="required-field">*</span></label>
          <input type="input" class="form-control" name="lrn" value="{{ $student->lrn }}" required>
        </div>

        <div class="form-group col-xs-6">
          <label>Track <span class="required-field">*</span></label>
          <select class="form-control js-single" name="track_id">
            <option value="none">Select a track</option>
            @foreach($tracks as $row)
              <option @if($student->track_id == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-xs-12">
          <label>Firstname <span class="required-field">*</span></label>
          <input type="input" class="form-control capital" name="firstname" value="{{ $student->firstname }}" required>
        </div>

        <div class="form-group col-xs-12">
          <label>Middlename</label>
          <input type="input" class="form-control capital" name="middlename" value="{{ $student->middlename }}">
        </div>

        <div class="form-group col-xs-12">
          <label>Lastname <span class="required-field">*</span></label>
          <input type="input" class="form-control capital" name="lastname" value="{{ $student->lastname }}" required>
        </div>

        <div class="form-group col-xs-6">
          <label>Gender <span class="required-field">*</span></label>
          <select class="form-control" name="gender">
            <option value="none">Select a gender</option>
            <option @if($student->gender == 'Male') selected @endif value="Male">Male</option>
            <option @if($student->gender == 'Female') selected @endif value="Female">Female</option>
          </select>
        </div>

        <div class="form-group col-xs-6">
          <label>Birthday <span class="required-field">*</span></label>
          <input type="date" class="form-control" name="birthday" required value="{{ $student->birthday }}">
        </div>

        <div class="form-group col-xs-12">
          <label>Guardian</label>
          <input type="input" class="form-control" name="guardian" value="{{ $student->guardian }}">
        </div>

        <div class="form-group col-xs-6">
          <label>Contact</label>
          <input type="input" class="form-control" name="contact" value="{{ $student->contact }}" >
        </div>

        <div class="form-group col-xs-6">
          <label>Religion</label>
          <input type="input" class="form-control" name="religion" value="{{ $student->religion }}" >
        </div>

        <div class="form-group col-xs-6">
          <label>Address</label>
          <input type="input" class="form-control" name="address1" value="{{ $student->address1 }}" >
        </div>

        <div class="form-group col-xs-6">
          <label>Address2</label>
          <input type="input" class="form-control" name="address2" value="{{ $student->address2 }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Barangay</label>
          <input type="input" class="form-control" name="barangay" value="{{ $student->barangay }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Municipality</label>
          <input type="input" class="form-control" name="municipality" value="{{ $student->municipality }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Province</label>
          <input type="input" class="form-control" name="province" value="{{ $student->province }}" >
        </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
      <input type="hidden" name="_token" value="{{ Session::token() }}">
      {{ method_field('PUT') }}
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
