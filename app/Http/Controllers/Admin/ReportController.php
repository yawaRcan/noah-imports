<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Parcel;
use App\Models\Consolidate;
use App\Models\Purchase;
use App\Exports\AllOrdersExport;
use App\Exports\PendingOrdersExport;
use App\Exports\PaidOrdersExport;
use App\Exports\UnpaidOrdersExport;
use App\Exports\AllParcelsExport;
use App\Exports\PendingParcelsExport;
use App\Exports\PaidParcelsExport;
use App\Exports\UnpaidParcelsExport;
use App\Exports\AllConsolidatesExport;
use App\Exports\PendingConsolidatesExport;
use App\Exports\PaidConsolidatesExport;
use App\Exports\UnpaidConsolidatesExport;
use App\Exports\PaymentRecieveExport;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ReportController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        return view('admin.reports.index');
    }

    // Orders report functions
    public function allOrders(Request $request)
    {
        $query = Order::
                with('courierDetail','shipperAddress','payment','paymentStatus','currency')
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new AllOrdersExport($query))
            ->download('all-order-detail-report-'.time().'.xlsx');
        }

        $orders = $query->paginate(10);

        return view('admin.reports.orders.list',compact('orders'));
    }

    public function pendingOrders(Request $request)
    {
        $query = Order::
                with('courierDetail','shipperAddress','payment','paymentStatus','currency')
                ->where('status',0)
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new PendingOrdersExport($query))
            ->download('pending-order-detail-report-'.time().'.xlsx');
        }

        $orders = $query->paginate(10);

        return view('admin.reports.orders.pending',compact('orders'));
    }

    public function paidOrders(Request $request)
    {
        $query = Order::
                with('courierDetail','shipperAddress','payment','currency')
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'paid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new PaidOrdersExport($query))
            ->download('paid-order-detail-report-'.time().'.xlsx');
        }

        $orders = $query->paginate(10);

        return view('admin.reports.orders.paid',compact('orders'));
    }

    public function unpaidOrders(Request $request)
    {
        $query = Order::
                with('courierDetail','shipperAddress','payment','currency')
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'unpaid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new UnpaidOrdersExport($query))
            ->download('unpaid-order-detail-report-'.time().'.xlsx');
        }

        $orders = $query->paginate(10);

        return view('admin.reports.orders.unpaid',compact('orders'));
    }

    // Parcels report functions

    public function allParcels(Request $request)
    {
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $query = Parcel::with('sender','reciever','payment','paymentStatus','toCountry','parcelStatus')
                ->whereNull('drafted_at')
                ->whereNotIn('id', $ids)
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new AllParcelsExport($query))
            ->download('all-parcel-detail-report-'.time().'.xlsx');
        }

        $parcels = $query->paginate(10);

        return view('admin.reports.parcels.list',compact('parcels'));
    }

    public function pendingParcels(Request $request)
    {
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $query = Parcel::with('sender','reciever','payment','paymentStatus','toCountry')
                ->whereHas('parcelStatus', function ($query) {
                    $query->where('id', 1);
                })
                ->whereNull('drafted_at')
                ->whereNotIn('id', $ids)
                ->orderBy('id','DESC');



        if ($request->get('export')) {
            return (new PendingParcelsExport($query))
            ->download('pending-parcel-detail-report-'.time().'.xlsx');
        }

        $parcels = $query->paginate(10);

        return view('admin.reports.parcels.pending',compact('parcels'));
    }

    public function paidParcels(Request $request)
    {
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $query = Parcel::with('sender','reciever','payment','parcelStatus','toCountry')
                ->whereNull('drafted_at')
                ->whereNotIn('id', $ids)
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'paid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new PaidParcelsExport($query))
            ->download('paid-parcel-detail-report-'.time().'.xlsx');
        }

        $parcels = $query->paginate(10);

        return view('admin.reports.parcels.paid',compact('parcels'));
    }

    public function unpaidParcels(Request $request)
    {
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $query = Parcel::with('sender','reciever','payment','parcelStatus','toCountry')
                ->whereNull('drafted_at')
                ->whereNotIn('id', $ids)
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'unpaid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new UnpaidParcelsExport($query))
            ->download('unpaid-parcel-detail-report-'.time().'.xlsx');
        }

        $parcels = $query->paginate(10);

        return view('admin.reports.parcels.unpaid',compact('parcels'));
    }


    // Consolidates report functions

    public function allConsolidates(Request $request)
    {
        $query = Consolidate::with('sender','reciever','payment','paymentStatus','toCountry','parcelStatus')
                ->whereNull('drafted_at')
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new AllConsolidatesExport($query))
            ->download('all-consolidate-detail-report-'.time().'.xlsx');
        }

        $consolidates = $query->paginate(10);

        return view('admin.reports.consolidate.list',compact('consolidates'));
    }

    public function pendingConsolidates(Request $request)
    {
        $query = Consolidate::with('sender','reciever','payment','paymentStatus','toCountry')
                ->whereHas('parcelStatus', function ($query) {
                    $query->where('id', 1);
                })
                ->whereNull('drafted_at')
                ->orderBy('id','DESC');



        if ($request->get('export')) {
            return (new PendingConsolidatesExport($query))
            ->download('pending-consolidate-detail-report-'.time().'.xlsx');
        }

        $consolidates = $query->paginate(10);

        return view('admin.reports.consolidate.pending',compact('consolidates'));
    }

    public function paidConsolidates(Request $request)
    {
        $query = Consolidate::with('sender','reciever','payment','parcelStatus','toCountry')
                ->whereNull('drafted_at')
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'paid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new PaidConsolidatesExport($query))
            ->download('paid-consolidate-detail-report-'.time().'.xlsx');
        }

        $consolidates = $query->paginate(10);

        return view('admin.reports.consolidate.paid',compact('consolidates'));
    }

    public function unpaidConsolidates(Request $request)
    {
        $query = Consolidate::with('sender','reciever','payment','parcelStatus','toCountry')
                ->whereNull('drafted_at')
                ->whereHas('paymentStatus', function ($query) {
                    $query->where('slug', 'unpaid');
                })
                ->orderBy('id','DESC');

        if ($request->get('export')) {
            return (new UnpaidConsolidatesExport($query))
            ->download('unpaid-consolidate-detail-report-'.time().'.xlsx');
        }

        $consolidates = $query->paginate(10);

        return view('admin.reports.consolidate.unpaid',compact('consolidates'));
    }

    // Backup functions
    public function databaseBackup()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');


        $backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        // $mysqlPath = "D:\\wamp64\\bin\\mysql\\mysql8.0.27\\bin\\mysqldump";
       

        $command = "mysqldump --user={$username} --password={$password} --host=localhost {$database}";

        exec($command);

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $backupFileName . '"',
        ];

        return response()->streamDownload(function () use ($command) {
            passthru($command);
        }, $backupFileName, $headers);
    }

    public function removeUnusedFiles()
    {
        $files = Storage::allFiles();

        // ignoring company logo files and gitignore file
        foreach ($files as $key => $file) {
            if (strpos($file, '/company/') !== false || strpos($file, 'gitignore') !== false) {
                unset($files[$key]);
            }
        }

        foreach ($files as $file) {

            if (!$this->isFileReferenced($file)) {
                Storage::delete($file);
            }
        }

        $notify[] = ['success', "Data cleaned successfully"];
        return redirect()->back()->withNotify($notify);
    }

    public function isFileReferenced($file)
    {
        $filename = basename($file);
        $referenced = false;

        $tables = [
             'admins' => 'image',
             'users' => 'image',
             'consolidate_images' => 'hash_name',
             'parcel_images' => 'hash_name',
             'consolidates' => 'payment_receipt',
             'orders' => 'payment_receipt',
             'parcels' => 'payment_receipt',
             'wallets' => 'payment_receipt',
         ];

        foreach ($tables as $table => $column) {
            $count = DB::table($table)->where($column, $filename)->count();
            if ($count > 0) {
                $referenced = true;
                break;
            }
        }

        return $referenced;
    }

    public function siteBackup()
    {
        // Create a new ZipArchive instance
        $zip = new ZipArchive();

        // Create a temporary file path for the backup
        $tempPath = storage_path('app/public/temp');

        // Generate a unique backup filename based on the current timestamp
        $backupFileName = 'backup_' . date('Y-m-d_His') . '.zip';

        // Open the temporary zip file for writing
        if ($zip->open($tempPath . '/' . $backupFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Get the base path of the Laravel application
            $basePath = base_path();


            // Add all files and directories to the zip archive
            $this->addFilesToZip($basePath, $basePath, $zip);

            // Close the zip archive
            $zip->close();

            // Set the appropriate headers for file download
            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $backupFileName . '"',
            ];

            // Create a Symfony Response with the backup file contents
            $response = new Response(file_get_contents($tempPath . '/' . $backupFileName), 200, $headers);

            // Delete the temporary backup file
            unlink($tempPath . '/' . $backupFileName);

            // Return the response for the user to download the backup file
            return $response;
        } else {
            // Failed to create the zip archive
            return false;
        }
    }

    public function addFilesToZip($basePath, $currentPath, $zip)
    {
        $files = glob($currentPath . '/*');

        foreach ($files as $file) {
            if (is_dir($file)) {

                $directoryName = basename($file);
                // Skip the vendor folder
                if ($directoryName === 'vendor') {
                    continue;
                }

                // Add the directory to the zip archive
                $zip->addEmptyDir(str_replace($basePath . '/', '', $file));

                // Recursively add files and directories inside the directory
                $this->addFilesToZip($basePath, $file, $zip);
            } else {
                // Add the file to the zip archive
                $zip->addFile($file, str_replace($basePath . '/', '', $file));
            }
        }
    }

    public function recievePayment(Request $request)
    {
        $query = Parcel::with('user','payment')
            ->select('es_delivery_date','external_tracking','amount_total')
            ->whereHas('paymentStatus', function ($query) {
                $query->where('slug', 'paid');
            })
            ->orderBy('id','DESC');


        if ($request->get('export')) {
            return (new PaymentRecieveExport($query))
            ->download('payment-revieved-report-'.time().'.xlsx');
        }

        $usersAmount = $query->paginate(10);

        return view('admin.reports.payment-recieve.paid-payments',compact('usersAmount'));
    }



}
