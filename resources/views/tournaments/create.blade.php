@extends('layouts.app')


@section('content')

<div class="container">
	<div class="row">
		<div class="col-sm-8 col-md-offset-2 blog-main">
			
			<form method="POST" action="/tournaments">
				{{ csrf_field() }}
				
				<div class="form-group">
					<label for="tournament_name">Tournament name:</label>
					<input type="text" class="form-control" id="tournament_name" name="tournament_name" >
				</div>
				
				<div class="form-group">
					<label for="groups_number">Groups number:</label>
					<input type="number" class="form-control" id="groups_number" name="groups_number" >
				</div>

				<div class="form-group">
					{!!Form::label('user_list', 'Players:') !!}
					{!!Form::select('user_list[]', $users->pluck('name','id'), null, ['id' => 'user_list', 'name' =>'user_list[]', 'class' => 'form-control', 'multiple']) !!}
				</div>



				<div class="form-group">
					<label for="start_date" class="col-form-label">Start Date</label>
					<input name="start_date" class=" form-control mb-2 mr-sm-2 mb-sm-0" type="date"  value="{{ empty($queryParams['start_date']) ? '' : $queryParams['start_date'] }}"   id="from_date">
				</div>
					



				<div class="form-group">
					<button type="submit" class="btn btn-primary">Create</button>
				</div>

			</form>
			@include('partials.errors')

		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
	$('#user_list').select2();
</script>
@endsection