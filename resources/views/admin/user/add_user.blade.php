    <form class="form-horizontal" id="user-add-form" action="javascript:void(0)">
            @csrf
            <label for="tb-rfname">First Name</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-user"></span>
                </div>
                <input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" autofocus autocomplete="first_name" />
            </div>
            <label for="tb-rfname">Last Name</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-user"></span>
                </div>
                <input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" autofocus autocomplete="last_name" />
            </div>
            <label for="tb-remail">Username</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-envelope"></span>
                </div>
                <input class="form-control" id="username" type="text" name="username" :value="old('username')" autocomplete="username" />
            </div>
            <label for="tb-remail">Email</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-envelope"></span>
                </div>
                <input class="form-control" id="email" type="email" name="email" :value="old('email')" autocomplete="email" />
            </div>
            <label for="tb-remail">Phone</label>
            <div class="valid-msg-wrap">
                <span id="valid-msg" class="hide">✓ Valid</span>
                <span id="error-msg" class="hide">Invalid number</span>
            </div>
            <div class="form-group mb-3">
                <input class="form-control form-control-prepended" id="contact_no" type="tel" name="contact_no" />
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
            </div>
            <label for="text-rpassword">Password</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-user"></span>
                </div>
                <input id="password" class="form-control" type="password" name="password" autocomplete="new-password" />
            </div>
            <label for="text-rcpassword">Confirm Password</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-user"></span>
                </div>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" />
            </div>
            <label for="year">Date of birth</label>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <select class="form-control" id="year" name="year">
                        <!-- Populate with years -->
                        <option value="">Year</option>
                        @php
                        $currentYear = date("Y");
                        for ($i = $currentYear; $i >= $currentYear - 100; $i--) {
                        @endphp
                        <option value="{{$i}}">{{$i}}</option>
                        @php } @endphp
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="month" name="month">
                        <!-- Populate with months -->
                        @php
                        $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December'
                        ];
                        @endphp

                        <option value="">Month</option>
                        @foreach($months as $monthNum => $monthName)
                        <option value="{{$monthNum}}">{{$monthName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="day" name="day">
                        <!-- Populate with days -->
                        <option value="">Day</option>
                        @php
                        for ($day = 1; $day <= 31; $day++) { @endphp <option value="{{$day}}">{{$day}}</option>
                            @php } @endphp
                    </select>
                </div>
            </div>
            <div class="checkbox checkbox-primary mb-3 mt-3">
                <input id="checkbox-signup" type="checkbox" class="chk-col-indigo material-inputs">
                <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
            </div>
            <div class="d-flex align-items-stretch">
                <button class="btn btn-info d-block w-100" id="user-add-button">Sign up</button>
            </div>
            <label for="tb-remail" class="mt-3">Referral</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text fa fa-user"></span>
                </div>
                <input class="form-control" id="refferal" type="text" value="Noah Imports" name="refferal" :value="old('refferal')" autocomplete="refferal" disabled />
            </div>
        </form>