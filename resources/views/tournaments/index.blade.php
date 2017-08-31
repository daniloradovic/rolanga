@extends('layouts.app')


@section('content')

<h2 class="tournament-title">

		{{-- <a href="/tournament/{{ $tournament->id }}">

			{{ $tournament->tournament_name }}

		</a> --}}
</h2>

<div class="container">
	<a class="btn btn-primary btn-lg" href="/create">Start New Tournament</a>
</div>

@endsection