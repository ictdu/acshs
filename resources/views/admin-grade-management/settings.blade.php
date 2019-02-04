@extends('backpack::layout')

@section('after_styles')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/admindashboard.css') }}">
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

  <style>
    .onoffswitch {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }
    .onoffswitch-checkbox {
        display: none;
    }
    .onoffswitch-label {
        display: block; overflow: hidden; cursor: pointer;
        border: 2px solid #999999; border-radius: 20px;
    }
    .onoffswitch-inner {
        display: block; width: 200%; margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before, .onoffswitch-inner:after {
        display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
        font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
        box-sizing: border-box;
    }
    .onoffswitch-inner:before {
        content: "ON";
        padding-left: 10px;
        background-color: #325A88; color: #FFFFFF;
    }
    .onoffswitch-inner:after {
        content: "OFF";
        padding-right: 10px;
        background-color: #EEEEEE; color: #999999;
        text-align: right;
    }
    .onoffswitch-switch {
        display: block; width: 18px; margin: 6px;
        background: #FFFFFF;
        position: absolute; top: 0; bottom: 0;
        right: 56px;
        border: 2px solid #999999; border-radius: 20px;
        transition: all 0.3s ease-in 0s; 
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
        right: 0px; 
    }
  </style>

@endsection

@section('header')
    <section class="content-header">
      <h1>
        Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">Admin</a></li>
        <li class="active">Grade Settings</li>
      </ol>
    </section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-6 col-md-offset-3">
      <div class="box">
        <!-- <div class="box-header hidden-print with-border">
        
        </div> -->

        <div class="box-body overflow-hidden">

          <div class="row">
            <div class="col-md-10">
              <label>Allow Teachers to input grades <small class="text-muted">Status: {{ $activation->status == 1 ? 'Enabled':'Disabled' }}</small></label>
            </div>
            <div class="col-md-2">
              <label><a href="#" data-toggle="modal" data-target="#myModal">{{ $activation->status == 1 ? 'Disable':'Enable' }}</a></label>
            </div>
          </div>
          
        </div><!-- /.box-body -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              
              <div class="modal-body">
                {{ $activation->status == 1 ? 'Disabling this will not allow Teachers to input grades':'Enabling this will allow Teachers to input grades' }}
              </div>
              <div class="modal-footer">
                <form method="POST" id="activation_form" action="{{ route('grade.settings.activation') }}">
                  <input type="hidden" name="id" value="{{ $activation->id }}">
                  <input type="hidden" name="_token" value="{{ Session::token() }}">
                  {{ method_field('PUT') }}
                </form>
                <button type="submit" class="btn btn-primary" form="activation_form">Okay</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /.box -->
    </div>

  </div>

@endsection