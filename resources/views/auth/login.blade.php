<x-guest-layout>
  <div class="container-fluid" style="height: 100vh;">
    <div class="row d-flex justify-content-center align-items-stretch h-100">
      
	  <div class="d-none d-lg-flex col-lg-6 justify-content-center">
	    <div class="row align-items-center h-100">
          <div class="col-12">
		  
		  <span id="logo-login">
		    <x-application-logo class="w-20 h-20 m-auto fill-current text-gray-500" />
          </span>
		  
		  <!-- Session Status -->
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <!-- Validation Errors -->
          <x-auth-validation-errors class="mb-4" :errors="$errors" />
          
		  <div class="text-center">
		      <form method="POST" action="{{ route('login') }}">
			    @csrf
 <!-- Email Address -->
            <div class="mt-4">
                <x-input id="email" class="block mt-1 w-full" :placeholder="__('Email')" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input id="password" :placeholder="__('Senha')" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>				
			
				
				<!-- Remember Me -->
            <div class="block my-3">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end">
                

                <x-button class="w-100">
                    {{ __('Log in') }}
                </x-button>
				
				</div>

@if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
				</form>
		    </div>
	      </div>
		</div>
	  </div>
	  
	  <div class="col-12 col-lg-6 justify-content-center align-items-stretch">
	    <div class="row align-items-center h-100" id="login-presentation">
          <div class="col-12">	
            <h1 class="text-center">
		      Bem-Vindo!
		    </h1>
	      </div>
		</div>
	  </div>
	  
	</div>
  </div>
</x-guest-layout>
