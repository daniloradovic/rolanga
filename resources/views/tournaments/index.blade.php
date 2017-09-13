@extends('layouts.app')


@section('content')



<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<h2 class="tournament-title">Active Tournaments</h2>
			<div class="list-group">
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						<strong>{{$errors->first()}}</strong>
					</div>
				@endif
				
				@foreach($tournaments as $tournament)
					<a class="list-group-item list-group-item-action" href="/tournaments/{{ $tournament->id }}/groups">{{ $tournament->tournament_name }}</a>
				@endforeach
			</div>
			@if (Auth::check())
				@if(Auth::user()->roles()->where('name','=','admin')->exists())
					<a class="btn btn-primary btn-lg" href="/create">Start New Tournament</a>
				@endif
			@endif
		</div>
	</div>
</div>



@endsection