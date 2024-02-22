<link rel="stylesheet" href="{{ asset('assets/extra-libs/toastr/dist/build/toastr.min.css') }}">
<script src="{{ asset('assets/extra-libs/toastr/dist/build/toastr.min.js') }}"></script>
@if(session()->has('notify'))
@foreach(session('notify') as $msg)
<script>
    "use strict";
    toastr.success("{{__($msg[1])}}", "{{ $msg[0] }}");
</script>
@endforeach
@endif

<script>
    function createFormAjax(url = null, type = null, formId = null, ModalId = null, table = null) {

        forms = $(formId)[0];
        block("body");
        var form = new FormData(forms);
        var request = $.ajax({
            url: url,
            method: type,
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            processData: false,
            contentType: false,
            data: form,
        });
        request.done(function(response) {
            unblock("body")
            if (response.success) {
                  table.draw();
                notify('success', response.success);
            }
            if (response.error) {
                notify('error', response.error);
            }
            $(ModalId).modal('hide');
            // $('.modal-body').html('');
            if (forms) {
                forms.reset();
            }

            if (table == null) {

            } else {
                table.draw();
            }

            if (response.redirect) {
                setTimeout(function() {
                    location.href = response.redirect
                }, 1000);
            }

            if (response.html) {
                $('#' + response.html.selector).html(response.html.data)
            }


        });
        request.fail(function(jqXHR, textStatus) {
            unblock("body")
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

        return request;
    }

    function updateFormDataAjax(url = null, type = null, formId = null, ModalId = null, table = null, myDropzone = null) {
        forms = $(formId)[0];
        block("body");
        var form = new FormData(forms);
        var request = $.ajax({
            url: url,
            method: type,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: form,
        });
        request.done(function(response) {
            unblock("body")
            if (response.success) {
                notify('success', response.success);
            }
            if (response.error) {
                notify('error', response.error);
            }
            $(ModalId).modal('hide');
            // $('.modal-body').html('');
            if (table == null) {

            } else {
                table.draw();
            }

            if (myDropzone != null) {

                if (response.redirect) {

                    if (myDropzone.getQueuedFiles().length > 0) {

                        $('#files-main-id').val(response.id);

                        myDropzone.processQueue();

                    } else {

                        setTimeout(function() {

                            location.href = response.redirect

                        }, 1000);
                    }


                }

            } else {

                if (response.redirect) {

                    setTimeout(function() {
                        location.href = response.redirect
                    }, 1000);

                }

            }


            if (response.html) {
                $('#' + response.html.selector).html(response.html.data)
            }

        });
        request.fail(function(jqXHR, textStatus) {
            unblock("body")
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

    function updateFormAjax(url = null, type = null, formId = null, ModalId = null, table = null) {
        block("body");
        var request = $.ajax({
            url: url,
            method: type,
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: $(formId).serialize(),
        });
        request.done(function(response) {
            unblock("body")
            if (response.success) {
                notify('success', response.success);
            }
            if (response.error) {
                notify('error', response.error);
            }
            $(ModalId).modal('hide');
            // $('.modal-body').html('');
            if (table == null) {

            } else {
                table.draw();
            }

            if (response.redirect) {
                setTimeout(function() {
                    location.href = response.redirect
                }, 1000);
            }

            if (response.html) {
                $('#' + response.html.selector).html(response.html.data)
            }

        });
        request.fail(function(jqXHR, textStatus) {
            unblock("body")
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

    function getHtmlAjax(url = null, ModalId = null, bodyId = null, data = null) {
        block("body")
        var request = $.ajax({
            url: url,
            method: "GET",
            dataType: "html",
            data: data,
        });
        request.done(function(response) {
            unblock("body")
            if (response.error) {
                notify('error', response.error);
            }
            $(bodyId).html(response);
            $(ModalId).modal('show');
        });
        request.fail(function(jqXHR, textStatus) {
            unblock("body")
            if (jqXHR.status) {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });
    }

    function deleteAjax(url = null, table = null) {
        block("body")
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-2 btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var request = $.ajax({
                    url: url,
                    method: "DELETE",
                    data: {
                        "_token": "{{csrf_token()}}"
                    },
                    dataType: "json",
                });
                request.done(function(response) {
                    unblock("body")
                    if (response.success) {
                        notify('success', response.success);
                    }
                    if (response.error) {
                        notify('error', response.error);
                    }
                    if (table == null) {

                    } else {
                        table.draw();
                    }
                    if (response.remove) {
                        $('#' + response.remove).fadeOut();
                    }
                    if (response.redirect) {
                        setTimeout(function() {
                            location.href = response.redirect
                        }, 1000);
                    }
                    if (response.html) {
                        $('#' + response.html.selector).html(response.html.data)
                    }
                });
                request.fail(function(jqXHR, textStatus) {
                    unblock("body")
                    if (jqXHR.status == '422') {
                        notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary data is safe :)',
                    'error'
                )
            }
        })

    }


    $(".ni-notification-click-read").on('click', function(e) {
        var url = "{{route('notification.markAsRead')}}";
        var id = $(this).data('notification-id');
        var request = $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            data: {
                'id': id
            },
        });
        request.done(function(response) {
            if (response.error) {
                notify('error', response.error);
            }
        });
        request.fail(function(jqXHR, textStatus) {

            if (jqXHR.status == '422') {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });


    });

    $(".ni-notification-click-all-read").on('click', function(e) {
        var url = "{{route('notification.markAllRead')}}";
        var id = $(this).data('notification-id');
        var request = $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            data: {
                'id': id
            },
        });
        request.done(function(response) {
            if (response.error) {
                notify('error', response.error);
            }
        });
        request.fail(function(jqXHR, textStatus) {

            if (jqXHR.status == '422') {
                notify('error', "Request failed because of status " + jqXHR.status + " " + jqXHR.statusText);
            }
        });


    })

    function block(block_ele) {
        $(block_ele).block({
            message: '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
            timeout: false, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0,
                color: "gray",
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    }

    function unblock(block_ele) {
        $(block_ele).unblock();
    }

    "use strict";


    function notify(status = null, message = null) {
        if (status == 'success') {
            toastr.success(message, status);
        }
        if (status == 'error') {
            toastr.error(message, status);
        }
    }
</script>