@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
		{{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
		
		    <div class="form-group">
		        {{ Form::label('name', 'Name') }}
		        {{ Form::text('name', null, array('class' => 'form-control')) }}
		    </div>

		    <div class="form-group">
		        {{ Form::label('email', 'Email') }}
		        {{ Form::email('email', null, array('class' => 'form-control')) }}
		    </div>
			@if (Auth::check() && (Auth::user()->id == $user->id || Auth::user()->roles()->where('name','=','admin')->exists()))
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Save</button>
			@endif

		{{ Form::close() }}
		</div>	
	</div>
</div>


@endsection