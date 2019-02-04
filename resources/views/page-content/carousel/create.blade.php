@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Carousels<small>Add carousel.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('carousel.index') }}">Carousels</a></li>
        <li class="active">Add</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('carousel.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all carousels</a><br><br>
    
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

      <form method="post" action="{{ route('carousel.store') }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Add a new carousel</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="col-xs-12">
            <div class="alert alert-info" role="alert">
              <p><strong>Recommended Image Resolution: </strong>1200 x 700 pixels</p>
            </div>
          </div>

          <div class="form-group col-xs-12">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
          </div>

          <div class="form-group col-xs-12">
            <label>Content</label>
            <textarea class="form-control" name="content" rows="6"></textarea>
          </div>

          <div class="form-group col-xs-12">
            <label>Carousel Image</label>
            <input type="file" id="image_file_input" name="carousel_image" class="form-control">
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
