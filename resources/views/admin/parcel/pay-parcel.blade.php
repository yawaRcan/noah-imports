<form class="form-horizontal" id="parcel-payment-form" action="javascript:void(0)">
    <input type="hidden" name="user_id" value="{{@$parcels[0]->user->id}}">
    <input type="hidden" name="amount_converted" value="{{number_format($totalCoverted,2)}}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Parcel Details</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>External Tracking</th>
                                    <th>Category</th>
                                    <th>Amount(ANG)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parcels as  $key => $parcel)
                                    <input type="hidden" name="parcelIds[]" value="{{$parcel->id}}">
                                    <input type="hidden" name="item_values[]" value="{{$parcel->item_value}}">
                                    <tr>
                                        <td>{{$parcel->invoice_no ?? 'N/A'}}</td>
                                        <td>{{$parcel->external_tracking ?? 'N/A'}}</td>
                                        <td>{{$parcel->duty->name ?? 'N/A'}}</td>
                                        <td>ƒ {{number_format($total[$key],2) ?? 'N/A'}} ANG</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="border-bottom title-part-padding">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-0">Wallet Details</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Current Ballance<br> <span class="fw-bold">ƒ {{number_format(@$parcels[0]->user->balance(),2) ?? 'N/A'}} ANG</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Total amount to be paid<br> <span class="fw-bold">ƒ {{number_format($totalCoverted,2) ?? 'N/A'}} ANG</span></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="card-text">Remaining balance after debit<br> <span class="fw-bold">ƒ {{number_format(@$parcels[0]->user->balance() - $totalCoverted,2) }} ANG</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
