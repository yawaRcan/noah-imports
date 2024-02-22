<div class="row">
    <div class="col-12">
        <form class="form-horizontal" id="payment-status-form" action="javascript:void(0)"> 
        @csrf 
         
        <input type="hidden" name="parcelId" value="{{$parcel->id}}"/>
                            <div class="mb-3">
                                <label for="image">Payment Method</label>
                                <select class="form-control payment_method" name="payment_method">
                                    <option value="">--Select Payment Method--</option>
                                    @foreach($paymentMethods as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Payment Invoice</label>
                                 <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                        <span class="mdi mdi-file-image"></span>
                                        </span>
                                        <input type="file" class="form-control" name="payment_file" id="ni-payment-file">
                                  </div>
                            </div>
                            <div class="col-12" id="ni-payment-file-append">

                            </div>
                        
        <div class="text-end">
            <button type="button" class="btn btn-light-success text-success font-weight-medium waves-effect" id="parcel-update-button" data-parcel-id="">Update</button>
        </div>
       </form>
    </div>
</div>

<script>

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
                $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="' + e.target.result + '" width="200" height="200"/></div>');
              } else {
                // If it's not an image, display the document icon
                $('#ni-payment-file-append').html('<div class="text-start p-3 img-round"><img class="nl-exship-payment-add-preview" src="{{asset("assets/icons/document-icon.jpg")}}" width="450" height="300"/></div>');
              }
          };
          reader.readAsDataURL(input.files[0]);
      }
  }

  $("#parcel-update-button").on('click', function(e) {
     
        e.stopPropagation();
        let url = "{{route('user.parcel.updatePaymentStatus')}}";
        let ModalId = "#ni-payment-status-modal";
        let formId = "#payment-status-form";
        let type = "POST";
        updateFormDataAjax(url, type, formId, ModalId, table) 
    })
</script>