@extends('admin.layout.master')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Ecommerce</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Ecommerce</a></li>
            <li class="breadcrumb-item"><a href="{{route('product.index')}}">Product</a></li>
            <li class="breadcrumb-item active">Edit Products</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>THIS MONTH</small></h6>
                    <h4 class="mt-0 text-info">ƒ {{$cm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>LAST MONTH</small></h6>
                    <h4 class="mt-0 text-primary">ƒ {{$lm_paid_parcels_amount}} ANG</h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Column -->
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Edit Products</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('product.index')}}" class="btn btn-light-info text-info font-weight-medium waves-effect shipmode-data-add">All Products</a>
                        </div>
                    </div>

                    <form class="form-horizontal" id="product-edit-form" action="javascript:void(0)">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Title</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-account-check"></span>
                                        </span>
                                        <input type="text" class="form-control" name="title" value="{{$product->title ?? ''}}" id="ni-title">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Product Category</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-account-location"></span>
                                    </span>
                                    <select name="category" id="ni-category" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $key => $val)
                                        @if($product->cat_id == $key)
                                        <option value="{{$key}}" selected>{{$val}}</option>
                                        @else
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Product Sub Category</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-account-location"></span>
                                    </span>
                                    <select name="sub_category" id="ni-sub-category" class="select2 form-control custom-select" style="width: 90%;">
                                        <option value="">Select Sub Category</option>
                                        @foreach($subcategories as $key => $val)
                                        @if($product->child_cat_id == $val->id)
                                        <option value="{{$val->id}}" selected>{{$val->title}}</option>
                                        @else
                                        <option value="{{$val->id}}">{{$val->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Price</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" name="price" value="{{$product->price ?? ''}}" id="ni-price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Size</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-weight-kilogram"></span>
                                    </span>
                                    <select name="size" id="ni-size" class="select2 form-control custom-select" style="width: 80%;">
                                        <option value="">--Select any size--</option>
                                        <option value="S" {{$product->size == 'S' ? 'selected' : ''}}>Small (S)</option>
                                        <option value="M" {{$product->size == 'M' ? 'selected' : ''}}>Medium (M)</option>
                                        <option value="XL" {{$product->size == 'XL' ? 'selected' : ''}}>Extra Large (XL)</option>
                                        <option value="L" {{$product->size == 'L' ? 'selected' : ''}}>Large (L)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Discount ( % )</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" name="discount" value="{{$product->discount ?? ''}}" id="ni-discount">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Product Brand</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <select name="brand" id="ni-brand" class="select2 form-control custom-select" style="width: 80%;">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $key => $val)
                                            @if($product->brand_id == $key)
                                            <option value="{{$key}}" selected>{{$val}}</option>
                                            @else
                                            <option value="{{$key}}">{{$val}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Product Condition</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-weight-kilogram"></span>
                                    </span>
                                    <select name="condition" id="ni-condition" class="select2 form-control custom-select" style="width: 80%;">
                                        <option value="">Select Condition</option>
                                        <option value="default" {{$product->condition == 'default' ? 'selected' : ''}}>Default</option>
                                        <option value="new" {{$product->condition == 'new' ? 'selected' : ''}}>New</option>
                                        <option value="hot" {{$product->condition == 'hot' ? 'selected' : ''}}>Hot</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Stock ( % )</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-webhook"></span>
                                    </span>
                                    <input type="text" class="form-control" name="stock" value="{{$product->stock ?? ''}}" id="ni-stock">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Product Tax</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="mdi mdi-format-list-numbers"></span>
                                        </span>
                                        <input type="text" class="form-control" value="{{$product->tax ?? ''}}" name="tax" id="ni-tax">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Product Shipping price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-weight-kilogram"></span>
                                    </span>
                                    <input type="text" class="form-control" value="{{$product->shipping_price ?? ''}}" name="shipping_price" id="ni-shipping-price">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Tags</label>
                                    <select class="form-control" id="select2-with-tokenizer" name="product_tags[]" multiple="" style="width: 100%;height: 36px;">
                                     @foreach($tags as $tag)
                                    <option value="{{$tag->tag}}" selected>{{$tag->tag}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Images</label>
                                    <div class="dropzone" id="myDropzone">

                                    </div>
                                    <input type="hidden" id="files-main-id">
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Product Description</label>
                                    <input type="hidden" id="descriptionQuill_html" name="product_desc"></input>
                                    <div id="product_desc" style="height: 300px;">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <input type="checkbox" id="ni-is-featured" name="is_featured" class="material-inputs filled-in chk-col-blue" checked="">
                                <label for="ni-is-featured">Is Featured</label>
                            </div>
                        </div>
                        <div class="p-1 text-center">
                            <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" id="product-edit-button" data-product-id="{{$product->id}}">Edit Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')


<script>

    $(document).on('change', "#ni-category", function(e) {
        e.preventDefault();

        var cat_id = $(this).val();

        $.ajax({
            url: "{{ route('product.get-sub-categories') }}",
            method: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                cat_id: cat_id
            },
            success: function(response) {
                if (response) {
                    $('#ni-sub-category').empty();
                    $('#ni-sub-category').append('<option value="">Select SubCategory</option');
                    $.each(response, function(index, value) {
                        var newOption = new Option(value, index, false, false);
                        $('#ni-sub-category').append(newOption).trigger('change');
                    });
                }
            }
        });
    });

    var myDropzone = '';

    $(document).on('click', "#product-edit-button", function() {

        let id = $(this).data("product-id");
        let url = "{{route('product.update',['id' => ':id'])}}";
        url = url.replace(':id', id);
        let formId = "#product-edit-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId)

    })

   
    var descriptionQuill = new Quill('#product_desc', {
        theme: 'snow'
    });
    descriptionQuill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("descriptionQuill_html").value = descriptionQuill.root.innerHTML;
    });

    //***********************************//
    // Automatic tokenization
    //***********************************//
    $("#select2-with-tokenizer").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    Dropzone.options.myDropzone = {
        autoProcessQueue: false,
        uploadMultiple: true,
        addRemoveLinks: true,
        maxFilesize: 10,
        maxFiles: 10,
        parallelUploads: 10,
        paramName: "file",
        acceptedFiles: 'image/*',
        url: "{{ route('product.file.store') }}",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Drag and drop files here or click to upload',
        dictFallbackMessage: 'Your browser does not support drag and drop file uploads.',
        init: function() {
            myDropzone = this;
            myDropzone.on('sending', function(file, xhr, formData) {

                var id = $('#files-main-id').val();
                formData.append('product_id', id);
            });
            myDropzone.on("success", function(file, response) {
                setTimeout(function() {
                    location.href = "{{route('product.index')}}"
                }, 1000);
            });
            myDropzone.on("removedfile", function(file) {
                var previewElement = file.previewElement;
                if (previewElement) {
                    previewElement.parentNode.removeChild(previewElement);
                }
            });

        }
    };
</script>
@endpush