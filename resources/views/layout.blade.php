<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
	<body>
			<nav class="navbar navbar-dark bg-dark mb-5">
			  <a class="navbar-brand" href="{{ route('home') }}">
			   	{{ config('app.name', 'GuestBook') }}
		 	 </a>
		@guest
				<ul class="nav justify-content-end">
				  <li class="nav-item">
			       <a class="p-1 text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
				  </li> 
				     	@if (Route::has('register'))
				    <li class="nav-item">
				    <a class="p-1 text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
				    </li>
				         @endif 	
		    	</ul>
		    @else
	    	   <a class="p-2 text-light" href="{{ route('logout') }}"
	                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout')  }} ( {{  Auth::user()->email }} )	
                   </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                    </form>
	    @endguest
	    	</nav>
	@yield('content')
	</body>
	<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</html>