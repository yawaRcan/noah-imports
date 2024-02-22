<div class="row">
    @forelse($images as $img)
    <div class="col-6 mb-2">
        <img src="{{asset('storage/assets/parcel')}}/{{$img->hash_name}}" class="img-fluid" alt="">
    </div> 
    @empty
    <div class="text-center fw-bold"> No Data Available </div>
    @endforelse
</div>