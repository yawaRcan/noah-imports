<tr class="item-row">
    <td class="text-center">{{$val->quantity ?? 'N/A'}}</td>
    <td>{{$val->product_description ?? 'N/A'}}</td>
    <td>
        {{$val->duty->name ?? 'N/A'}} ({{$val->duty->value ?? '0'}}%)
    </td>
    <td class="text-center">{{$val->weight ?? '0'}}</td>
    <td class="text-center">{{$val->length ?? '0'}}</td>
    <td class="text-center">{{$val->width ?? '0'}}</td>
    <td class="text-center">{{$val->height ?? '0'}}</td>
    <td class="text-center"> 
        ƒ {{$freight == 'air-freight' ? $ship['data']['chargeable_weight_amount'] : $ship['data']['chargeable_dimension'] ?? '0.00'}}
  </td>
</tr>