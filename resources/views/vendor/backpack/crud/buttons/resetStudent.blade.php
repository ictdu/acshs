 @if ($crud->hasAccess('reset_student'))
 <button form="resetStudent{{ $entry->getKey() }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Reset Password</button>

	<form onsubmit="return confirmReset()" id="resetStudent{{ $entry->getKey() }}" method="POST" action="{{ route('student.reset.password', $entry->getKey()) }}">
		{{ csrf_field() }}

	</form>
@endif

<script>
	function confirmReset()
	{
	var x = confirm("Are you sure you want to reset this Student's password?");
	if (x)
	return true;
	else
	return false;
	}   
</script>