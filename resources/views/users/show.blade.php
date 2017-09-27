@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-2 col-xs-12">
			<div class="media ">
				<img src="/uploads/avatars/{{ $user->avatar }}" style="width: 150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;" alt="" class="pull-left player-item">
				<div class=" media panel panel-default col-md-8 col-xs-12">
					<div class="panel-heading center">
						{{ $user->name }}
					</div>
					<div class="table-responsive ">
						<table class="table table-condensed">
							<tbody>
								<tr>
									<td>Joined:</td>
									<td>{{ \Carbon\Carbon::parse($user->created_at)->toFormattedDateString() }}</td>
								</tr>
								<tr>
									<td>Active in tournaments</td>
									<td>
									@foreach($user->tournaments as $tournament)
									<a href="/tournaments/{{ $tournament->id }}/groups">{{ $tournament->tournament_name}}</a>
									@endforeach
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					@if (Auth::check() && Auth::user()->id == $user->id)
					<form enctype="multipart/form-data" action="/users/{{ $user->id }}" method="POST">
						{{ csrf_field() }}
						<label class="label-item">Update Profile Image</label>
						<label class="btn btn-sm btn-default btn-file label-item col-xs-12 ">
							Chose picture<input type="file" name="avatar" style="display:none;" class="btn btn-default btn-file">
						</label>
						<input type="submit" class="btn btn-sm btn-default label-item col-xs-12">
					</form>
					<a href="/users/{{ $user->id }}/edit" class="btn btn-sm btn-default label-item player-item col-xs-12">Edit profile</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection