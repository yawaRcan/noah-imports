<div class="p-3 text-start">
    <form class="form-horizontal" id="product-add-item-form" action="javascript:void(0)">
        @csrf
        <input type="hidden" name="product_number" class="item-number" value="">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 row">
                    <label for="tb-rfname">User</label>
                    <div class="form-group mb-3">
                        <!-- <span class="input-group-text fa fa-user"></span> -->
                        <select class="form-control select2" name="user_id" id="user-item" style="width: 100%;">
                            <option>-- Select User --</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}" {{$user->id == $userId ? 'selected' : ''}}>{{$user->first_name}} {{$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Select Category</label>
                    <select name="purchase_category_id" id="ni-category-id-item" class="select2 form-control custom-select" style="width: 90%;">
                        <option value="">Select Category</option>
                        @foreach($purchaseCategories as $key => $val)
                        <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="mb-3 row">
            <div class="row">
                <div class="col-md-6">
                    <label for="tb-rfname">Website</label>
                </div>
                <div class="col-md-6">
                    <div class="wrapper text-end">
                        <i class="mdi mdi-help-circle-outline help-icon"></i>
                        <div class="tooltip">Copy the product detail page url from Ebay , Alibaba once you copy the url then past it here and wait for a few seconds to fetch images to select one specific image.</div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text fa fa-user"></span>
                <input id="name-item" class="form-control" name="product_url" type="url" value="" placeholder="https://" />
            </div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-info hide" role="status" id="website-loader-item">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-12" id="ni-product-images-item">

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 row">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tb-rfname">Product Name</label>
                        </div>
                        <div class="col-md-6">
                            <div class="wrapper text-end">
                                <i class="mdi mdi-help-circle-outline help-icon"></i>
                                <div class="tooltip">Enter your product name if it does not comes from website link.</div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text fa fa-user"></span>
                        <input id="product_name-item" class="form-control" type="text" name="name" placeholder="Enter the product name" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 row">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tb-rfname">Product Platform</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text fa fa-user"></span>
                        <input id="product_website-item" class="form-control" type="text" name="website" placeholder="Enter product website" />
                    </div>
                </div>
            </div>
        </div>
        <div class="cat-boxes-item hide">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 row ">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tb-rfname">Size</label>
                            </div>
                            <div class="col-md-6">
                                <div class="wrapper text-end">
                                    <i class="mdi mdi-help-circle-outline help-icon"></i>
                                    <div class="tooltip">Enter your product given size name, For example small , medium , large or in numbers if supported.</div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-user"></span>
                            <input id="size-item" class="form-control" type="text" placeholder="S/M/L Or L:32,:W 32" name="size" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 row">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tb-rfname">Color</label>
                            </div>
                            <div class="col-md-6">
                                <div class="wrapper text-end">
                                    <i class="mdi mdi-help-circle-outline help-icon"></i>
                                    <div class="tooltip">Enter color name, For example yellow , red , green , blue.</div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text fa fa-user"></span>
                            <input id="color-item" class="form-control" type="text" placeholder="Yellow / Red / Grey" name="color" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 row">
                    <label for="tb-rfname">Quantity</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fa fa-user"></span>
                        <input id="quantity" class="form-control textfield" type="number" name="quantity" placeholder="Enter the quantity of products" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 row">
                    <label for="tb-rfname">Product Price</label>
                    <div class="col-md-3">
                        <select class="form-control" name="currency_id">
                            @foreach($currencies as $currency)
                            <option value="{{$currency->id}}">{{$currency->name}} - {{$currency->symbol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-9">
                        <input id="price-item" class="form-control" type="number" step="0.01" name="price" placeholder="Enter product price here" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3 row">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tb-rfname">Shipping Price</label>
                        </div>
                        <div class="col-md-6">
                            <div class="wrapper text-end">
                                <i class="mdi mdi-help-circle-outline help-icon"></i>
                                <div class="tooltip">Enter your product shipping price which will be latter used in parcel to ship the product to the concerned user.</div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text fa fa-user"></span>
                        <input id="shipping_price-item" class="form-control" type="number" name="shipping_price" placeholder="Enter the shipping price of product" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 row">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tb-rfname">Tax</label>
                        </div>
                        <div class="col-md-6">
                            <div class="wrapper text-end">
                                <i class="mdi mdi-help-circle-outline help-icon"></i>
                                <div class="tooltip">Enter tax in number, Fixed price.</div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text fa fa-user"></span>
                        <input id="tax-item" class="form-control" type="number" name="tax" placeholder="Enter the tax of product" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tb-rfname">Additonal Note</label>
            <div class="input-group">
                <span class="input-group-text fa fa-user"></span>
                <textarea type="text" rows="2" id="note-item" class="form-control" name="description" placeholder="Write detail about the product"></textarea>
            </div>
        </div>
        <div class="p-3 border-top">
            <div class="text-end save_btn">
                <button class="btn btn-info rounded-pill px-4 waves-effect waves-light" id="product-add-button-item">Save</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // When the icon is clicked
        $('.help-icon').click(function() {
            var tooltip = $(this).closest('div').find('.tooltip');

            // If the tooltip is already visible, hide it
            if (tooltip.css('opacity') === '1') {
                tooltip.css('opacity', 0);
                tooltip.css('pointer-events', 'none');
                tooltip.css('-webkit-transform', 'translateY(10px)');
                tooltip.css('-moz-transform', 'translateY(10px)');
                tooltip.css('-ms-transform', 'translateY(10px)');
                tooltip.css('-o-transform', 'translateY(10px)');
                tooltip.css('transform', 'translateY(10px)');
            } else {
                // If the tooltip is hidden, show it
                tooltip.css('opacity', 1);
                tooltip.css('pointer-events', 'auto');
                tooltip.css('-webkit-transform', 'translateY(0px)');
                tooltip.css('-moz-transform', 'translateY(0px)');
                tooltip.css('-ms-transform', 'translateY(0px)');
                tooltip.css('-o-transform', 'translateY(0px)');
                tooltip.css('transform', 'translateY(0px)');
            }
        });
    });
    $('#product-add-button-item').on('click', function(e) {
        e.stopPropagation();
        // Collecting Current Form Data 
        forms = $("#product-add-item-form")[0];
        var form = new FormData(forms);

        // Running Reciever adding ajax request
        var request = $.ajax({
            url: "{{route('purchasing.product.cart')}}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        // Ajaxt on Done Section here
        request.done(function(response) {

            if (response.success) {
                notify('success', response.success);
            }

            if (response.html) {
                $('#order').removeClass('active');
                $('#cart').addClass('active');
                $('#cart-tbody').html(response.html);
                $('#cart').focus();
                $('#ni-add-item-add').modal('hide');
            }

        });
        request.fail(function(jqXHR, textStatus) {
            // Toaster on Error like validation
            if (jqXHR.status == '422') {
                notify('error', "The Given Data Is Invalid");
                $('.invalid-feedback').remove()
                $(":input").removeClass('is-invalid')
                var errors = jqXHR.responseJSON.errors;
                $.each(errors, function(index, value) {
                    if ($("input[name=" + index + "]").length) {
                        $("input[name=" + index + "]").addClass('is-invalid');
                        $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }


                    if ($("select[name=" + index + "]").length) {
                        $("select[name=" + index + "]").addClass('is-invalid');
                        $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                    if ($("textarea[name=" + index + "]").length) {
                        $("textarea[name=" + index + "]").addClass('is-invalid');
                        $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                    }

                });
            }
        });

    });


    $("#name-item").on('blur', function(e) {
        e.stopPropagation();
        let site_url = $(this).val();
        if (site_url) {
            $('#ni-product-images-item').html('');
            $("#website-loader-item").removeClass('hide');
            var request = $.ajax({
                url: "{{route('purchasing.url.content')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    site_url: site_url
                },
            });
            // Ajax on Done Section here
            request.done(function(response) {

                if (response.success) {
                    notify('success', response.success);
                    $("#website-loader-item").addClass('hide');
                }

                if (response.html) {
                    $('#ni-product-images-item').html(response.html);
                }

            });
            request.fail(function(jqXHR, textStatus) {
                // Toaster on Error like validation
                if (jqXHR.status == '422') {
                    notify('error', "The Given Data Is Invalid");
                    $('.invalid-feedback').remove()
                    $(":input").removeClass('is-invalid')
                    var errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(index, value) {
                        if ($("input[name=" + index + "]").length) {
                            $("input[name=" + index + "]").addClass('is-invalid');
                            $("input[name=" + index + "]").after("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }


                        if ($("select[name=" + index + "]").length) {
                            $("select[name=" + index + "]").addClass('is-invalid');
                            $("select[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }

                        if ($("textarea[name=" + index + "]").length) {
                            $("textarea[name=" + index + "]").addClass('is-invalid');
                            $("textarea[name=" + index + "]").parent('div').append("<div class='invalid-feedback'>" + value[0] + "</div>");
                        }

                    });
                }
            });
        }


    });

    $(document).on('change', "#ni-category-id-item", function(e) {
        e.stopPropagation();
        var value = $(this).val();

        if (value != '' && value != null && value != 'undefined') {

            $('.cat-boxes-item').removeClass("hide");

        } else {

            $('.cat-boxes-item').addClass("hide");

        }

    })
</script>