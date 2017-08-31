@extends('layouts.app')

@section('content')

@foreach($groups as $group)

	<h1>{{ $group->group_name }}</h1>

@endforeach
@endsection
