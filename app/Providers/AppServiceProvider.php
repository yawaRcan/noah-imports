<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Currency;
use App\Models\TimeZone;
use App\Models\Parcel;
use App\Models\Order;
use App\Models\ImportDuty;
use App\Models\SubCategory;
use App\Models\ConfigStatus;
use App\Models\ShipmentMode;
use App\Models\ShipmentType;
use App\Models\ExternalShipper;
use App\Models\PaymentStatus;
use App\Models\PurchaseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Channels\DatabaseChannel;
use App\Services\DatabaseChannel as NewDatabaseChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DatabaseChannel::class, NewDatabaseChannel::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            $countries = Country::pluck('name','id')->toArray();
            $timezones = TimeZone::pluck('name','id')->toArray(); 
            $currencies = Currency::select('id','name','symbol')->get();
            $branches = Branch::pluck('name','id')->toArray();
            $externalShipper = ExternalShipper::select('name','id','icon')->get(); 
            $shipmentTypes = ShipmentType::pluck('name','id')->toArray();
            $shipmentMode = ShipmentMode::pluck('name','id')->toArray();
            $importDuties = ImportDuty::pluck('name','id')->toArray();
            $payments = Payment::where('status','active')->pluck('name','id')->toArray();
            $paymentStatus = PaymentStatus::get();
            $purchaseCategories = PurchaseCategory::pluck('title','id')->toArray();
            $categories = Category::pluck('title','id')->toArray();
            $countryCodes = Country::pluck('code','id')->toArray();
            $subCategories = SubCategory::pluck('title','id')->toArray();
            $brands = Brand::pluck('title','id')->toArray();
            $parcelStatus = ConfigStatus::select('name','id','value','color')->whereIn('slug', ['processing','at-warehouse-miami', 'in-transit', 'in-transit-to-be-delivered', 'delivered'])->orderBy('id','ASC')->get(); 
            $settings = Setting::first();

            if(Auth::guard('web')->user()){
                $cm_paid_parcels_amount  = Parcel::where('user_id',Auth::guard('web')->user()->id)->whereMonth('created_at', date('m'))->where('payment_status_id',2)->sum('amount_total');
                $lm_paid_parcels_amount  = Parcel::where('user_id',Auth::guard('web')->user()->id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month
                )->where('payment_status_id',2)->sum('amount_total');
            }
            else{
                $cm_paid_parcels_amount  = Parcel::whereMonth('created_at', date('m'))->where('payment_status_id',2)->sum('amount_total');
                $lm_paid_parcels_amount  = Parcel::whereMonth('created_at', '=', Carbon::now()->subMonth()->month
                )->where('payment_status_id',2)->sum('amount_total');
            }
            
            $view->with(compact('purchaseCategories','brands','subCategories','categories','countries','branches','timezones','externalShipper','shipmentTypes','shipmentMode','importDuties','parcelStatus','payments','currencies','settings','paymentStatus','cm_paid_parcels_amount','lm_paid_parcels_amount','countryCodes'));
        });
    }
}
