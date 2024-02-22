 <td>{{$parcel->item_value ?? 'N/A'}}</td>
 <td>{{$parcel->amount_total ?? 'N/A'}}</td>
 <td>{{$parcel->quantity ?? 'N/A'}}</td>
 <td>{{$parcel->product_description ?? 'N/A'}}</td>
 <td>{{$parcel->duty->name ?? 'N/A'}} ({{$parcel->duty->value ?? '0'}}%)</td>
 <td>{{$parcel->weight ?? 'N/A'}}</td>
 <td>{{$parcel->length ?? 'N/A'}}</td>
 <td>{{$parcel->width ?? 'N/A'}}</td>
 <td>{{$parcel->height ?? 'N/A'}}</td>
 <td>
     <a class="justify-content-center cursor-pointer text-success font-weight-medium align-items-center ni-edit-item" data-parcel-id="{{$parcel->id}}" style="font-size:15px">
         <i class="me-2 mdi mdi-table-edit"></i>
     </a>
     <a class="justify-content-center cursor-pointer text-danger font-weight-medium align-items-center  ni-remove-item" data-parcel-id="{{$parcel->id}}">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 feather-sm fill-white">
             <polyline points="3 6 5 6 21 6"></polyline>
             <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
             <line x1="10" y1="11" x2="10" y2="17"></line>
             <line x1="14" y1="11" x2="14" y2="17"></line>
         </svg>
     </a>
 </td>