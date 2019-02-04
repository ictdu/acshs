@extends('teacher-layout')

@section('header')
    <section class="content-header">
      <h1>
        My Account<small> Account information</small>
      </h1>
      
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{ session('success') }}
                    </div>
            @endif
            @if($errors->has('profile_picture'))
                <div class="alert alert-danger alert-dismissible fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><i class="fas fa-exclamation-triangle"></i></strong> {{ $errors->first('profile_picture') }}
                </div>
             @endif
             @if($errors->has('email'))
                <div class="alert alert-danger alert-dismissible fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p><strong><i class="fas fa-exclamation-triangle"></i></strong> {{ $errors->first('email') }}</p>                 
                </div>
             @endif
             @if($errors->has('old_password') || $errors->has('new_password'))
                <div class="alert alert-info alert-dismissible fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  @if($errors->has('old_password'))
                    <p><strong><i class="fas fa-info"></i></strong> {{ $errors->first('old_password') }}</p>
                  @endif
                  @if($errors->has('new_password'))
                    <p><strong><i class="fas fa-info"></i></strong> {{ $errors->first('new_password') }}</p>
                  @endif
                </div>
             @endif
            <div class="box box-default">
                <!-- <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div> -->

                <div class="box-body">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            Update Profile Picture</a>
                          </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse @if($errors->has('profile_picture')) in @endif @if(session('picture-is-in')) in @endif">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        @if(Auth::user()->image == '')
                                            <img src=" {{ backpack_avatar_url(backpack_auth()->user()) }} " width="100" height="100">
                                        @else
                                            <img src="{{ asset('uploads/teacher/' . Auth::user()->image) }}" width="100" height="100">
                                        @endif
                                    </div>
                                    <div class="col-md-8">                          
                                        <form action="{{ route('teacher.update.picture') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="parsley">
                                            {{ csrf_field() }}
                                            <input type="file" name="profile_picture" class="form-group margin-top-30" required data-parsley-required-message="Please insert an image">
                                            <button class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                        </form>
                                    </div>
                                </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            Update Account Info</a>
                          </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse @if($errors->has('email')) in @endif @if(session('info-is-in')) in @endif">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputName">Firstname</label>
                                            <input type="text" class="form-control"  placeholder="Name" value="{{ Auth::user()->firstname }}" name="name" required data-parsley-required-message="Name is required" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputName">Middlename</label>
                                            <input type="text" class="form-control"  placeholder="Name" value="{{ Auth::user()->middlename }}" name="name" required data-parsley-required-message="Name is required" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputName">Lastname</label>
                                            <input type="text" class="form-control"  placeholder="Name" value="{{ Auth::user()->lastname }}" name="name" required data-parsley-required-message="Name is required" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputName">Teacher ID</label>
                                            <input type="text" class="form-control"  placeholder="Name" value="{{ Auth::user()->t_id }}" name="name" required data-parsley-required-message="Name is required" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputName">Gender</label>
                                            <input type="text" class="form-control"  placeholder="Name" value="{{ Auth::user()->gender }}" name="name" required data-parsley-required-message="Name is required" disabled>
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('teacher.update.info') }}" method="POST" data-parsley-validate="parsley">
                                  {{ csrf_field() }}
                                  <div class="form-group">
                                    <label for="exampleInputEmail">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email" value="{{ Auth::user()->email }}" name="email" required data-parsley-required-message="Email is required">
                                  </div>
                                  <button class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            Update Password</a>
                          </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse @if($errors->has('old_password') || $errors->has('new_password')) in @endif @if(session('password-is-in')) in @endif">
                          <div class="panel-body">
                                <form action="{{ route('teacher.update.password', Auth::user()->id) }}" method="POST" data-parsley-validate="parsley">
                                  <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" class="form-control" placeholder="Old Password" name="old_password" required data-parsley-required-message="Old Password is required">
                                  </div>
                                  <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" placeholder="New Password" name="new_password" required data-parsley-required-message="New Password is required">
                                  </div>
                                  <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm New Password" name="new_password_confirmation" required data-parsley-required-message="New Password is required"> 
                                  </div>
                                  <button class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                   <input type="hidden" name="_token" value="{{ Session::token() }}">
                                    {{ method_field('PUT') }}
                                </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection