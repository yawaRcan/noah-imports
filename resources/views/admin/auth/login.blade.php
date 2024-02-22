@extends('admin.layout.guest')

@section('content')
    <!-- Session Status -->
    <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../assets/images/background/login-register.jpg) no-repeat center center; background-size: cover;">
            <div class="auth-box p-4 bg-white rounded">
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3">Sign In</h3>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        @error('status')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" id="loginform"  method="POST" action="{{ route('admin.login.store') }}">
                            @csrf   
                            <div class="form-group mb-3">
                                    <div class="">
                                        <input class="form-control" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" /> 
                                        <!-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> -->
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="">
                                        <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                     </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex">
                                        <div class="checkbox checkbox-info pt-0">
                                            <input id="checkbox-signup" type="checkbox" class="material-inputs chk-col-indigo" name="remember">
                                            <label for="checkbox-signup">{{ __('Remember me') }}</label>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="javascript:void(0)" id="to-recover" class="link font-weight-medium"><i class="fa fa-lock me-1"></i> Forgot pwd?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center mt-4 mb-3">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">{{ __('Log in') }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center">
                                        <div class="social mb-3">
                                            <a href="javascript:void(0)" class="btn  btn-facebook" data-bs-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fab fa-facebook-f"></i> </a>
                                            <a href="javascript:void(0)" class="btn btn-googleplus" data-bs-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fab fa-google"></i> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 mt-4">
                                    <div class="col-sm-12 justify-content-center d-flex">
                                        <p>Don't have an account? <a href="{{route('admin.register')}}" class="text-info font-weight-medium ms-1">Sign Up</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <h3 class="font-weight-medium mb-3">Recover Password</h3>
                        <span class="text-muted">Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row mt-3 form-material">
                        <!-- Form -->
                        <form class="col-12" method="POST" action="{{ route('admin.password.email') }}">
                        @csrf
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn d-block w-100 btn-primary text-uppercase" type="submit" name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
        @endsection

