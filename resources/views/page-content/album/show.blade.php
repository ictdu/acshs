@extends('backpack::layout')

@section('after_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
<style>
	/* Override bootstrap column paddings */
	.tz-gallery .row > div {
	    padding: 2px;
	}

	.tz-gallery .lightbox img {
	    width: 100%;
	    border-radius: 0;
	    position: relative;
	}

	.tz-gallery .lightbox:before {
	    position: absolute;
	    top: 50%;
	    left: 50%;
	    margin-top: -13px;
	    margin-left: -13px;
	    opacity: 0;
	    color: #fff;
	    font-size: 26px;
	    font-family: 'Glyphicons Halflings';
	    content: '\e003';
	    pointer-events: none;
	    z-index: 9000;
	    transition: 0.4s;
	}


	.tz-gallery .lightbox:after {
	    position: absolute;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    opacity: 0;
	    background-color: rgba(46, 132, 206, 0.7);
	    content: '';
	    transition: 0.4s;
	}

	.tz-gallery .lightbox:hover:after,
	.tz-gallery .lightbox:hover:before {
	    opacity: 1;
	}

	.baguetteBox-button {
	    background-color: transparent !important;
	}
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>
        Albums<small>All images in {{$album->name}}.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li><a href="{{ route('album.index') }}">Albums</a></li>
        <li class="active">Show</li>
      </ol>
    </section>
@endsection

@section('content')
	<div style="padding: 30px 50px;">
		<div class="tz-gallery">

		    <div class="row">
				@foreach($photos as $row)
				<div class="col-sm-12 col-md-4">
		            <a class="lightbox" href="{{ asset('img/album/'.$row->image) }}">
		                <img src="{{ asset('img/album/'.$row->image) }}" alt="Bridge">
		            </a>
		        </div>
		        @endforeach
			</div>

		</div>
	</div>
@endsection

@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
@endsection