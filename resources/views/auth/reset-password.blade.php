<x-guest-layout>
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box p-4 bg-white rounded">
            <div>
                <div class="logo text-center">
                    <span class="db"><img src="assets/images/logo-icon.png" alt="logo" /></span>
                    <h5 class="font-weight-medium mb-3 mt-1">Recover Password</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <!-- Email Address -->
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="password" type="password" name="password" required autocomplete="new-password" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="col-xs-12">
                                    <button class="btn d-block w-100 btn-info" type="submit">Reset</button>
                                </div>
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
</x-guest-layout>