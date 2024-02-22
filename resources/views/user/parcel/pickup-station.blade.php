 <div class="row">
     @forelse($pickupStation as $pickUp)
     <div class="col-md-6 col-sm-12 pickup-select-div">
         <div class="card card-hover">
             <div class="card-header">
                 <h4 class="mb-0 text-dark">{{$pickUp->name}}-Pickup Station</h4>
             </div>
             <div class="card-body">
                 <p class="card-text">{{$pickUp->address}}</p>
                 <a class="card-text">{{$pickUp->email}} </a>| <a class="card-text">{{$pickUp->country_code}}-{{$pickUp->phone}}</a>
                 <div class="row">
                     <div class="col-6 text-start">
                         <div class="form-check form-check-inline">
                             <input class="form-check-input primary check-outline outline-primary" type="radio" name="radio-pickup-station" id="primary-outline-radio" value="{{$pickUp->id}}">
                             <label class="form-check-label" for="primary-outline-radio">{{$pickUp->branch->name}}</label>
                         </div>
                     </div>
                     <div class="col-6 text-end"> 
                     </div>

                 </div>
             </div>
         </div>
     </div>
     @empty
     <div class="row">
         <div class="col-12"> 
            <p class="text-center">No pickup station available</p>
         </div>
     </div>
     @endforelse
 </div>

 <script>
     // Add a click event listener to the div
     $(document).on('click', '.pickup-select-div', function(event) { 
         // Check if the clicked target is an input element of type radio
         $(this).find('input').prop( "checked", true );
         $("#ni-hidden-pickup-station").val($(this).find('input').val());
    
     });
 </script>