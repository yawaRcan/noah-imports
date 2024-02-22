<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use App\Events\WalletEvent;
use App\Models\EmailTemplate;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\ApproveTransactionNotification;
use App\Notifications\RejectTransactionNotification;

class WalletController extends Controller
{
    public function index()
    {
        $config = '';
        return view('admin.wallet.index', ['status' => $config]);
    }

    public function approve(Request $request)
    {
        $wallet = Wallet::findOrFail($request->wallet_id);
        $wallet->status = 'approved';
        $wallet->reason = 'Payment Approved';
        $wallet->save();

        $user = $wallet->morphable;
        $template = EmailTemplate::where('slug', 'approve-transaction')->first();

        if ($template) {

            $shortCodes = [
                    'amount' => $wallet->currency->sybmol.''.$wallet->amount,
                    'converted_amount' =>  $wallet->amount_converted,
                    'invoice_url' => route('wallet.getPaymentHtml', ['id' => $wallet->id]),
                    'balance' => $user->balance(),
                ];

            event(new WalletEvent($template , $shortCodes, $wallet, $user, 'ApproveTransaction'));

        } else {
            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
            return $notify;
        }

        $html = view('admin.wallet.payment_reciept_status', compact('wallet'))->render();

        $notify = [
            'success' => "Transaction approved successfully!",
            'html' => $html
        ];

        return $notify;
    }

    public function reject(Request $request)
    {
        $wallet = Wallet::findOrFail($request->wallet_id);
        if($request->reason){
            $wallet->status = 'rejected';
            $wallet->reason = $request->reason;
            $wallet->save();

            $user = $wallet->morphable;
            $template = EmailTemplate::where('slug', 'reject-transaction')->first();

            if ($template) {
                
                $shortCodes = [
                    'amount' => $wallet->currency->sybmol.''.$wallet->amount,
                    'converted_amount' =>  $wallet->amount_converted,
                    'reason' =>  $wallet->reason,
                    'invoice_url' => route('wallet.getPaymentHtml', ['id' => $wallet->id]),
                    'balance' => $user->balance(),
                ];

                event(new WalletEvent($template , $shortCodes, $wallet, $user, 'RejectTransaction'));
            } else {
                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];
                return $notify;
            }

            $notify = ['success' => "Transaction rejected successfully!"];
        }
        else{
            $notify = ['error' => "Add reason for rejection"];
        }
        
        return $notify;
    }

    public function getPaymentHtml($id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('admin.wallet.payment', ['wallet' => $wallet]);
    }

    public function getPaymentReceiptStatus($id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('admin.wallet.payment_reciept_status', ['wallet' => $wallet]);
    }

    public function data(Request $request)
    {
        if (isset($request->status) && $request->status != '' && $request->status != null) {
            $data = Wallet::whereHasMorph('morphable', [User::class])->where('status',$request->status)->get();
        } else {
             $data = Wallet::whereHasMorph('morphable', [User::class])->get();
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown dropstart">
                        <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">';
                if ($row->status == 'pending'){
                    $actionBtn.= '
                            <li><a class="dropdown-item approve-wallet" href="#" data-wallet-id=' . $row->id . '>Approve</a></li>
                            <li><a class="dropdown-item reject-wallet" href="#" data-wallet-id=' . $row->id . '>Reject</a></li>';
                }
                if ($row->status == 'approved'){
                    $actionBtn.= '<li><a class="dropdown-item show-receipt-status" href="javascript:void(0)" data-wallet-id="' . $row->id . '">Payment Status</a></li>';
                }

                $actionBtn.= '</ul>
                    </div>';
                
                return $actionBtn;
            })
            ->addColumn('status', function ($row) {

                if ($row->status == 'pending')
                    $html = '<span class="mb-1 badge bg-warning">Pending</span>';
                elseif($row->status == 'approved')
                    $html = '<span class="mb-1 badge bg-success">Approved</span>';
                elseif($row->status == 'rejected')
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-danger show_reason" data-reason="' . $row->reason . '" title="Click to View Reason">Rejected</span></a>';
                else
                    $html = '<span class="mb-1">N/A</span>';

                return $html;
            })
            ->addColumn('payment_reciept', function ($row) {
                if (isset($row->payment_receipt)) {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-success ni-payment-show-modal" data-wallet-id="' . $row->id . '" title="Click to View Receipt">View Receipt</span></a>';
                } else {
                    $html = '<a href="javascript:void(0)"><span class="mb-1 badge bg-danger">N/A</span></a>';
                }
                return $html;
            })
            ->addColumn('created_at', function ($row) {
                return (isset($row->created_at) ? $row->created_at->format('F j, Y h:i A') : 'N/A');
            })
            ->addColumn('payment_method', function ($row) {
                return (isset($row->payment_id) ? $row->payment->name : 'N/A');
            })
            ->addColumn('amount', function ($row) {

                return (isset($row->currency) ? $row->currency->symbol.' '.$row->amount : $row->amount);
            })
            ->addColumn('total_converted', function ($row) {
                 return 'ƒ '.$row->amount_converted.' ANG&nbsp;<img src="'.asset("assets/icons/" . $row->payment->icon).'" width="30px" />';
            })
            ->addColumn('user', function ($row) {
                if(isset($row->morphable))
                    $fullname = $row->morphable->first_name.' '.$row->morphable->last_name;
                else
                    $fullname = 'N/A';

                return $fullname;
            })
            ->rawColumns(['action', 'status', 'created_at','payment_reciept','user','payment_method','total_converted','amount'])
            ->make(true);
    }
}
