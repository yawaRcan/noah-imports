    <!-- calculator info text --> 
    <div class="card calculator_info hidden" style="box-shadow: none; border: none; 
         background: transparent; 
         text-align: right;">
        <div class="card-body">
            <p class="insurance mb-0">
                <b>Insurance :</b>
                <span>{{$total['data']['insurance']}}</span>
            </p>
            <p class="item_value mb-0">
                <b>Item Value :</b>
                <span>{{$total['data']['item_value']}}</span>
            </p>
            <p class="chargeable_dimension mb-0">
                <b>Chargable Dimension:</b>
                <span>{{$total['data']['chargeable_dimension'] ?? ''}}</span>
            </p>
            <p class="insurance_invoice mb-0">
                <b>Insurance Invoice:</b>
                <span>{{$total['data']['insurance_invoice_value']}}</span>
            </p>
            <p class="clearance_charges mb-0">
            <b>clearance Charges  :</b>
                <span>{{$total['data']['clearance_charges']}}</span>
            </p>
            <p class="import_duty mb-0">
               <b>Import Duty :</b>
                <span>{{$total['data']['import_duty']}}</span>
            </p>
            <p class="ob mb-0">
                <b>Ob %:</b>
                <span>{{$total['data']['ob']}}</span>
            </p>
            <p class="grand_total mb-0">
                <b>Grand Total:</b>
                <span>{{$total['data']['total']}}</span>
            </p>
        </div>
    </div>