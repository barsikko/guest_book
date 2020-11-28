@extends('layout')

@section('content')
	<div class="container">	


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

		@foreach($posts as $post)
			

			@if (isset($edit) && $post->id == $edit->id)
					<div class="col-lg-6">
						<form action="{{ route('posts.update', $edit->id) }}" method="POST">
							@csrf
							@method('PUT')
								<input type="hidden" name="page" value="{{ $posts->currentPage() }}">
								 <textarea  name="content" class="form-control" rows="2">{{ $post->content }}</textarea>
							<button type="submit" class="btn btn-primary">Редактировать</button>
						</form> 
					</div>
			@else
					<h3>{{	$post->content  }}</h3>
						@can('update', $post)
					<a href="{{ route('posts.edit', ['post' => $post->id, 'page' => $posts->currentPage()]) }}">
						<button type="submit" class="btn btn-primary">Редактировать</button>
					</a>
						@endcan
				@endif		
				<br>
			</form>
				@if  ($post->answers)
 					<div class="container">
						<span class="badge badge-pill badge-warning">Ответ</span> {{ $post->answers->content }} 
						</form>

							
						</div>
						@endif
				@if	($post->answers()->count() < 1)
					<div class="container">
		<form method="POST" action="{{ route('answers.store', ['post' => $post->id, 'page' => $posts->currentPage()]) }}">
				@csrf

				  <div class="form-group">
					    <textarea class="form-control" name="content" rows="3"> </textarea>
		  		  </div>
		  		<button type="submit" class="btn btn-primary btn-block">Ответить</button>
						</form>
					</div>
				@endif

					<br />
		@endforeach

		{{ $posts->links() }}

	</div>

@auth
	<form method="POST" id="form" action="{{ route('posts.store') }}" enctype="multipart/form-data">
		@csrf

					<div class="form-group">
								{{-- <label>Добавьте файл</label> --}}
								<input type="file" id="thumbnail" name="thumbnail" class="form-control-file"> 
					</div>

		  <div class="form-group">
			    {{-- <label for="content">Пишите текст</label> --}}
			    <textarea class="form-control" id="content" name="content" rows="3"> </textarea>
  		  </div>
  		  <button id="sender" type="submit" class="btn btn-primary btn-block">Написать</button>
	</form>
@endauth

        
@endsection