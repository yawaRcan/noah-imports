@forelse($products as $product)
<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card card-hover shadow">
        <div class="el-card-item pb-3">
            <div class="el-card-avatar mb-3 el-overlay-1 w-100 overflow-hidden position-relative text-center"> <img src="{{asset('storage/assets/product/')}}/{{$product->files[0]->hash_name}}" class="d-block position-relative w-100" alt="user" />
                <div class="el-overlay w-100 overflow-hidden">
                    <ul class="list-style-none el-info text-white text-uppercase d-inline-block p-0">
                        <li class="el-item d-inline-block my-0  mx-1"><a class="btn default btn-outline image-popup-vertical-fit el-link text-white border-white" href="{{asset('storage/assets/product/')}}/{{$product->files[0]->hash_name}}"><i class="icon-magnifier"></i></a></li>
                        <li class="el-item d-inline-block my-0  mx-1"><a class="btn default btn-outline el-link text-white border-white add-to-cart" href="javascript:void(0);" data-product-id='{{$product->id}}'><i class="mdi mdi-cart"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex no-block align-items-center">
                <div class="ms-3">
                    <h4 class="mb-0"><a href="javascript:void(0)" class="show-product-detail" data-product-id="{{$product->id}}">{{$product->title}}</a></h4>
                    <span class="text-muted">{{$product->category->title}} - {{$product->subCategory->title}}</span>
                </div>
                <div class="ms-auto me-3">
                    <button type="button" class="btn btn-dark btn-circle">${{$product->price}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="text-center">
    Products is not available
</div>
@endforelse