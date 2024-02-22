@forelse($order->billing as $key => $billing)
<tr>
    <td>{{ ++$key}}</td>
    <td>{{ $billing->created_at->format('d-M-Y') }}</td>
    <td>{{ $billing->payment->name ?? 'N/A' }} <img class="ni-payment-show-modal" data-order-id="' . $row->id . '" src="{{asset('assets/icons')}}/{{$billing->payment->icon ?? ''}}" width="30px" /></td>
    <td>{{ $billing->order->currency->symbol ?? '' }} {{ $billing->paid_amount ?? '0.00' }}</td>
    <td>
        @if($billing->payment_invoice)
        <button class="btn btn-success btn-sm ni-payment-show-modal" title="View Receipt" data-billing-id="{{$billing->id}}"><i class="fas fa-receipt"></i></button>&nbsp;
        @endif
        <button class="btn btn-primary btn-sm billing-data-edit" title="Edit" data-billing-id="{{ $billing->id }}"><i class="fa fa-edit"></i></button>
        &nbsp;
        <button class="btn btn-danger btn-sm billing-data-delete" data-billing-id="{{ $billing->id }}"><i class="fa fa-trash"></i></button></td>
</tr>
@empty
<tr>
    <td class="text-center" colspan="5">No Payment Available!</td>
</tr>
@endforelse

<tr class="text-end">
    <td colspan="4"><strong>Total Amount:</strong></td>
    <td>
        <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->total ?? '00.0',2)}}</strong>
    </td>
</tr>
<tr class="text-end">
    <td colspan="4"><strong>Total Paid:</strong></td>
    <td>
        <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->total - $order->balance_due, 2)}}</strong>
    </td>
</tr>
<tr class="text-end">
    <td colspan="4"><strong>Balance Due:</strong></td>
    <td>
        <strong>{{$order->currency->symbol ?? ''}} {{number_format($order->balance_due ?? '00.0',2)}}</strong>
    </td>
</tr>