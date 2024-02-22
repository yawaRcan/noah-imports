@extends('admin.layout.guest')

@section('content')
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box p-4 bg-white rounded">
            <div>
                <div class="logo text-center">
                    <span class="db"><img src="../assets/images/logo-icon.png" alt="logo" /></span>
                    <h5 class="font-weight-medium mb-3 mt-1">Sign Up to Admin</h5>
                </div>
                <!-- Form -->
                <div class="row mt-4">
                    <div class="col-12">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.register') }}">
                            @csrf
                            <label for="tb-rfname">First Name</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user"></span>
                                </div>
                                <input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />

                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                            </div>
                            <label for="tb-rfname">Last Name</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user"></span>
                                </div>
                                <input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />

                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>
                            <label for="tb-remail">Username</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-envelope"></span>
                                </div>
                                <input class="form-control" id="username" type="text" name="username" :value="old('email')" required autocomplete="username" />
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>
                            </div>
                            <label for="tb-remail">Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-envelope"></span>
                                </div>
                                <input class="form-control" id="email" type="email" name="email" :value="old('email')" required autocomplete="email" />
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            <label for="tb-remail">Phone</label>
                            <div class="valid-msg-wrap">
                                 <span id="valid-msg" class="hide">✓ Valid</span>
                                 <span id="error-msg" class="hide">Invalid number</span>
                             </div>
                            <div class="form-group mb-3">
                                <input class="form-control form-control-prepended" id="contact_no" type="tel" name="phone" />
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                            <input type="hidden" name="initial_country" id="initial_country">
                            <input type="hidden" name="country_code" id="country_code">
                            <input type="hidden" name="phone" id="phone_complete">
                            <label for="tb-remail">Country</label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text fa fa-flag"></span>
                              </div>
                              <select class="form-control" name="country_id">
                                  <option value="">Select Country</option>
                                  @foreach($countries as $key => $name)
                                     <option value="{{$key}}">{{$name}}</option>
                                  @endforeach
                              </select>
                              <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                              </div>
                            </div>
                            <label for="branch">Branch</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-building"></span>
                                </div>
                                <select class="form-control" name="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $key => $name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                                </div>
                            </div>
                            <label for="text-rpassword">Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user"></span>
                                </div>
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>
                            <label for="text-rcpassword">Confirm Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fa fa-user"></span>
                                </div>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                <div class="invalid-feedback">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                            <div class="checkbox checkbox-primary mb-3">
                                <input id="checkbox-signup" type="checkbox" class="chk-col-indigo material-inputs">
                                <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                            </div>
                            <div class="d-flex align-items-stretch">
                                <button type="submit" class="btn btn-info d-block w-100">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
    @endsection