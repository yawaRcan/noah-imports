<div class="row">
    @foreach($Branch as $bran)
    <div class="col-md-5 col-sm-12">
        <div class="card card-hover">
            <div class="card-header">
                <h4 class="mb-0 text-dark">{{$bran->name}}</h4>
            </div>
            <div class="card-body">
                <p class="card-text">{{$bran->address}}</p>
                <a class="card-text">{{$bran->email}} </a>| <a class="card-text">{{$bran->country_code}}-{{$bran->phone}}</a>
                <p class="card-text">Currency: {{$bran->currency->name ?? ''}} {{$bran->currency->code ?? ''}}</p>
                <p class="card-text">Pickup {{$bran->currency->code ?? ''}}{{$bran->pickup_fee}}</p>
                <div class="row">
                    <div class="col-6 text-start">
                        <a href="javascript:void(0)" class="branch-data-edit" href="#" data-branch-id="{{$bran->id}}" style="font-size:20px">
                            <i class="me-2 mdi mdi-table-edit"></i>
                        </a>
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:void(0)" class="text-danger branch-data-delete" href="#" data-branch-id="{{$bran->id}}" style="font-size:20px">
                            <i class="me-2 mdi mdi-delete"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $Branch->links() !!}
</div>