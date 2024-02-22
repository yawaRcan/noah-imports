   // Searching Users From the User select field
   $("#ni-search_id").select2({
    placeholder: "Select a user",
    allowClear: true,
    ajax: {
        url: "{{route('parcel.getusers')}}",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            $('.reciver-error-text').html('')
            $('.mdi-check-btn').addClass('hide');
            $('.mdi-cross-btn').addClass('hide');
            $('#ni-user-spin').removeClass('hide');
            return {
                q: params.term, // search term 
            };
        },
        processResults: function(data) {
            // Appending Data to User select Field
            var arr = []
            $.each(data.items, function(index, value) {
                arr.push({
                    id: value.id,
                    text: value.first_name + ' ' + value.last_name
                })
            });
            $('#ni-user-spin').addClass('hide');
            return {
                results: arr
            };
        },
        cache: true,
    },
    minimumInputLength: 1
});


// Select2 for form select fields
$("#ni-sender-ship-address").select2();
$("#ni-branch-id").select2();
$("#ni-reciver-ship-address").select2({
    placeholder: "Select Reciever Address",
});
$("#ni-external-shpper").select2({
    templateResult: formatState,
    templateSelection: formatState
});
$("#ni-freight-type").select2();
$("#ni-shipment-type").select2();
$("#ni-shipment-mode").select2();
$("#ni-from-country").select2();
$("#ni-to-country").select2();
jQuery('#ni-estimate-delivery-date').datepicker({
    autoclose: true,
    todayHighlight: true
});

function formatState(opt) {
    if (!opt.id) {
        return opt.text.toUpperCase();
    }

    var optimage = $(opt.element).attr('data-image');

    if (!optimage) {
        return opt.text.toUpperCase();
    } else {
        var $opt = $(
            '<span><img src="' + optimage + '" width="40px" /> ' + opt.text.toUpperCase() + '</span>'
        );
        return $opt;
    }
};
// Ajax Action of checking Selected User Addresses 
$(document).on('change', "#ni-search_id", function() {

    let id = $(this).val();
    $('#ni-user-spin').removeClass('hide');
    $('.reciver-error-text').html('')
    $('.mdi-check-btn').addClass('hide');
    $('.mdi-cross-btn').addClass('hide');
    if (id != "undefined" && id != null && id != '') {
        var request = $.ajax({
            url: "{{route('parcel.checkReciverAdd')}}",
            method: "GET",
            dataType: "json",
            data: {
                id: id
            },
        });
        // Done Action of checking Selected User Addresses 
        request.done(function(response) {

            if (response.error != '' && response.error != 'undefined' && response.error != null) {
                $('#ni-user-spin').addClass('hide');
                $('.reciver-error-text').html(response.error)
                $('.mdi-check-btn').addClass('hide');
                $('.mdi-cross-btn').removeClass('hide');
                $('#ni-reciver-address-add').removeAttr("disabled");
            } else {
                $('#ni-user-spin').addClass('hide');
                $('.reciver-error-text').html('')
                $('.mdi-check-btn').removeClass('hide');
                $('.mdi-cross-btn').addClass('hide');
                $('#ni-reciver-address-add').removeAttr("disabled");

            }

            $('#ni-full-name').val(response.full_name)
            $("#ni-reciver-ship-address").empty();
            $.each(response.addresses, function(index, value) {
                var newOption = new Option(value.name, value.id, false, false);
                $('#ni-reciver-ship-address').append(newOption).trigger('change');
            });



        });
        // Fail Action of checking Selected User Addresses 
        request.fail(function(jqXHR, textStatus) {

            if (jqXHR.status) {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });
    }



})

// Opening of User Reciever Address Modal
$(document).on('click', "#ni-reciver-address-add", function() {
    let url = "{{route('parcel.getrecieverhtml')}}";
    // Function to get html of Reciever Address Form
    getHtmlAjax(url, "#ni-reciver-address-add-modal", "#ni-reciver-address-body")
    setTimeout(function() {
        $('#ni-reciever-user').val($("#ni-search_id").val())
    }, 1000);
})

// Click action on Delivery Method Field
$(document).on('change', "#ni-delivery-method", function() {

    let value = $(this).val();
    if (value == 1) {
        if ($("#ni-hidden-pickup-station").val() == 0) {
            // Opening of Pickup Station Select Modal 
            let url = "{{route('parcel.getPickupStation')}}";
            // Function to get html of Pickup Station Modal 
            getHtmlAjax(url, "#ni-pickup-station-modal", "#ni-pickup-station-body")
            // Show pickup station change icon
            $("#ni-change-station").show()
        } else {
            // Opening of Pickup Station Select Modal 
            $("#ni-pickup-station-modal").modal('show')
            // Show pickup station change icon
            $("#ni-change-station").show()
        }
    } else {
        $("#ni-change-station").hide()
    }

})

$(document).on('click', "#ni-change-station", function() {
    // Opening of Pickup Station Select Modal 
    $("#ni-pickup-station-modal").modal('show')
})

$("#ni-payment-file").change(function() {
    filePreview(this);
});

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.nl-exship-payment-add-preview').remove();
            if (input.files[0].type.indexOf('image') === 0) {
              // If it's an image, display it in the file preview
              $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="450" height="300"/></div>');
            } else {
              // If it's not an image, display the document icon
              $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}



// Action On Click Reciever Address Form Add Button
$(document).on('click', "#ni-reciever-address-add-btn", function() {

    // Collecting Current Form Data 
    forms = $("#ni-reciever-address-add-form")[0];
    var form = new FormData(forms);

    // Running Reciever adding ajax request
    var request = $.ajax({
        url: "{{route('parcel.addreciever')}}",
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

        // Hiding Current modal
        $("#ni-reciver-address-add-modal").modal('hide');
        // Empty the current modal
        $('.modal-body').html('');
        // Appending values to Reciever address Select data
        if (response.value) {
            var newOption = new Option(response.value.name, response.value.id, false, false);
            $('#ni-reciver-ship-address').append(newOption).trigger('change');
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

$(document).on('click', "#parcel-add-button", function() {

    let url = "{{route('parcel.store')}}";
    let formId = "#parcel-add-form";
    let type = "POST";
    updateFormDataAjax(url, type, formId)

})

$(document).on('change', "#ni-discount-type", function() {
    let val = $(this).val();

    if (val != '' && val != 'undefined' && val != null) {
        if (val == 'ship') {
            $('#ni-discount-text').html('Shipment Discount');
            $('#ni-dicount-val-total').hide();
            $('#ni-dicount-val-ship').show();
        } else {
            $('#ni-discount-text').html('Total Discount');
            $('#ni-dicount-val-ship').hide();
            $('#ni-dicount-val-total').show();
        }
        $('#ni-dicount-modal').modal('show')
    }
})

$(document).on('change', ".ni-dicount-val", function() {
    $("#ni-hidden-discount").val($(this).val());
})
$(document).on('click', "#ni-change-discount", function() {
    let val = $('#ni-discount-type').val();

    if (val != '' && val != 'undefined' && val != null) {
        if (val == 'ship') {
            $('#ni-discount-text').html('Shipment Discount');
            $('#ni-dicount-val-total').hide();
            $('#ni-dicount-val-ship').show();
        } else {
            $('#ni-discount-text').html('Total Discount');
            $('#ni-dicount-val-ship').hide();
            $('#ni-dicount-val-total').show();
        }
        $('#ni-dicount-modal').modal('show')
    }
})