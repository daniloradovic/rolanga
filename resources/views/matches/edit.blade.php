@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="game_item" id="match{{ $match->id }}">                                        
			<div class="participants">
				
					<a class="btn btn-large btn-primary btn-space col-md-4 col-md-offset-4 col-xs-12 " href="/tournaments/{{ $tournament->id }}/groups"><i class="glyphicon glyphicon-menu-left"></i> Back to {{ $tournament->tournament_name }}</a>

				
				<form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}" method="POST">
					{{csrf_field()}}
					{{ method_field('patch') }}
					<table class="table table-bordered table-hover results">
						<thead>
							<tr>
								<th class="center">#</th>
								@foreach($match->sets as $set)
								<th class="center">Set{{ $set->set_number }}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							{{-- First player set results to add/edit --}}
							<tr class="{{ (Auth::check() && Auth::user()->id == $match->first_player_id) ? 'info' : ''  }}">
								<td class="center">{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</td>
								@foreach($match->sets as $set)
								<td class="center">		
									<input type="number" class="form-control center"  id="set{{ $set->id }}player1" name="set{{ $set->id }}player1" max="7" min="0" value="{{ old('name', $set->first_player_games)}}">
								</td>
								@endforeach
							</tr>
							{{-- Second player set results to add/edit --}}
							<tr class="{{ (Auth::check() && Auth::user()->id == $match->second_player_id) ? 'info' : ''  }}">
								<td class="center">{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</td>
								@foreach($match->sets as $set)
								<td class="center"> 
									<input type="number" class="form-control center" id="set{{ $set->id }}player2" name="set{{ $set->id }}player2" max="7" min="0" value="{{ old('name', $set->second_player_games)}}">
								</td>
								@endforeach
							</tr>  
						</tbody>
					</table>
				</div>
				
					<button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-large btn-success col-md-4 col-md-offset-4 col-xs-12" id="match{{ $match->id }}">Save <i class="glyphicon glyphicon-floppy-save"></i></button>
				
			</div>
		</form>
	</div>
</div>

@endsection