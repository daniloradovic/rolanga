@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
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
              <table class="table table-bordered table-hover results">
                <h1>Group A</h1>
                <thead class="thead-inverse">
                  <tr>
                    <th class="col-md-1 col-xs-1">#</th>
                    <th class="col-md-1 col-xs-1">Player</th>
                    <th class="col-md-1 col-xs-1">P</th>
                    <th class="col-md-1 col-xs-1">W</th>
                    <th class="col-md-1 col-xs-1">D</th>
                    <th class="col-md-1 col-xs-1">L</th>
                    <th class="col-md-1 col-xs-1">+/-</th>
                    <th class="col-md-1 col-xs-1">Points</th>
                  </tr>
                </thead>
                <?php $i = 0 ?>

                @foreach($tournament->groups[0]->users as $user)
                <?php $i++ ?>
                
                <tbody>
                  <tr class="{{ (Auth::check() && Auth::user()->id == $user->id) ? 'active' : ''  }}">
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->pivot->matches_played }}</td>
                    <td>{{ $user->pivot->wins }}</td>
                    <td>{{ $user->pivot->draws }}</td>
                    <td>{{ $user->pivot->losses }}</td> 
                    <td>{{ $user->pivot->games_won }} : {{ $user->pivot->games_lost }}</td>
                    <td>{{ $user->pivot->points }}</td>                           
                  </tr>
                </tbody>
                @endforeach
              </table>
              <p class="center">
                <button class="btn btn-primary" id="showGamesA" type="button" data-toggle="collapse" data-target="#collapseGroupA" aria-expanded="false" aria-controls="collapseGroupA">Show Games
                </button>
              </p>
            <div class="group collapse" id="collapseGroupA" >           
              @foreach($tournament->groups[0]->rounds as $round)
              <div class="round">
                <div class="pannel-group" id="accordionA" role="tablist" aria-multiselectable="true">
                  <div class="pannel pannel-default center">
                    <div class="panel-heading" role="tab" id="headingA{{$round->round_number}}">
                      <h4 class="pannel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordionA" href="#collapseA{{$round->round_number}}" aria-expanded="true" aria-controls="collapseA{{$round->round_number}}">Round {{$round->round_number}} </a>
                      </h4>
                      <h5>Round starts on {{ \Carbon\Carbon::parse($round->start_date)->toFormattedDateString()  }} </h5>
                    </div>
                  </div>
                  <div id="collapseA{{$round->round_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingA{{$round->round_number}}">
                    <div class="panel-body">
                      <div class="games_list">
                        @foreach($round->matches as $match)
                        <div class="game_item" id="match{{ $match->id }}">                                        
                          <div class="participants">
                            <form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}/edit" method="GET">
                              {{csrf_field()}}
                              <table class="table table-bordered points">
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
                                    <th>{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</th>
                                    @foreach($match->sets as $set)
                                    <td class="center">
                                      {{ $set->first_player_games }}
                                    </td>
                                    @endforeach
                                  </tr>
                                  <tr>
                                    <th>{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</th>
                                    @foreach($match->sets as $set)
                                    <td class="center">
                                      {{ $set->second_player_games }}
                                    </td>
                                    @endforeach
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            @if (Auth::check())
                              @if ((Auth::user()->id == $match->first_player_id) || (Auth::user()->id == $match->second_player_id) || Auth::user()->roles()->where('name','=','admin')->exists())
                              <div class="additional_content wrath-content-box">
                                <button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-large btn-warning" id="match{{ $match->id }}">Edit result</button>
                              </div>
                              @endif
                            @endif
                          </div>
                        </form>
                        @endforeach
                      </div>
                      @if ($round->player_off != 0)
                      <div class="col-md-4 col-md-offset-4 alert alert-info">
                        <p>{{ $round->group->users->where('id','=',$round->player_off)->pluck('name')->first() }} is free in this round</p>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <p>Matches played {{ $round->matches_played }}/{{ count($round->matches) }}</p>
                @if ($round->matches_played == count($round->matches))
                <div class="alert alert-success">
                  <p>ROUND COMPLETED!</p>
                </div>
                @endif
              </div>
              @endforeach
            </div>
            <div class="list-group">
              <table class="table table-bordered table-hover results">
                <h1>Group B</h1>
                <thead class="thead-inverse">
                  <tr>
                    <th class="col-md-1 col-xs-1">#</th>
                    <th class="col-md-1 col-xs-1">Player</th>
                    <th class="col-md-1 col-xs-1">P</th>
                    <th class="col-md-1 col-xs-1">W</th>
                    <th class="col-md-1 col-xs-1">D</th>
                    <th class="col-md-1 col-xs-1">L</th>
                    <th class="col-md-1 col-xs-1">+/-</th>
                    <th class="col-md-1 col-xs-1">Points</th>
                  </tr>
                </thead>

                <?php $i = 0 ?>
                @foreach($tournament->groups[1]->users as $user)
                <?php $i++ ?>
                <tbody>
                  <tr class="{{ (Auth::check() && Auth::user()->id == $user->id) ? 'active' : ''  }}">
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->pivot->matches_played }}</td>
                    <td>{{ $user->pivot->wins }}</td>
                    <td>{{ $user->pivot->draws }}</td>
                    <td>{{ $user->pivot->losses }}</td> 
                    <td>{{ $user->pivot->games_won }} : {{ $user->pivot->games_lost }}</td>
                    <td>{{ $user->pivot->points }}</td>                         
                  </tr>
                </tbody>
                @endforeach
              </table>
              <p class="center">
                <button class="btn btn-primary" id="showGamesB" type="button" data-toggle="collapse" data-target="#collapseGroupB" aria-expanded="false" aria-controls="collapseGroupB">Show Games
                </button>
              </p>
              <div class="group collapse" id="collapseGroupB">
                @foreach($tournament->groups[1]->rounds as $round)
                <div class="round">
                  <div class="pannel-group" id="accordionB" role="tablist" aria-multiselectable="true">
                    <div class="pannel pannel-default center">
                      <div class="panel-heading" role="tab" id="headingB{{$round->round_number}}">
                        <h4 class="pannel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordionB" href="#collapseB{{$round->round_number}}" aria-expanded="true" aria-controls="collapseB{{$round->round_number}}">Round {{$round->round_number}} </a>
                        </h4>
                        <h5>Round starts on {{ \Carbon\Carbon::parse($round->start_date)->toFormattedDateString() }} </h5>
                      </div>
                    </div>
                    <div id="collapseB{{$round->round_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingB{{$round->round_number}}">
                      <div class="panel-body">
                        <div class="games_list">
                          @foreach($round->matches as $match)
                          <div class="game_item" id="match{{ $match->id }}">                                        
                            <div class="participants">
                              <form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}/edit" method="GET">
                                {{csrf_field()}}
                                <table class="table table-bordered points">
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
                                      <th>{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</th>
                                      @foreach($match->sets as $set)
                                      <td class="form-group row center">
                                        <p class="col-md-2">{{ $set->first_player_games }}</p>
                                      </td>
                                      @endforeach
                                    </tr>
                                    <tr>
                                      <th>{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</th>
                                      @foreach($match->sets as $set)
                                      <td class="form-group row center">
                                        <p class="col-md-2">{{ $set->second_player_games }}</p>
                                      </td>
                                      @endforeach
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              @if (Auth::check())
                              @if ((Auth::user()->id == $match->first_player_id) || (Auth::user()->id == $match->second_player_id) || Auth::user()->roles()->where('name','=','admin')->exists())
                              <div class="additional_content">
                                <button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-sm" id="match{{ $match->id }}">Edit result</button>
                              </div>
                              @endif
                              @endif
                            </div>
                          </form>
                          @endforeach
                        </div >
                        @if ($round->player_off != 0)
                        <div class="col-md-4 col-md-offset-4 alert alert-info">
                          <p>{{ $round->group->users->where('id','=',$round->player_off)->pluck('name')->first() }} is free in this round</p>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <p>Matches played {{ $round->matches_played }}/{{ count($round->matches) }}</p>
                  @if ($round->matches_played == count($round->matches))
                  <div class="alert alert-success">
                    <p>ROUND COMPLETED!</p>
                  </div>
                  @endif
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

                  <button type="button" class="btn btn-primary btn-large btn-danger  col-md-6 col-md-offset-3" data-toggle="modal" data-target="#deleteTournament{!! $tournament->id !!}">Delete Tournament</button>
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
  </div>
</div>

@endsection
