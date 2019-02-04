@extends('backpack::layout')

@section('after_styles')
<style>
  .imgContainer {
    position: relative;
    margin: 20px;
  }

  /* Top right text */
.top-right {
    position: absolute;
    top: -80px;
    right: 13px;
    color: white;
    background-color: black;
    border-radius: 50px;
    width: 20px;
    text-align: center;
}
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Albums<small>Edit album.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('album.index') }}">Albums</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <!-- Default box -->  
    <a href="{{ route('album.index') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all albums</a><br><br>
    
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

      <form method="post" action="{{ route('album.update', $album->id) }}" enctype="multipart/form-data">
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>
        </div>
        <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">

          <div class="form-group col-xs-12">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $album->name }}">
          </div>

          <div class="form-group col-xs-12">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="5">{{ $album->description }}</textarea>
          </div>

          <div class="form-group col-xs-12">
            <label>Album Images</label>
            <input type="file" id="image_file_input" name="album_image[]" class="form-control" multiple>
          </div>

          <div class="form-group col-xs-12" id="imageGroup">
            @foreach($photos as $photo)
            <div id="imageRow_{{$photo->id}}" style="padding-top:20px;" class="col-xs-4">
                <a href="#" id="btnImageRemove" data-id="{{ $photo->id }}" style="position: absolute; left: 20px; background-color: black; color: white; width: 20px; border-radius: 50px; text-align: center; top: 25px;"> <i class="fa fa-times"></i></a>
                <img id="image_{{ $album->id }}" src="{{ asset('img/album/'. $photo->image) }}" style="width: 100%;" name="{{ $photo->id }}">
                <input type="hidden" name="{{ $photo->id }}" value="{{ $photo->id }}">
            </div>
            @endforeach
          </div>

          {{-- <div class="form-group" id="imageGroup">
              @foreach($photos as $photo)
                  <div id="imageRow_{{$photo->id}}">
                      <a href="#" id="btnImageRemove" data-id="{{ $photo->id }}"> X</a>
                      <img id="image_{{ $album->id }}" src="{{ asset('img/album/'. $photo->image) }}" width="300" name="{{ $photo->id }}">
                      <input type="hidden" name="{{ $photo->id }}" value="{{ $photo->id }}">
                  </div>
              @endforeach
          </div> --}}

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
    <script>
        $('body').delegate('#imageGroup #btnImageRemove', 'click', function(e) {
            var id = $(this).data(id);
            console.log('image_'+id['id']);
            $('#imageGroup #imageRow_'+id['id']).remove();
        });
    </script>
@endsection
