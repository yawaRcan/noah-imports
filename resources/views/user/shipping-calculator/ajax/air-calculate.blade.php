<div class="card calculator_info hidden" style="box-shadow: none; border: none; 
     background: transparent; 
     text-align: right;">
    <div class="card-body">
        <p class="insurance mb-0">
            <b>Insurance :</b>
            <span>{{$total['data']['insurance']}}</span>
        </p>
        <p class="item_value mb-0">
            <b>Item Value:</b>
            <span>{{$total['data']['item_value']}}</span>
        </p>
        <p class="chargeable_weight_amount mb-0">
            <b>chargable Weight amount:</b>
            <span>{{$total['data']['chargeable_weight_amount']}}</span>
        </p>
        <p class="clearance_charges mb-0">
            <b>Clearance Charges:</b>
            <span>{{$total['data']['clearance_charges']}}</span>
        </p>
        <p class="import_duty mb-0">
            <b>Import Duty :</b>
            <span>{{$total['data']['import_duty']}}</span>
        </p>
        <p class="ob mb-0">
            <b>OB %:</b>
            <span>{{$total['data']['ob']}}</span>
        </p>
        <p class="grand_total mb-0">
            <b>Grand Total:</b>
            <span>{{$total['data']['grand_total']}}</span>
        </p>
    </div>
</div>