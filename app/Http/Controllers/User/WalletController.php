<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Payment;
use App\Models\Currency;
use Auth;
use App\Events\WalletEvent;
use App\Models\EmailTemplate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\Deposit\StoreDepositRequest;
use App\Http\Requests\User\WithDraw\StoreWithDrawRequest;
use App\Notifications\DepositRequestNotification;

class WalletController extends Controller
{
    public function index()
    {
        $config = '';
        $user = Auth::user();
        $paymentMethods = Payment::where('slug', 'not like', "%account-funds%")->where('status','active')->pluck('name','id')->toArray();
        return view('user.wallet.index', ['status' => $config, 'user' => $user,'paymentMethods' => $paymentMethods]);
    }

    public function edit(string $id)
    {
       
        $wallet = Wallet::findOrFail($id);
        $currencies=Currency::all();
        $paymentMethods = Payment::where('slug', 'not like', "%account-funds%")->where('status','active')->pluck('name','id')->toArray();
    
        return view('user.wallet.edit', ['wallet' => $wallet,'currencies'=>$currencies,'paymentMethods'=> $paymentMethods]);
    } 


    public function updateWallet(Request $request, string $id)
    {
        
        $currency = Currency::findOrFail($request->currency);
        if (isset($request->payment_receipt)) {
            $wallet->payment_receipt = $this->fileUpload($request->payment_receipt);
        }
        $totalConverted = trim($request->deposit_amount) * $currency->value;
        $wallet = Wallet::findOrFail($id);
        $wallet->currency_id =  $request->currency;
        $wallet->payment_id =  $request->payment_method;
        $wallet->amount =  $request->deposit_amount;
        $wallet->description = $request->deposit_desc;
        $wallet->amount_converted = $totalConverted;
        $wallet->save();
        $notify = ['success' => "User has been updated."];
        return $notify;
    }
    public function storeDeposit(StoreDepositRequest $request)
    {
     
         $user = Auth::user();
         $currency = Currency::findOrFail($request->currency);
         $totalConverted = trim($request->deposit_amount) * $currency->value;

         $wallet = new Wallet();
         if (isset($request->payment_receipt)) {
            $wallet->payment_receipt = $this->fileUpload($request->payment_receipt);
         }
         $wallet->type = 'credit';
         $wallet->amount = $request->deposit_amount;
         $wallet->payment_id = $request->payment_method;
         $wallet->currency_id = $request->currency;
         $wallet->description = $request->deposit_desc;
         $wallet->amount_converted = $totalConverted;
         $wallet->morphable()->associate($user);
         $wallet->save();

         $template = EmailTemplate::where('slug', 'wallet-deposit')->first();
       


        if ($template) {
          
            $amount = $wallet->currency->sybmol.''.$wallet->amount;
            $shortCodes = [
                    'payment_method' => $wallet->payment->name,
                    'amount' => $amount,
                    'converted_amount' =>  $wallet->amount_converted,
                    'invoice_url' => route('user.wallet.getPaymentHtml', ['id' => $wallet->id]),
                    'balance' => $user->balance(),
                ];

            event(new WalletEvent($template , $shortCodes, $wallet, $user, 'Deposit'));

        } else {
            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
            return $notify;
        }

         $notify = ['success' => "Deposit request created! Wait for Admin approval"];
         return $notify;
    }

    public function storeWithDraw(StoreWithDrawRequest $request)
    {
         $user = Auth::user();
         if(!$user->allowWithdraw($request->withdraw_amount)) {
            $notify = ['error' => "Your Account Balance is not enough!"];
            return $notify;
         }
         $wallet = new Wallet();
         $wallet->type = 'debit';
         $wallet->amount = $request->withdraw_amount;
         $wallet->description = $request->withdraw_desc;
         $wallet->status = 'approved';
         $wallet->morphable()->associate($user);
         $wallet->save();

         $notify = ['success' => "Amount Debited Successfully!"];
         return $notify;
    }

    public function getPaymentHtml($id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('user.wallet.payment', ['wallet' => $wallet]);
    }

    public function getPaymentReceiptStatus($id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('user.wallet.payment_reciept_status', ['wallet' => $wallet]);
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {
            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {
                // return Reply::error('This file format not allowed');
            }
            if (Storage::exists('assets/wallet/' . $oldFile)) {
                Storage::Delete('assets/wallet/' . $oldFile);
                $file->storeAs('assets/wallet/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/wallet/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
    }

    public function deleteWallet($id){

        Wallet::findOrFail($id)->delete();
        $notify = ['success' => "wallet has been deleted."];

        return $notify;
    }
    public function data(Request $request)
    {
        $user = Auth::user();
        if(isset($request->user_id) && $request->user_id != '' && $request->user_id != null){
            $data = Wallet::where('morphable_id',$request->user_id)->get();  
        }
        if (isset($request->status) && $request->status != '' && $request->status != null) {
            $data = $user->filterTransactions($request->status);
        } else {
             $data = $user->transactions;
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
             
                if($row->status != "approved"){
            
                $actionBtn .= '<li><a class="dropdown-item wallet-data-edit" href="javascript:void(0)" data-wallet-id="' . $row->id . '">Edit</a></li>
                <li><a class="dropdown-item wallet-data-delete" href="javascript:void(0)" data-wallet-id="' . $row->id . '">Delete</a></li>
                ';
                }

                

                if($row->status == "approved"){
                    $actionBtn .= '<li><a class="dropdown-item show-receipt-status " href="javascript:void(0)" data-wallet-id="' . $row->id . '">Payment Status</a></li>';
                }
                $actionBtn .= '</ul></div>';
               
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
            ->rawColumns(['action', 'status', 'created_at','payment_reciept','payment_method','total_converted','amount'])
            ->make(true);
    }
}
