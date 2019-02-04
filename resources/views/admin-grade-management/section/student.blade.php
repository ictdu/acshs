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

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #325a88;
      border: 1px solid #333;
      border-radius: 4px;
      cursor: default;
      float: left;
      margin-right: 5px;
      margin-top: 5px;
      padding: 0 5px;
  }
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Class<small>Manage students.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('section.index') }}">Classes</a></li>
        <li class="active">Manage Students</li>
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

      <div class="box">
        <div class="box-header hidden-print with-border">
          <h5><i class="fa fa-graduation-cap"></i></h5>
        </div>

        <div class="box-body overflow-hidden">
          <form method="POST" action="{{ route('section.student.store', $section['id']) }}">
            {{ csrf_field() }}

            <div class="form-group col-xs-12">
              <label>Students</label>
              <select class="js-example-placeholder-multiple form-control js-example-basic-multiple" name="students[]" multiple="multiple">
                @foreach($students as $row)
                <option @if(in_array($row->id, $sts)) selected @endif value="{{ $row->id }}">{{ $row->firstname. ' ' .$row->lastname. ' (' .$row->lrn. ')'}}</option>
                @endforeach
              </select>
            </div>
            
            <div class="form-group col-xs-2 col-xs-offset-10">
              <button type="submit" class="pull-right btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
            </div>

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

  $(document).ready(function() {
      // $('.js-example-basic-multiple').select2();

      $(".js-example-placeholder-multiple").select2({
          placeholder: "Select students"
      });

  });

</script>
@endsection
