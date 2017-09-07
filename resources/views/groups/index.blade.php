@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1 class="center">ROLANGA ROS Tournament</h1>
        </div>
        <div class="panel-body">
          <!-- List group -->
          <div class="list-group">
            <table class="table table-bordered">
              <h1>Group A</h1>
              <thead class="thead-inverse">
                <tr>
                  <th class="col-md-1">#</th>
                  <th class="col-md-1">Player</th>
                  <th class="col-md-1">P</th>
                  <th class="col-md-1">W</th>
                  <th class="col-md-1">D</th>
                  <th class="col-md-1">L</th>
                  <th class="col-md-1">+/-</th>
                  <th class="col-md-1">Points</th>
                </tr>
              </thead>
              <?php $i = 0 ?>
              @foreach($tournament->groups[0]->users as $user)
              <?php $i++ ?>
              
              <tbody>
                <tr>
                  <th scope="row">{{ $i }}</th>
                  <td>{{ $user->name }}</td>
                  <td>0</td>
                  <td>{{ $user->wins }}</td>
                  <td>{{ $user->draws }}</td>
                  <td>{{ $user->losses }}</td> 
                  <td>0</td>
                  <td>{{ $user->points }}</td>                           
                </tr>
              </tbody>
              @endforeach
            </table>
            <p class="center">
              <button class="btn btn-primary" id="showGamesA" type="button" data-toggle="collapse" data-target="#collapseGroupA" aria-expanded="false" aria-controls="collapseGroupA">Show Games
              </button>
            </p>
            <div class="latest_qualifiers_games_wrapper " >
              <div class="latest_qualifier_games wide">
                <div class="latest_qualifier_games_content local">
                  <div class="day_wrapper">
                    <div class="group collapse" id="collapseGroupA" >           
                      @foreach($tournament->groups[0]->rounds as $round)
                      <div class="round">
                        <div class="pannel-group" id="accordionA" role="tablist" aria-multiselectable="true">
                          <div class="pannel pannel-default center">
                            <div class="panel-heading" role="tab" id="headingA{{$round->round_number}}">
                              <h4 class="pannel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionA" href="#collapseA{{$round->round_number}}" aria-expanded="true" aria-controls="collapseA{{$round->round_number}}">Round {{$round->round_number}} </a>
                              </h2>
                            </div>
                          </div>
                          <div id="collapseA{{$round->round_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingA{{$round->round_number}}">
                            <div class="panel-body">
                              <div class="games_list">
                                @foreach($round->matches as $match)
                                <div class="game_item" id="match{{ $match->id }}">                                        
                                  <div class="participants">
                                  <form action="/tournaments/{{ $tournament->id }}/matches/{{ $match->id }}/edit" method="GET">
                                  {{-- <form action="/scores" method="POST"> --}}
                                    {{csrf_field()}}
                                    <table class="country left .col-md-1">
                                      <tbody>
                                        <tr>
                                          <td class="country_col">
                                            <div class="name">
                                              <span>{{$users->where('id','=',$match->first_player_id)->pluck('name')->first()}}</span>
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
                                             {{-- <div class="col-md-2">
                                               <div class="form-group row center">
                                                @for($i=1; $i<=2; $i++)
                                                  <input type="number"  id="set{{ $set->id }}player{{ $i }}" name="set{{ $set->id }}player{{ $i }}" max="7" min="0">
                                                @endfor
                                               </div>
                                             </div> --}}

                                            <p class="col-md-2">{{ $set->first_player_games }}</p>
                                            <p class="col-md-2">{{ $set->second_player_games }}</p>
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
                                            <span>{{$users->where('id','=',$match->second_player_id)->pluck('name')->first()}}</span>
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
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="list-group">
            <table class="table table-bordered">
              <h1>Group B</h1>
              <thead class="thead-inverse">
                <tr>
                  <th class="col-md-1">#</th>
                  <th class="col-md-1">Player</th>
                  <th class="col-md-1">P</th>
                  <th class="col-md-1">W</th>
                  <th class="col-md-1">L</th>
                  <th class="col-md-1">%</th>
                  <th class="col-md-1">+/-</th>
                  <th class="col-md-1">Points</th>
                </tr>
              </thead>
              
              <?php $i = 0 ?>
              @foreach($tournament->groups[1]->users as $user)
              <?php $i++ ?>
              <tbody>
                <tr>
                  <th scope="row">{{$i}}</th>
                  <td>{{$user->name}}</td>  
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td> 
                  <td>0</td>
                  <td>{{ $user->points }}</td>                           
                </tr>
              </tbody>
              @endforeach
            </table>
            <p class="center">
              <button class="btn btn-primary" id="showGamesB" type="button" data-toggle="collapse" data-target="#collapseGroupB" aria-expanded="false" aria-controls="collapseGroupB">Show Games
              </button>
            </p>
            <div class="latest_qualifiers_games_wrapper">
              <div class="latest_qualifier_games wide">
                <div class="latest_qualifier_games_content local">
                  <div class="day_wrapper">
                    <div class="group collapse" id="collapseGroupB">
                      @foreach($tournament->groups[1]->rounds as $round)
                      <div class="round">
                        <div class="pannel-group" id="accordionB" role="tablist" aria-multiselectable="true">
                          <div class="pannel pannel-default center">
                            <div class="panel-heading" role="tab" id="headingB{{$round->round_number}}">
                              <h4 class="pannel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionB" href="#collapseB{{$round->round_number}}" aria-expanded="true" aria-controls="collapseB{{$round->round_number}}">Round {{$round->round_number}} </a>
                              </h2>
                            </div>
                          </div>
                          <div id="collapseB{{$round->round_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingB{{$round->round_number}}">
                            <div class="panel-body">
                              <div class="games_list">
                                @foreach($round->matches as $match)
                                <div class="game_item" id="{{ $match->id }}">
                                  <div class="participants">
                                  <form action="/scores" method="POST">
                                    {{csrf_field()}}
                                    <table  class="country left .col-md-1">
                                      <tbody>
                                        <tr>
                                          <td class="country_col">
                                            <div class="name">
                                              <span>{{$users->where('id','=',$match->first_player_id)->get()->pluck('name')}}</span>
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
                                           <td>
                                             <div class="col-md-2">
                                               <div class="form-group row center">
                                                @for($i=1; $i<=2; $i++)
                                                  <input type="number"  id="set{{ $set->id }}player{{ $i }}" name="set{{ $set->id }}player{{ $i }}" max="7" min="0">
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
                                              <span>{{$users->where('id','=',$match->second_player_id)->get()->pluck('name')}}</span>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="additional_content">
                                    <button type="submit" name="matchId" value="{{ $match->id }}" class="btn btn-sm">Save</button>
                                  </div>
                                </div>
                                </form>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection
