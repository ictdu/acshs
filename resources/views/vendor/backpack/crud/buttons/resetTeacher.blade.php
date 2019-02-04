
 @if ($crud->hasAccess('reset_teacher'))
 <button form="resetTeacher{{ $entry->getKey() }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Reset Password</button>

	<form onsubmit="return confirmReset()" id="resetTeacher{{ $entry->getKey() }}" method="POST" action="{{ route('teacher.reset.password', $entry->getKey()) }}">
		{{ csrf_field() }}

	</form>
@endif

<script>
	function confirmReset()
	{
	var x = confirm("Are you sure you want to reset this Teacher's password?");
	if (x)
	return true;
	else
	return false;
	}   
</script>