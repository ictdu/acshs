<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
{{-- for content managers --}}
@if(Auth::user()->user_type == 2)
<li><a href="{{backpack_url('announcement') }}"><i class="fa fa-bullhorn"></i> <span>Announcements</span></a></li>
<li><a href="{{ route('message.index') }}"><i class="fa fa-inbox"></i> <span>Inbox</span></a></li>

<li class="treeview">
  <a href="#"><i class="fa fa-newspaper-o"></i> <span>Content Management</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ route('logo.index') }}"><i class="fa fa-circle"></i> <span>Logo</span></a></li>
    <li><a href="{{ route('schoolname.index') }}"><i class="fa fa-adn"></i> <span>School Name</span></a></li>
    <li><a href="{{ route('carousel.index') }}"><i class="fa fa-image"></i> <span>Carousel</span></a></li>
    <li><a href="{{ route('about.index') }}"><i class="fa fa-pencil"></i> <span>About</span></a></li>
    <li><a href="{{backpack_url('facility') }}"><i class="fa fa-th"></i> <span>Facilities</span></a></li>
    <li><a href="{{backpack_url('administration') }}"><i class="fa fa-users"></i> <span>Administration</span></a></li>
    <li><a href="{{ route('album.index') }}"><i class="fa fa-image"></i> <span>Album</span></a></li>
  </ul>
</li>{{-- for content managers --}}

@else

<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{backpack_url('announcement') }}"><i class="fa fa-bullhorn"></i> <span>Announcements</span></a></li>
<li><a href="{{ route('message.index') }}"><i class="fa fa-inbox"></i> <span>Inbox</span></a></li>

<li class="treeview">
  <a href="#"><i class="fa fa-newspaper-o"></i> <span>Content Management</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ route('logo.index') }}"><i class="fa fa-circle"></i> <span>Logo</span></a></li>
    <li><a href="{{ route('schoolname.index') }}"><i class="fa fa-adn"></i> <span>School Name</span></a></li>
    <li><a href="{{ route('carousel.index') }}"><i class="fa fa-image"></i> <span>Carousel</span></a></li>
    <li><a href="{{ route('about.index') }}"><i class="fa fa-pencil"></i> <span>About</span></a></li>
    <li><a href="{{backpack_url('facility') }}"><i class="fa fa-th"></i> <span>Facilities</span></a></li>
    <li><a href="{{backpack_url('administration') }}"><i class="fa fa-users"></i> <span>Administration</span></a></li>
    <li><a href="{{ route('album.index') }}"><i class="fa fa-image"></i> <span>Album</span></a></li>
  </ul>      
</li>

<li class="treeview">
  <a href="#"><i class="fa fa-newspaper-o"></i> <span>Grade Management</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ route('schoolyear.index') }}"><i class="fa fa-braille"></i> <span>School Year</span></a></li>
    <li><a href="{{ route('track.index') }}"><i class="fa fa-bookmark"></i> <span>Track</span></a></li>
    <li><a href="{{ route('subject.index') }}"><i class="fa fa-book"></i> <span>Subject</span></a></li>
    <li><a href="{{ route('teacher.index') }}"><i class="fa fa-users"></i> <span>Teacher</span></a></li>
    <li><a href="{{ route('student.index') }}"><i class="fa fa-graduation-cap"></i> <span>Student</span></a></li>
    <li><a href="{{ route('section.index') }}"><i class="fa fa-list"></i> <span>Class</span></a></li>
    <li><a href="{{ route('grade.settings.index') }}"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
  </ul>
</li>

<li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Content Managers</span></a></li>
<li><a href="{{ route('log.index') }}"><i class="fa fa-history"></i> <span>Logs</span></a></li>

@endif

