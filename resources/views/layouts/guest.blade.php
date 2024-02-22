<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, material pro admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template">
    <meta name="description" content="Material Pro is powerful and clean admin dashboard template">
    <meta name="robots" content="noindex,nofollow">
    <title>Material Pro Template by WrapPixel</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/adminpro/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <link href="../assets/extra-libs/input-tel/css/intlTelInput.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">

        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <div class="preloader">
            <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
                <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
                <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
                <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
                <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
        {{ $slot }}
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- All Required js -->
    <!-- -------------------------------------------------------------- -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- -------------------------------------------------------------- -->
    <script src="../assets/extra-libs/input-tel/js/intlTelInput.min.js"></script>
    <script src="../assets/extra-libs/input-tel/js/intlTelInput-jquery.min.js"></script>
    <!-- This page plugin js -->
    <!-- -------------------------------------------------------------- -->
    <script src="{{asset('assets/extra-libs/input-tel/js/intlTelInput.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var countryCode = 'us';
            var inputJquery = document.querySelector("#contact_no");

            var contact = intlTelInput(inputJquery, {
                autoHideDialCode: true,
                allowDropdown: true,
                autoInsertDialCode: true,
                autoPlaceholder: "aggressive",
                customPlaceholder: null,
                dropdownContainer: null,
                excludeCountries: [],
                formatOnDisplay: true,
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "json").always(function(resp) {
                        countryCode = (resp && resp.country) ? resp.country : "us";
                        callback(countryCode);
                    });
                },
                hiddenInput: "",
                localizedCountries: null,
                nationalMode: true,
                onlyCountries: [],
                placeholderNumberType: "MOBILE",
                preferredCountries: ['cw', 'us', 'gb'],
                separateDialCode: true,
                showFlags: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.21/js/utils.js?1613236686837"
            });

            isValid(inputJquery); //init is valid

            //Check if number is valid
            function isValid(inputSelect) {

                var input, iti_IsValid, iti_Error, reset, errorMap, errorMsg, validMsg;

                input = inputSelect;

                errorMsg = document.querySelector("#error-msg"),
                    validMsg = document.querySelector("#valid-msg");

                // here, the index maps to the error code returned from getValidationError - see readme
                errorMap = ['INVALID NO', "Invalid country code", 'TOO SHORT', 'TOO LONG', 'NULL'];

                reset = function() {
                    input.classList.remove("error");
                    errorMsg.innerHTML = "";
                    errorMsg.classList.add("hide");
                    validMsg.classList.add("hide");
                };

                // on blur: validate
                input.addEventListener('blur', function() {
                    reset();
                    if (input.value.trim()) {

                        iti_IsValid = contact.isValidNumber();
                        iti_Error = contact.getValidationError();
                        console.log(iti_IsValid, iti_Error)
                        if (iti_IsValid && iti_IsValid !== null) {
                            getFullData(this)
                            validMsg.classList.remove("hide");
                        } else {
                            $('#isvalid').val(contact.isValidNumber());
                            input.classList.add("error");
                            var errorCode = iti_Error;

                            if (iti_IsValid == null || errorCode == -99) {
                                errorCode = 0;
                            }

                            errorMsg.innerHTML = errorMap[errorCode];
                            errorMsg.classList.remove("hide");
                        }
                    }
                });

                // on keyup / change flag: reset
                input.addEventListener('change', reset);
                input.addEventListener('keyup', reset);
            }



            //Get country data
            function getFullData(input) {
                var code, phone, name, country_code, isvalid;
                code = contact.getSelectedCountryData().dialCode;
                phone = $('#contact_no').val();
                name = contact.getSelectedCountryData().name;
                country_code = contact.getSelectedCountryData().iso2;
                isvalid = contact.isValidNumber();
                $('#phone_complete').val(phone);
                $('#country_code').val(code);
                $('#initial_country').val(country_code);
                $('#isvalid').val(isvalid);
                console.log(code, phone, name, country_code, isvalid)
                return {
                    'code': code,
                    'phone': phone,
                    'name': name,
                    'country_code': country_code,
                    'valid': isvalid
                };
            }

        });


        $(".preloader").fadeOut();
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    <script src="{{asset('assets/libs/block-ui/jquery.blockUI.js')}}"></script>
    @include('admin.partials.notify')
</body>

</html>