<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $set = Setting::select('id')->get();
        if(count($set) == 0){ 
            $setting = new Setting(); 
            $setting->configuration = (object)array("site_name"=>"Noah Imports","store_name"=>"STORE NAME","site_title"=>"SITE TITLE","site_description"=>"SITE DESCRIPTION","file_size"=>"FILE UPLOAD SIZE (MB) MAX=>15MB","default_currency"=>"DEFAULT CURRENCY","default_lang"=>"EFAULT LANGUAGE","site_status"=>"on","email_validation"=>"on","water_photo"=>"on","email_notification"=>"off","online_shop"=>"off","sub_icon"=>"off");
            $setting->company = (object)array("logo"=>"logo.png","favicon"=>"favicon.png","watermark"=>"watermark.png","invoice"=>"invoice.png","water_photo"=>"invoice.png","online_shop"=>"online_shop.png");
            $setting->freight = (object)array("air_clearance_charges"=>5,"sea_insurance"=>7.50,"sea_shipping_price"=>15.007,"sea_clearance_charges"=>35,"sea_ob_percent"=>46.35);
            // $setting->smtp = (object)array("mail_driver"=>"smtp","host"=>"sandbox.smtp.mailtrap.io","port"=>"2525","mail_encryption"=>"tls","username"=>"a91c2b75df5ced","email"=>"noah@gmail.com","password"=>"5ecd729f6a27a3");
            $setting->smtp = (object)array("mail_driver"=>"mail","host"=>"mail.trustechsol.co","port"=>"587","mail_encryption"=>"tls","username"=>"noahimport@trustechsol.co","email"=>"noah@gmail.com","password"=>"*E3h34,@vOW*");

            $setting->aftership = (object)array("aftership_api"=>"asat_d96cd8aa29c040c6bdab8d5e0e2bfdac","status"=>"off");
            $setting->setting = (object)array("waybil_no"=>"AWB-00","invoice_no"=>"INV-00","customer_no"=>"CN-00","referal_no"=>"Referal@eerw","online_shop_invoice_address"=>"Online Shop Invoice Address","user_page_view"=>"User Page View","admin_page_view"=>"Admin Page View","invoice_disclaimer"=>"Invoice Disclaimer","registration_disclaimer"=>"Registration Disclaimer","calculator_disclaimer"=>"Calculator Disclaimer","shop_order_disclaimer"=>"Shop Order Disclaimer","site_maintenance_disclaimer"=>"Site Maintenance");
            $setting->save();
        }

     }
}
