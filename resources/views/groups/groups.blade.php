@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-offset-1 ">
      <div class="panel panel-default">
        <div class="panel-heading">Create Groups</div>
        
        <div class="panel-body">
          <!-- List group -->
          <div class="list-group">
            <div class="tournament" id="{{ $tournament->id }}">
              <h2>{{ $tournament->tournament_name }} </h2>
              @for ($i=0; $i<$tournament->groups_number; $i++)
                <ul class=" col-md-3 col-md-offset-1 group{{ $i }} groups sortable" id="{{ $tournament->groups[$i]->id }}" name="Group{{ $i }}"> 
                  <h3 class="form-control">Group{{$i}}</h3>  
                </ul>
              @endfor
              
              <ul class=" col-md-3 col-md-offset-1 players sortable">
                @foreach ($tournament->users as $user)
                  <li class="list-group-item" id="{{ $user->id }}">{{ $user->name }}</li>
                @endforeach
              </ul>
              
              <ul class="col-md-9 col-md-offset-1">
                <button type="submit" class="list-group-item btn btn-default" id="submit-groups" name="submit-groups">Create</button>
              </ul>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('user-scripts')
  <script>

      var group1_player_ids = [];
      var group2_player_ids = [];


      $(document).ready(function(){
          $.ajaxSetup({
              headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
          });

          $('.players').sortable({
              connectWith: '.group0, .group1'

          });
          $('.group0').sortable({
              connectWith:'.group1, .players'
          });
          $('.group1').sortable({
              connectWith:'.group0, .players'
          });



          

          $('#submit-groups').on("click",function(){

              group1_player_ids = [];
              group2_player_ids = [];
              var tournament_id = $('.tournament').attr('id');
              var group_ids = [];

              $('.groups').each(function(){
                  group_ids.push(this.id);
              });

              $('.group0 li').each(function(){
                  group1_player_ids.push(this.id);
              });

              $('.group1 li').each(function(){
                  group2_player_ids.push(this.id);
              });

              $.ajax({
                  type: 'POST',
                  url: '/generate',
                  data: {
                      'group1_player_ids': group1_player_ids,
                      'group2_player_ids': group2_player_ids,
                      'tournament_id': tournament_id,
                      'group_ids': group_ids
                  },
                  
                  success: function(){ // What to do if we succeed
                      console.log("Data sent"); 
                  },
              });
          });
      });
  </script>
@endsection  