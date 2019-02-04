@extends('teacher-layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ $section->name }}<small> Import Student Grade</small>
      </h1>
          </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
        	  @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{ session('error') }}
                    </div>
            @endif

            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">wew</div>
                </div> -->

                <div class="box-body">
                	<p>Subject: <span class="lead"> {{ $subject->name }}</span> </p>
                  	<form method="POST" action="{{ route('teacher.submit.csv', [$section->id, $subject->id]) }}" enctype="multipart/form-data">
                  	{{ csrf_field() }}
					  <div class="form-group">
					    <input type="file" class="form-control-file" name="sel_file">
					  </div>
					  <button class="btn btn-success btn-sm"><i class="fa fa-upload"></i> Upload</button>
					</form>
                </div>
            </div>
        </div>
    </div>
@endsection