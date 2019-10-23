@extends('layouts.admin')

@section('content')
    <div class="peers ai-s fxw-nw h-100vh">
        <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style="background-image:url(admin/assets/static/images/bg.jpg)">
            <div class="pos-a centerXY">
                <div class="bgc-white bdrs-50p pos-r" style="width:120px;height:120px"><img class="pos-a centerXY" src="admin/assets/static/images/logo.png" alt=""></div>
            </div>
        </div>
        <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width:320px">
            <h4 class="fw-300 c-grey-900 mB-40">{{ __('Login') }}</h4>
            
            <form method="POST" action="{{ route('login') }}">
               @csrf
               
                <div class="form-group">
                    <label class="text-normal text-dark" for="email">{{ __('E-Mail Address') }}</label> 
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-normal text-dark" for="password">Password</label> 
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="peers ai-c jc-sb fxw-nw">
                        <div class="peer">
                            <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer" {{ old('remember') ? 'checked' : '' }}> 
                                <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                    <span class="peer peer-greed">{{ __('Remember Me') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="peer">
                            <button class="btn btn-primary">{{ __('Login') }}</button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
            </form>
            
        </div>
    </div>
@endsection