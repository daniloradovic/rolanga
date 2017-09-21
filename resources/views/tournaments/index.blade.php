@extends('layouts.app')


@section('content')



<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-1 col-xs-12">
			<div class="panel panel-default">
				@if($tournaments->isEmpty())
				<div class="panel-heading center">NO ACTIVE TOURNAMENTS</div>
				<div class="panel-body">
					<ul class="list-group">
						<h5 class="list-group-item list-group-item-success center">Successfully registered players</h5>
						@foreach (App\User::where('verified','=','1')->get() as $user)
							<li class="list-group-item list-group-item-action center">{{ $user->name }}</li>
						@endforeach
					</ul>
					<ul class="list-group">
						<h5 class="list-group-item list-group-item-warning center">Players waiting for account verification</h5>
						@foreach (App\User::where('verified','=','0')->get() as $user)
							<li class="list-group-item list-group-item-action center">{{ $user->name }}</li>
						@endforeach
					</ul>
					@if (Auth::check())
					@if(Auth::user()->roles()->where('name','=','admin')->exists())
					<div class="center ">
						<a class="list-group-item list-group-item-info center" href="/create">Start New Tournament</a>
					</div>
					@endif
					@endif
				</div>
				@else
				<div class="panel-heading center">ACTIVE TOURNAMENTS</div>
				<div class="panel-body">
				<ul class="list-group">
					@if($errors->any())
					<div class="alert alert-danger" role="alert">
						<strong>{{$errors->first()}}</strong>
					</div>
					@endif
					<ul class="list-group">
					@foreach($tournaments as $tournament)
					<a class="list-group-item list-group-item-success center" href="/tournaments/{{ $tournament->id }}/groups">{{ $tournament->tournament_name }}</a>
					@endforeach

					@if (Auth::check())
					@if(Auth::user()->roles()->where('name','=','admin')->exists())
						<a class="list-group-item list-group-item-action center" href="/create">Start New Tournament</a>
					</ul>
					@endif
					@endif
				</ul>
				@endif
				</div>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection