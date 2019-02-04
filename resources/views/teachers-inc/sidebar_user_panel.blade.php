<div class="user-panel">
  <a class="pull-left image" href="#">
      <img src="{{ backpack_avatar_url(backpack_auth()->user()) }}" class="img-circle" alt="User Image">
  </a>
  <div class="pull-left info">
    <p><a href="{{ route('teacher.view.account') }}">{{ backpack_auth()->user()->firstname. ' ' .backpack_auth()->user()->lastname }}</a></p>
    <small><small><a href="{{ route('teacher.view.account') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ route('teacher.logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
  </div>
</div>