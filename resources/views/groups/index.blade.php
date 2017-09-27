@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-1 col-xs-12 col-sm-12">
        @if(! Auth::check())
            <div class="alert alert-warning center" role="alert">
                <strong>Login in to be able to change your match results</strong>
            </div>
        @endif
        
        <div class="panel panel-default">
        
        <div class="panel-heading">
            <h1 class="center">{{ $tournament->tournament_name }} Tournament</h1>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>{{$errors->first()}}</strong>
                </div>
            @endif
            <!-- List group -->
            <div class="list-group">
                
                <table class="table table-responsive table-hover table-striped results list-group-item">
                    <h2 align="center">Group A</h2>
                    
                    <thead class="thead-inverse">
                        <tr>
                          <th class="col-md-1 col-xs-1 center">#</th>
                          <th class="col-md-1 col-xs-1 center">Player</th>
                          <th class="col-md-1 col-xs-1 center">P</th>
                          <th class="col-md-1 col-xs-1 center">W</th>
                          <th class="col-md-1 col-xs-1 center">D</th>
                          <th class="col-md-1 col-xs-1 center">L</th>
                          <th class="col-md-1 col-xs-1 center">+/-</th>
                          <th class="col-md-1 col-xs-1 center">Pts</th>
                        </tr>
                    </thead>
                    
                    <?php $i = 0 ?>
                    <tbody>
                        @foreach($tournament->groups[0]->users as $user)
                        <?php $i++ ?>

                        <tr class="{{ (Auth::check() && Auth::user()->id == $user->id) ? 'success' : ''  }} {{ $i==4 ? "table-border-bottom" : ""}} clickable-row" data-href='/users/{{ $user->id }}'>
                          <td class="center">{{ $i }}</td>
                          <td class="center">{{ $user->name }}</td>
                          <td class="center">{{ $user->pivot->matches_played }}</td>
                          <td class="center">{{ $user->pivot->wins }}</td>
                          <td class="center">{{ $user->pivot->draws }}</td>
                          <td class="center">{{ $user->pivot->losses }}</td> 
                          <td class="center">{{ $user->pivot->games_won }}:{{ $user->pivot->games_lost }}</td>
                          <td class="center">{{ $user->pivot->points }}</td>                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="center round">
                  <button class="btn btn-primary col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" id="showGamesA" type="button" data-toggle="collapse" data-target="#collapseGroupA" aria-expanded="false" aria-controls="collapseGroupA">Show Games
                  </button>
                </div>

                <div class="group collapse" id="collapseGroupA" >           
                    @foreach($tournament->groups[0]->rounds as $round)
                    <div class="round center">
                        <div id="accordionA" role="tablist" aria-multiselectable="true">
                            <div class="center round-heading well well-sm">
                                <div role="tab" id="headingA{{$round->round_number}}">
                                    <h3>
                                        <a role="button" data-toggle="collapse" data-parent="#accordionA" href="#collapseA{{$round->round_number}}" aria-expanded="true" aria-controls="collapseA{{$round->round_number}}">Round {{$round->round_number}} @if($round->matches_played == count($round->matches))COMPLETED <i class="glyphicon glyphicon-ok"></i>@endif
                                        </a>
                                    </h3>
                                    <h5>Round starts on {{ \Carbon\Carbon::parse($round->start_date)->toFormattedDateString()  }} </h5>
                                    <p>Matches played : {{ $round->matches_played }}/{{ count($round->matches) }}</p>
                                </div>
                            </div>
                            <div id="collapseA{{$round->round_number}}" class="panel-collapse collapse {{ (Carbon\Carbon::now()->toFormattedDateString() > \Carbon\Carbon::parse($round->start_date)->toFormattedDateString() && Carbon\Carbon::now()->toFormattedDateString() <= Carbon\Carbon::parse($round->start_date)->addDays(7)->toFormattedDateString() )  ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingB{{$round->round_number}}">
                                <div class="games_list">
                                    @foreach($round->matches as $match)
                                    <div class="game_item" id="match{{ $match->id }}">                       
                                        <div class="participants">
                                            <form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}/edit" method="GET">
                                            {{csrf_field()}}
                                                <table class="table table-responsive table-hover">
                                                    <thead>
                                                        <tr class="tr-border-bottom">
                                                          <th class="center col-md-2 col-xs-2">#</th>
                                                          @foreach($match->sets as $set)
                                                          <th class="center col-md-2 col-xs-2">Set{{ $set->set_number }}</th>
                                                          @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="tr-border-bottom">
                                                        <th class="col-md-2 col-xs-2 center">{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</th>
                                                        @foreach($match->sets as $set)
                                                        <td class="center col-md-2 col-xs-2">
                                                            {{ $set->first_player_games }}
                                                        </td>
                                                        @endforeach
                                                        </tr>
                                                        
                                                        <tr class="tr-border-bottom">
                                                            <th class="col-md-2 col-xs-2 center">{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</th>
                                                            @foreach($match->sets as $set)
                                                            <td class="center col-md-2 col-xs-2">
                                                            {{ $set->second_player_games }}
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <small>
                                                Last modified by {{ App\User::where('id','=', $match->last_modified_by)->pluck('name')->first() }}
                                                </small>
                                        
                                                @if (Auth::check())
                                                    @if ((Auth::user()->id == $match->first_player_id) || (Auth::user()->id == $match->second_player_id) || Auth::user()->roles()->where('name','=','admin')->exists())
                                                    <div class="additional_content">
                                                        <button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-large btn-info" id="match{{ $match->id }}">Edit result <i class="glyphicon glyphicon-edit"></i></button>
                                                    </div>
                                                    @endif
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if ($round->player_off != 0)
                                    <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-8 col-sm-offset-2 alert alert-info">
                                        <p>{{ $round->group->users->where('id','=', $round->player_off)->pluck('name')->first() }} is free in this round</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="list-group">
                <table class="table table-responsive table-hover table-striped results list-group-item">
                    <h2 align="center">Group B</h2>
                    <thead class="thead-inverse">
                        <tr>
                          <th class="col-md-1 col-xs-1 center">#</th>
                          <th class="col-md-1 col-xs-1 center">Player</th>
                          <th class="col-md-1 col-xs-1 center">P</th>
                          <th class="col-md-1 col-xs-1 center">W</th>
                          <th class="col-md-1 col-xs-1 center">D</th>
                          <th class="col-md-1 col-xs-1 center">L</th>
                          <th class="col-md-1 col-xs-1 center">+/-</th>
                          <th class="col-md-1 col-xs-1 center">Pts</th>
                        </tr>
                    </thead>
                    <?php $i = 0 ?>
                    <tbody>
                    @foreach($tournament->groups[1]->users as $user)
                    <?php $i++ ?>
                        <tr class="{{ (Auth::check() && Auth::user()->id == $user->id) ? 'success ' : ''  }} {{ $i==4 ? "table-border-bottom" : ""}} clickable-row" data-href='/users/{{ $user->id }}'>
                          <td class="center">{{ $i }}</td>
                          <td class="center">{{ $user->name }}</td>
                          <td class="center">{{ $user->pivot->matches_played }}</td>
                          <td class="center">{{ $user->pivot->wins }}</td>
                          <td class="center">{{ $user->pivot->draws }}</td>
                          <td class="center">{{ $user->pivot->losses }}</td> 
                          <td class="center">{{ $user->pivot->games_won }}:{{ $user->pivot->games_lost }}</td>
                          <td class="center">{{ $user->pivot->points }}</td>                         
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="center round">
                  <button class="btn btn-primary col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" id="showGamesB" type="button" data-toggle="collapse" data-target="#collapseGroupB" aria-expanded="false" aria-controls="collapseGroupB">Show Games
                  </button>
                </div>
                <div class="group collapse" id="collapseGroupB">
                    @foreach($tournament->groups[1]->rounds as $round)
                    <div class="round center">
                        <div id="accordionB" role="tablist" aria-multiselectable="true">
                            <div class="center round-heading well well-sm">
                                <div role="tab" id="headingB{{$round->round_number}}">
                                    <h3>
                                        <a role="button" data-toggle="collapse" data-parent="#accordionB" href="#collapseB{{$round->round_number}}" aria-expanded="true" aria-controls="collapseB{{$round->round_number}}">
                                        Round {{$round->round_number}} @if ($round->matches_played == count($round->matches)) COMPLETED <i class="glyphicon glyphicon-ok"></i>@endif
                                        </a>
                                    </h3>
                                    <h5>
                                    Round starts on {{ \Carbon\Carbon::parse($round->start_date)->toFormattedDateString() }} 
                                    </h5>
                                    <p>
                                        Matches played : {{ $round->matches_played }}/{{ count($round->matches) }}
                                    </p>
                                </div>
                            </div>
                            <div id="collapseB{{$round->round_number}}" class="panel-collapse collapse  {{ (Carbon\Carbon::now()->toFormattedDateString() > \Carbon\Carbon::parse($round->start_date)->toFormattedDateString() && Carbon\Carbon::now()->toFormattedDateString() <= Carbon\Carbon::parse($round->start_date)->addDays(7)->toFormattedDateString() )  ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingB{{$round->round_number}}">
                                <div class="games_list">
                                    @foreach($round->matches as $match)
                                    <div class="game_item" id="match{{ $match->id }}">                                        
                                        <div class="participants">
                                            <form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}/edit" method="GET">
                                                {{csrf_field()}}
                                                <table class="table table-responsive table-hover points">
                                                    <thead>
                                                        <tr class="tr-border-bottom">
                                                            <th class="center col-md-2 col-xs-2">#</th>
                                                            @foreach($match->sets as $set)
                                                            <th class="center col-md-2 col-xs-2">Set{{ $set->set_number }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="tr-border-bottom">
                                                            <td class="col-md-2 col-xs-2 center">{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}
                                                            </td>
                                                            @foreach($match->sets as $set)
                                                            <td class="center col-md-2 col-xs-2">
                                                            {{ $set->first_player_games }}
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr class="tr-border-bottom">
                                                            <td class="col-md-2 col-xs-2 center">{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}
                                                            </td>
                                                            @foreach($match->sets as $set)
                                                            <td class="center col-md-2 col-xs-2">
                                                            {{ $set->second_player_games }}
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                @if (Auth::check())
                                                    @if ((Auth::user()->id == $match->first_player_id) || (Auth::user()->id == $match->second_player_id) || Auth::user()->roles()->where('name','=','admin')->exists())
                                                    <div class="additional_content">
                                                        <button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-large btn-info" id="match{{ $match->id }}">Edit result <i class="glyphicon glyphicon-edit"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if ($round->player_off != 0)
                                    <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-8 col-sm-offset-2 alert alert-info">
                                        <p> {{ $round->group->users->where('id','=',$round->player_off)->pluck('name')->first() }} is free in this round</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>        
            </div>
            @if (Auth::check())
            @if(Auth::user()->roles()->where('name','=','admin')->exists())
            <div>
                <form method="POST" action="/tournaments/{{ $tournament->id }}/groups" >
                  {{ csrf_field() }} 
                  {{ method_field('delete') }}

                    <button type="button" class="btn btn-danger col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" data-toggle="modal" data-target="#deleteTournament{!! $tournament->id !!}">Delete Tournament
                    </button>
                    <div class="modal fade" id="deleteTournament{!! $tournament->id !!}" tabindex="-1" role="dialog" aria-labelledby="deleteTournamentLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <h4>Are you shure that you want to delete this tournament?</h4>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-danger" >Yes</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection

@section('user-scripts')
<script>

  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
      window.location = $(this).data("href");
  });
});
</script>



@endsection
