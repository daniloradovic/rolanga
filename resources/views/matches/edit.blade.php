@extends('layouts.app')

@section('content')

<div class="container">
{{-- <div class="panel-body">
<div class="games_list"> --}}
	<div class="game_item" id="match{{ $match->id }}">                                        
		<div class="participants">
			<form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}" method="POST">
				
				{{csrf_field()}}
				{{ method_field('patch') }}
				
				<table class="table table-borderless points">
					<thead>
						<tr>
							<th>#</th>
							@foreach($match->sets as $set)
							<th class="center">Set{{ $set->set_number }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						
						<tr>
							<th>{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</span></th>
							@foreach($match->sets as $set)
							<td class="form-group row center">		
								<input type="number"  id="set{{ $set->id }}player1" name="set{{ $set->id }}player1" max="7" min="0" value="{{ old('name', $set->first_player_games)}}">
		                   	</td>
		                   	@endforeach
	              	 	</tr>
	              	 	
						<tr>
						<th>{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</span></th>
						@foreach($match->sets as $set)
						<td class="form-group row center">
							<input type="number"  id="set{{ $set->id }}player2" name="set{{ $set->id }}player2" max="7" min="0" value="{{ old('name', $set->first_player_games)}}">
	                   	</td>
	                   	@endforeach
	              	 	</tr>  
	           		</tbody>
	       		</table>
	   </div>
	   <div class="col-md-4 col-md-offset-5">
	   	<button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-large btn-success col-md-4" id="match{{ $match->id }}">Save</button>
	   </div>
	</div>
	</form>
</div>
{{-- </div>	
</div> --}}

@endsection