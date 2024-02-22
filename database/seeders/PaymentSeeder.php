<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys = [
            ['name' => 'Bank Transfer', 'icon' => 'bank-transfer.gif', 'slug' => 'bank-transfer','information' => '<p><u>Bank Transfer Info</u></p><p><strong><u>Demo Bank Payment Information from database</u></strong></p><p><strong>Bank Name:</strong> Chase Bank</p><p><strong>Iban Number:</strong> IBNXXXXXXDEMO</p><p><strong>Account Number:</strong> 090290XXXXX&nbsp;&nbsp;</p><p><strong>Sincerely,</strong></p><p>Noah Imports Courier Team</p>'],
            ['name' => 'Debit Card', 'icon' => 'credit-card.gif', 'slug' => 'debit-card','information' => '<p><strong><u>Debit Card Info</u></strong></p><p><u>Demo Bank Payment Information from database</u></p><p>Bank Name: Chase Bank</p><p>Iban Number: IBNXXXXXXDEMO</p><p>Account Number: 090290XXXXX&nbsp;&nbsp;&nbsp;&nbsp;</p><p>Sincerely,</p><p>Noah Imports Courier Team</p>'],
            ['name' => 'Paypal', 'icon' => 'paypal.gif', 'slug' => 'paypal','information' => '<p><u>Paypal Info</u></p><p><u>Demo Bank Payment Information from database</u></p><p>Bank Name: Chase Bank</p><p>Iban Number: IBNXXXXXXDEMO</p><p>Account Number: 090290XXXXX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p>Sincerely,</p><p>Noah Imports Courier Team</p>'],
            ['name' => 'Account Funds', 'icon' => 'account-transfer.gif', 'slug' => 'account-funds','information' => '<p><u>Account Info</u></p><p>Wallet Balance: $0</p><p>Sincerely,</p><p>Noah Imports Courier Team</p>'],
        ];

        $count = Payment::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = Payment::create($arr);
            }
        }
    }
}
