@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row list-group">
		@foreach ($users as $user)
		<div class="player-item col-lg-2 col-sm-6">
			<div class="player h-100">
				<a href="/users/{{ $user->id }}">
					<img class="player-img-top" src="/uploads/avatars/{{ $user->avatar }}" style="width: 150px; height: 150px;">
				</a>
			</div>
			<div class="player-body">
				<h4 class="player-title">
					{{ $user->name }}					
				</h4>
	
				@if($user->tournaments->count() != 0)
					<p class="player-text">Participating in</p>
					
					@foreach($user->tournaments as $tournament)
						<a href="/tournaments/{{ $tournament->id }}/groups">{{ $tournament->tournament_name }} </a>	
					@endforeach
				@else
					<p>No active tournaments for this player</p>
				@endif
			</div>
		</div>     
			{{-- <ul class="list-group">
					@foreach ($users as $user)
						<li class="list-group-item ">{{ $user->name }}</li>
					<a class="btn btn-small btn-success " href="{{ URL::to('users/' . $user->id) }}">Show this player</a>

					edit this player (uses the edit method found at GET /users/{id}/edit
					<a class="btn btn-small btn-info " href="{{ URL::to('users/' . $user->id . '/edit') }}">Edit this player</a>

					@endforeach
				</ul> --}}
		@endforeach
	</div>
</div>

@endsection


	{{-- style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;"  --}}