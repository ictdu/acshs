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
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Teacher<small>Edit teacher.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('teacher.index') }}">Teachers</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <!-- Default box -->  
    <a href="{{ route('teacher.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all teachers</a><br><br>
    
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

      <form method="post" action="{{ route('teacher.update', $teacher->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

        <div class="form-group col-xs-12">
          <label>Employee ID <span class="required-field">*</span></label>
          <input type="input" class="form-control" name="employee_id" value="{{ $teacher->employee_id }}" required>
        </div>

        <div class="form-group col-xs-12">
          <label>Firstname <span class="required-field">*</span></label>
          <input type="input" class="form-control capital" name="firstname" value="{{ $teacher->firstname }}" required>
        </div>

        <div class="form-group col-xs-12">
          <label>Middlename</label>
          <input type="input" class="form-control capital" name="middlename" value="{{ $teacher->middlename }}">
        </div>

        <div class="form-group col-xs-12">
          <label>Lastname <span class="required-field">*</span></label>
          <input type="input" class="form-control capital" name="lastname" value="{{ $teacher->lastname }}" required>
        </div>

        <div class="form-group col-xs-6">
          <label>Gender <span class="required-field">*</span></label>
          <select class="form-control" name="gender">
            <option value="none">Select a gender</option>
            <option @if($teacher->gender == 'Male') selected @endif value="Male">Male</option>
            <option @if($teacher->gender == 'Female') selected @endif value="Female">Female</option>
          </select>
        </div>

        <div class="form-group col-xs-6">
          <label>Birthday <span class="required-field">*</span></label>
          <input type="date" class="form-control" name="birthday" required value="{{ $teacher->birthday }}">
        </div>

        <div class="form-group col-xs-12">
          <label>Contact</label>
          <input type="input" class="form-control" name="contact" value="{{ $teacher->contact }}" >
        </div>

        <div class="form-group col-xs-6">
          <label>Address</label>
          <input type="input" class="form-control" name="address1" value="{{ $teacher->address1 }}" >
        </div>

        <div class="form-group col-xs-6">
          <label>Address2</label>
          <input type="input" class="form-control" name="address2" value="{{ $teacher->address2 }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Barangay</label>
          <input type="input" class="form-control" name="barangay" value="{{ $teacher->barangay }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Municipality</label>
          <input type="input" class="form-control" name="municipality" value="{{ $teacher->municipality }}" >
        </div>

        <div class="form-group col-xs-4">
          <label>Province</label>
          <input type="input" class="form-control" name="province" value="{{ $teacher->province }}" >
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
