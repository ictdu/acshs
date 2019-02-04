@extends('teacher-layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/teacherdashboard.css') }}">

@endsection

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>Teacher dashboard</small>
      </h1>
      
    </section>
@endsection


@section('content')
    <div class="row">
        
        
    </div>
@endsection