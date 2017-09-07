@extends('layouts.app')

@section('content')

<div class="container">
	<div class="game_item" id="match{{ $match->id }}">                                        
		<div class="participants">
			<form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}" method="POST">
				
				{{csrf_field()}}
				{{ method_field('patch') }}
				
				<table class="country left .col-md-1">
					<tbody>
						<tr>
							<td class="country_col">
								<div class="name">
									<span>{{$users->where('id','=',$match->first_player_id)->pluck('name')}}</span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-borderless points">
					<tbody>
						<tr>
							@foreach($match->sets as $set)
							<th class="center">Set{{ $set->set_number }}</th>
							@endforeach
						</tr>
						<tr>
						@foreach($match->sets as $set)
						<td class="form-group row center">
							<div class="col-md-2">
								<div class="form-group row center">
									@for($i=1; $i<=2; $i++)
										@if ($i == 1)
										<input type="number"  id="set{{ $set->id }}player{{ $i }}" name="set{{ $set->id }}player{{ $i }}" max="7" min="0" value="{{ old('name', $set->first_player_games)}}">
										@else
										<input type="number"  id="set{{ $set->id }}player{{ $i }}" name="set{{ $set->id }}player{{ $i }}" max="7" min="0" value="{{ old('name', $set->second_player_games)}}">
										@endif
									@endfor
								</div>
							</div>
	                   </td>
	                   @endforeach
	               </tr>                                       
	           </tbody>
	       </table>
	       <table class="country right .col-md-1">
	       	<tbody>
	       		<tr>
	       			<td class="country_col">
	       				<div class="name">
	       					<span>{{$users->where('id','=',$match->second_player_id)->pluck('name')}}</span>
	       				</div>
	       			</td>
	       		</tr>
	       	</tbody>
	       </table>
	   </div>
	   <div class="additional_content">
	   	<button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-sm" id="match{{ $match->id }}">Edit result</button>
	   </div>
	</div>
	</form>
</div>

@endsection