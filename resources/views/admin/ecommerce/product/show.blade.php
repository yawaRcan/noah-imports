   <!-- -------------------------------------------------------------- -->
   <!-- Start Page Content -->
   <!-- -------------------------------------------------------------- -->
   <div class="row">
       <!-- Column -->
       <div class="col-lg-12">
           <div class="card">
               <div class="card-body">
                   <h3 class="card-title">{{$product->title}}</h3>
                   <h6 class="card-subtitle">{{$product->summary}}</h6>
                   <div class="row">
                       <div class="col-lg-4 col-md-4 col-sm-6">
                           <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                               <ol class="carousel-indicators">
                                   <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                                   <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                                   <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
                               </ol>
                               <div class="carousel-inner">
                                   @foreach($product->files as $key => $file)
                                   @if($key == 0)
                                   <div class="carousel-item active">
                                       <img src="{{asset('storage/assets/product')}}/{{$file->hash_name}}" class="d-block w-100" alt="...">
                                   </div>
                                   @else
                                   <div class="carousel-item">
                                       <img src="{{asset('storage/assets/product')}}/{{$file->hash_name}}" class="d-block w-100" alt="...">
                                   </div>
                                   @endif
                                   @endforeach
                               </div>
                               <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                                   <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                   <span class="visually-hidden">Previous</span>
                               </a>
                               <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                                   <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                   <span class="visually-hidden">Next</span>
                               </a>
                           </div>
                       </div>
                       <div class="col-lg-8 col-md-8 col-sm-6">
                           <h4 class="box-title mt-5">Product description</h4>
                           {!! $product->description !!}
                           <h2 class="mt-5">${{$product->price}} <small class="text-success">({{$product->discount}}% off)</small></h2>
                           <button class="btn btn-dark btn-rounded me-1 add-to-cart" data-bs-toggle="tooltip" title="" data-original-title="Add to cart" data-product-id='{{$product->id}}'><i class="mdi mdi-cart"></i> Add To Cart </button>
                           <!-- <button class="btn btn-primary btn-rounded"> Buy Now </button> -->
                           <!-- <h3 class="box-title mt-5">Key Highlights</h3>
                            <ul class="list-group list-group-flush ps-0">
                                <li class="list-group-item border-bottom-0 py-1 px-0 text-muted">
                                    <i data-feather="check-circle" class="text-primary feather-sm me-2"></i>
                                    Lorem Ipsum available, but the majority have suffered alteration in some form
                                </li>
                                <li class="list-group-item border-bottom-0 py-1 px-0 text-muted">
                                    <i data-feather="check-circle" class="text-primary feather-sm me-2"></i>
                                    Lorem Ipsum available, but the majority have suffered alteration in some form
                                </li>
                                <li class="list-group-item border-bottom-0 py-1 px-0 text-muted">
                                    <i data-feather="check-circle" class="text-primary feather-sm me-2"></i>
                                    Lorem Ipsum available, but the majority have suffered alteration in some form
                                </li>
                                <li class="list-group-item border-bottom-0 py-1 px-0 text-muted">
                                    <i data-feather="check-circle" class="text-primary feather-sm me-2"></i>
                                    Lorem Ipsum available, but the majority have suffered alteration in some form
                                </li>
                                <li class="list-group-item border-bottom-0 py-1 px-0 text-muted">
                                    <i data-feather="check-circle" class="text-primary feather-sm me-2"></i>
                                    Lorem Ipsum available, but the majority have suffered alteration in some form
                                </li>
                            </ul> -->
                       </div>
                       <div class="col-lg-12 col-md-12 col-sm-12">
                           <h3 class="box-title mt-5">General Info</h3>
                           <div class="table-responsive">
                               <table class="table">
                                   <tbody>
                                       <tr>
                                           <td width="390">Brand</td>
                                           <td> {{$product->brand->title ?? 'Default'}} </td>
                                       </tr>
                                       <tr>
                                           <td>Delivery Condition</td>
                                           <td> {{$product->condition ?? 'Default'}} </td>
                                       </tr>
                                       <tr>
                                           <td>Category</td>
                                           <td> {{$product->category->title ?? 'Default'}} </td>
                                       </tr>
                                       <tr>
                                           <td>Sub Category</td>
                                           <td> {{$product->subCategory->title ?? 'Default'}} </td>
                                       </tr>
                                       <tr>
                                           <td>Size</td>
                                           <td> {{$product->size ?? 'Default'}} </td>
                                       </tr>
                                       <tr>
                                           <td>In Stock</td>
                                           <td> {{$product->stock > 0 ? $product->stock : 'Not available'}} </td>
                                       </tr>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- Column -->
   </div>
   <!-- -------------------------------------------------------------- -->
   <!-- End PAge Content -->
   <!-- -------------------------------------------------------------- -->