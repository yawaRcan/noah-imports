<form class="form-horizontal" id="parcel-edit-form" action="javascript:void(0)">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label>Quantity</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-format-list-numbers"></span>
                    </span>
                    <input type="text" class="form-control" value="{{$parcel->quantity}}" name="quantity" id="ni-quantity">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label>Weight (LBS)</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-weight-kilogram"></span>
                </span>
                <input type="text" class="form-control" value="{{$parcel->weight}}" name="weight" id="ni-weight">
            </div>
        </div>
        <div class="col-md-4">
            <label>Dimention</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-webhook"></span>
                </span>
                <input type="text" class="form-control" value="{{$parcel->dimension}}" name="dimention" id="ni-dimention">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label>Length (Inch)</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-hololens"></span>
                    </span>
                    <input type="text" class="form-control" value="{{$parcel->length}}" name="length_inch" id="ni-length-inch">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label>Width (Inch)</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-panorama-wide-angle"></span>
                </span>
                <input type="text" class="form-control" value="{{$parcel->width}}" name="width_inch" id="ni-width-inch">
            </div>
        </div>
        <div class="col-md-4">
            <label>Height (Inch)</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-panorama-vertical"></span>
                </span>
                <input type="text" class="form-control" value="{{$parcel->width}}" name="height_inch" id="ni-height-inch">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Item Value</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-console"></span>
                    </span>
                    <input type="text" class="form-control" value="{{$parcel->item_value}}" name="item_value" id="ni-item-value">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label>Import Duties</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-console"></span>
                </span>
                <select name="import_duties" id="ni-import-duties" class="select2 form-control custom-select" style="width: 80%;">
                    <option value="">Select Import Duties</option>
                    @foreach($importDuties as $key => $val)

                    @if($parcel->import_duty_id == $key)
                    <option value="{{$key}}" selected>{{$val}}</option>
                    @else
                    <option value="{{$key}}">{{$val}}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Delivery Fees</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-console"></span>
                    </span>
                    <input type="text" class="form-control" value="{{$parcel->delivery_fee}}" name="delivery_fees" id="ni-delivery-fees">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-12 text-start">
                    <label>OB ( % )</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-comment-alert-outline"></span>
                </span>
                <select name="ob_fees" id="ni-ob-fees" class="select2 form-control custom-select" style="width: 80%;">
                    <option value="">Select OB Fees</option>
                    <option value="1" @if($parcel->ob_fees == 1) selected @endif >0 %</option>
                    <option value="6" @if($parcel->ob_fees == 6) selected @endif >6 %</option>
                    <option value="9" @if($parcel->ob_fees == 9) selected @endif >9 %</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Discount</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-percent"></span>
                    </span>
                    <input type="text" class="form-control" value="{{$parcel->discount}}" name="discount" id="ni-discount">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label>Tax</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <span class="mdi mdi-percent"></span>
                </span>
                <input type="text" class="form-control" value="{{$parcel->tax}}" name="tax" id="ni-tax">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label>Product Description</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="mdi mdi-sort-descending"></span>
                    </span>
                    <textarea class="form-control" name="product_desc" id="ni-product-desc">{{$parcel->product_description}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="p-1 text-center">
        <button type="submit" class="btn btn-light-success text-success font-weight-medium waves-effect" data-parcel-id="{{$parcel->id}}" id="parcel-edit-button">Edit Item</button>
    </div>

</form> 