<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Parcel;
use App\Models\Wallet;
use GuzzleHttp\Client;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\OrderPayment;
use App\Events\OrderEvent;
use App\Events\ParcelEvent;
use App\Models\ConfigStatus;
use App\Models\PurchaseCart;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\PaymentStatus;
use App\Models\ShippingAddress;
use App\Traits\CartCalculation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Notifications\OrderNotification;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\DomCrawler\Crawler;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use App\Notifications\ShipmentCreateNotification;
use App\Http\Requests\Admin\Purchase\StoreRequest;
use App\Http\Requests\Admin\Purchase\UpdateRequest;
use App\Http\Requests\Admin\PurchaseOrder\StoreOrderRequest;
use App\Http\Requests\Admin\PurchaseOrder\UpdateOrderRequest;
use App\Http\Requests\Admin\OrderPayment\UpdatePaymentRequest;
use App\Http\Requests\Admin\OrderPaymentCharge\StoreChargeRequest;
use App\Http\Requests\Admin\OrderPaymentCharge\UpdateChargeRequest;
use App\Models\Currency;

class OrderController extends Controller
{

    use CartCalculation;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderAmountDue = 0;
        $status = 'order';
        $orders = Order::where('balance_due', '>', 0)->get();
        foreach ($orders as $order) {
            $orderAmountDue += str_replace(',', '', number_format($order->balance_due * $order->currency->value, 2));
        }
        $title = 'All Orders';
        return view('admin.purchasing.index', compact('orderAmountDue', 'status', 'title'));
    }


    public function scrapeProductImages($url)
    {

        $client = new Client(['verify' => false]);

        $response = $client->get($url, [
            'headers' => [
                'X-RapidAPI-Host' => 'crawler2.p.rapidapi.com',
                'X-RapidAPI-Key' => 'c28a8bd246msh6aae92b9c2a4b85p123a1fjsn1f581b012c9e',
            ],
        ]);

        $check = $response->getStatusCode();

        if ($check == 200) {

            // Get the HTML content from the response
            $htmlContent = $response->getBody()->getContents();
            // dd($htmlContent);
            // Create  new DOM Crawler instance
            $crawler = new Crawler($htmlContent);
            // dd($crawler);
            $imageUrls = array();

            $parts = parse_url($url);

            if (isset($parts['scheme']) && isset($parts['host'])) {

                $mainLink = $parts['scheme'] . "://" . $parts['host'];

            } else {

                return [];
            }

            $matchScores = array();

            similar_text($mainLink, 'https://www.ebay.com', $ebayScore);

            similar_text($mainLink, 'https://www.amazon.com', $amazonScore);

            similar_text($mainLink, 'https://www.walmart.com', $walmartScore);

            similar_text($mainLink, 'https://www.alibaba.com', $alibabaScore);

            similar_text($mainLink, 'https://sale.alibaba.com/', $alibabasaleScore);

            similar_text($mainLink, $mainLink, $normalScore);


            $matchScores['ebayStr'] = $ebayScore;

            $matchScores['amazonStr'] = $amazonScore;

            $matchScores['walmartStr'] = $walmartScore;

            $matchScores['alibabaStr'] = $alibabaScore;

            $matchScores['alibabasaleStr'] = $alibabasaleScore;

            $matchScores['normalStr'] = $normalScore;

            arsort($matchScores); // Sort the match scores in descending order

            $mostMatchedString = key($matchScores); // Get the key (string) with the highest match score

            if ($mostMatchedString === 'ebayStr') {

                $imageUrls = $this->extractEbay($url);
            } elseif ($mostMatchedString === 'amazonStr') {

                $imageUrls = $this->extractAmazon($url);

            } elseif ($mostMatchedString === 'walmartStr') {

                $imageUrls = $this->extractWalMart($url);
            } elseif ($mostMatchedString === 'alibabaStr') {

                $imageUrls = $this->extractAliBaba($url);
            } elseif ($mostMatchedString === 'alibabasaleStr') {

                $imageUrls = $this->extractAliBabaSale($url);
            } elseif ($mostMatchedString === 'normalStr') {

                if (!$imageUrls) {

                    $imageUrls = $this->extractfigure($url);

                    if (!$imageUrls) {

                        $imageUrls = $this->extractList($url);

                        if (!$imageUrls) {

                            $imageUrls = $this->extractDivImg($url);

                            if (!$imageUrls) {

                                $imageUrls = $this->extractOG($url);

                                if (!$imageUrls) {

                                    $imageUrls = $this->extractAS($url);

                                    if (!$imageUrls) {

                                        $imageUrls = [];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

                return [];
            }

            return $imageUrls;
        }


    }

    function extractOG($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $imageUrls['title'] = 'Default';
        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('meta[property="og:image"]');

        $imageUrls = [];
        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrl = $element->attr('content');

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    function extractAS($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $imageUrls['title'] = 'Default';
        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('link[as="image"]');

        $imageUrls = [];
        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrl = $element->attr('href');

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    function extractList($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $imageUrls['title'] = 'Default';
        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('li a img');

        $imageUrls = [];
        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrl = $element->attr('data-original');

            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            } else {

                $imageUrl = $element->attr('data-src');

                if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                } else {
                    $imageUrl = $element->attr('src');
                }
            }

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    function extractfigure($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $imageUrls['title'] = 'Default';
        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('figure img');
        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrl = $element->attr('data-original');

            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            } else {

                $imageUrl = $element->attr('data-src');

                if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                } else {
                    $imageUrl = $element->attr('src');
                }
            }

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    public function approve(Request $request)
    {

        $order = Order::findOrFail($request->order_id);
        $order->status = 3;
        $order->save();

        $notify = [
            'success' => "Order  approved successfully!",
        ];
        return $notify;
    }

    public function reject(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->status = 4;
        // $order->reason = $request->reason;
        $order->save();
        $notify = [
            'success' => "Orders  reject successfully!",
        ];
        return $notify;
    }

    function extractDivImg($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $imageUrls['title'] = 'Default';
        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('div img');

        $imageUrls = [];
        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrl = $element->attr('srcset');

            $links = explode(",", $imageUrl);

            foreach ($links as $link) {

                if ($link != "" && $link != null) {

                    $links = explode(" ", $link);

                    if ($links[0] != "" && $links[0] != null) {

                        $imageUrls['images'][] = $links[0];
                    }
                }
            }
        });

        return $imageUrls;
    }

    function extractEbay($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('.x-item-title h1 span')->first();

        // $shipPrice = $crawler->filter('.ux-labels-values--shipping .col-9 .ux-labels-values__values-content span');

        // $shipPrice->each(function (Crawler $element) use (&$imageUrls) {

        //     $imageUrls['shipment_price'][] = $element->text();
        // });

        $itemNumber = $crawler->filter('.ux-layout-section__textual-display--itemId span');

        $itemNumber->each(function (Crawler $element) use (&$imageUrls) {

            $imageUrls['item_number'][] = $element->text();
        });

        if (!empty($imageUrls['item_number'])) {
            $imageUrls['item_number'] = $imageUrls['item_number'][1];
        } else {
            $imageUrls['item_number'] = 0;
        }


        $imageUrls['title'] = $title->text();

        $price = $crawler->filter('.x-price-primary .ux-textspans')->first();
        $string = "US $349.00";
        $pattern = '/\d+(\.\d+)?/';  // Regular expression pattern to match the price 
        preg_match($pattern, $price->text(), $matches);
        if (!empty($matches)) {
            $price = $matches[0];
            $imageUrls['price'] = $price;  // Output: 349.00
        } else {
            $imageUrls['price'] = 0;
        }


        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('.ux-image-filmstrip-carousel-item');

        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            $element = $element->filter('img');
            $imageUrl = $element->attr('src');

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    function extractAliBaba($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;
        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('.product-title-container h1')->first();
        $imageUrls['title'] = $title->text();

        $price = $crawler->filter('.product-price .price-list .price-item span')->first();
        $pattern = '/\d+(\.\d+)?/';  // Regular expression pattern to match the price 
        preg_match($pattern, $price->text(), $matches);
        $imageUrls['price'] = $price->text();
        // if (!empty($matches)) {
        //     $price = $matches[0];
        //     $imageUrls['price'] = $price;  // Output: 349.00
        // } else {
        //     $imageUrls['price'] = 0;
        // }


        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('.detail-product-image .image-list .image-list-slider .main-item img ');

        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {


            $imageUrl = $element->attr('src');

            $imageUrls['images'][] = $imageUrl;
        });
        return $imageUrls;
    }

    function extractAliBabaSale($url)
    {
        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('.product-title h1')->first();

        $imageUrls['title'] = $title->text();

        // Use CSS selectors to find the product image elements
        $imageElements = $crawler->filter('.detail-next-slick-slide img');

        // Extract the image URLs
        $imageElements->each(function (Crawler $element) use (&$imageUrls) {


            $imageUrl = $element->attr('src');

            $imageUrls['images'][] = $imageUrl;
        });

        return $imageUrls;
    }

    function extractAmazon($url)
    {

        $client = new \Goutte\Client();

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('#productTitle')->first();
        $imageUrls['title'] = $title->text();

        $imageElements = $crawler->filter('span span span img');

        $imageElements->each(function (Crawler $element) use (&$imageUrls) {

            // $element = $element->filter('img');
            $imageUrl = $element->attr('src');

            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

            if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                $imageUrls['images'][] = $imageUrl;
            }
        });

        return $imageUrls;
    }

    function extractWalMart($url)
    {
        // Create a custom HttpClient instance with the desired headers
        $httpClient = HttpClient::create([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
            ],
        ]);

        $client = new HttpBrowser($httpClient);

        // $client = new  \Goutte\Client($httpClient);

        $parsedUrl = parse_url($url);

        $host = $parsedUrl['host'];

        $domainParts = explode('.', $host);

        $domain = $domainParts[count($domainParts) - 2];

        $imageUrls['website'] = $domain;

        $client->request('GET', $url);

        $crawler = $client->getResponse()->getContent();

        // $title = $crawler->filter('#productTitle');

        $imageUrls['title'] = 'WalMart';


        // $imageElements = $crawler->filter('img');

        // $imageElements->each(function (Crawler $element) use (&$imageUrls) {

        //     // $element = $element->filter('img');
        //     $imageUrl = $element->attr('src');

        //     $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

        //     if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
        //         $imageUrls['images'][] = $imageUrl;
        //     }
        // });
        // if(!isset($imageUrls['images'])){
        $imageUrls['images'][] = 'https://www.google.com/recaptcha/about/images/reCAPTCHA-logo@2x.png';
        // }

        return $imageUrls;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Session::get('user_id');

        $users = User::orderBy('first_name', 'ASC')->get();
        $paymentMethods = Payment::orderBy('name', 'ASC')->get();

        $cartData = PurchaseCart::with('purchase', 'user')->where('user_id', $userId)->get();

        if (count($cartData) > 0) {
            $this->products = Purchase::where(['user_id' => $userId, 'status' => 0])->get();

            if (isset($this->products[0]) && !is_null($this->products)) {
                $serviceFee = $this->serviceChargeFee(true);
                $cal = (object) $this->calc();
            }

            return view('admin.purchasing.create', compact('serviceFee', 'cartData', 'paymentMethods', 'users', 'userId', 'cal'));
        } else {
            return view('admin.purchasing.create', compact('paymentMethods', 'users', 'userId'));
        }
    }

    public function createCharge($id)
    {
        $order = Order::findOrFail($id);

        $wallet_credit_amount = Wallet::where('morphable_id', $order->user->id)->where('type', 'credit')->sum('amount');

        $wallet_debit_amount = Wallet::where('morphable_id', $order->user->id)->where('type', 'debit')->sum('amount');
        $total_wallet_amount = $wallet_debit_amount - $wallet_credit_amount;

        // $wallet = Wallet::where('morphable_id', $order->user->id)->where('type','debit')->sum('amount');
        $currencies = Currency::all();
        $currencyDollar = $currencies->filter(function ($curr) {
            return $curr->code == 'USD';
        });
        $currencyDollar = $currencyDollar->first()->value;


        $currenciesData = Currency::get();


        return view('admin.purchasing.ajax.charge-create', compact('order', 'currencies', 'currenciesData', 'total_wallet_amount', 'currencyDollar'));
    }

    public function storeCharge(StoreChargeRequest $request)
    {
        $order = Order::findOrFail($request->order_id);


        if ($order->balance_due == 0) {
            $notify = ['error' => "Payment already completed for this order"];
            return $notify;
        } else {



            $paidAmount = trim($request->paid_amount);
            $paymentMehod = Payment::findOrFail($request->payment_method);

            if ($paidAmount > $order->total) {
                $notify = ['error' => "Paid amount should be less than total amount!"];
                return $notify;
            }

            if ($paymentMehod->slug == "account-funds") {
                // $userBalance = $order->user->balance();
                // $totalConverted = $order->currency->value * $paidAmount;
                // $amount = (float) str_replace(',', '', $totalConverted);

                $currency = Currency::findOrFail($request->currency);
                $totalConverted = trim($request->paid_amount) * $currency->value;

                $wallet = new Wallet();

                $wallet->amount = $request->paid_amount;
                $wallet->currency_id = $request->currency;
                $wallet->payment_id = $request->payment_method;
                $wallet->type = 'credit';
                $wallet->status = 'pending';
                $wallet->amount_converted = $totalConverted;
                $wallet->morphable()->associate($order->user);
                $wallet->save();


                // if ($userBalance <= 0 || $userBalance < $amount) {
                //     $notify = ['error' => "Your Account Balance is not enough!"];
                //     return $notify;
                // }
            }

            $charge = new OrderPayment();
            $charge->order_id = $request->order_id;
            $charge->payment_id = $request->payment_method;
            if (isset($request->payment_receipt)) {
                $charge->payment_invoice = $this->fileUpload($request->payment_receipt, $charge->payment_invoice);
            }
            $charge->paid_amount = $paidAmount;
            $charge->save();

            $order->balance_due = str_replace(',', '', number_format($order->balance_due, 2)) - $charge->paid_amount;
            if ($order->balance_due == 0)
                $order->payment_status_id = 2;

            $order->save();
        }



        // if($order->balance_due == 0){
        //     $notify = ['success' => "Order payment completed successfully!", 'redirect' => route('purchasing.order.list')];
        // }
        // else{
        $table = view('admin.purchasing.ajax.order-billings', ['order' => $order])->render();

        $html = ['selector' => 'billing-tbody', 'data' => $table];
        $notify = ['success' => "New charge added successfully!", 'html' => $html];
        // }


        return $notify;

    }

    public function editCharge($id)
    {
        $charge = OrderPayment::findOrFail($id);
        return view('admin.purchasing.ajax.charge-edit', compact('charge'));
    }

    public function updateCharge(UpdateChargeRequest $request, string $id)
    {
        $charge = OrderPayment::findOrFail($id);

        $balanceDue = $charge->order->total - $charge->order->billing->where('id', '!=', $charge->id)->sum('paid_amount');

        $paidAmount = trim($request->paid_amount);
        $paymentMehod = Payment::findOrFail($request->payment_method);

        if ($paidAmount > $balanceDue) {
            $notify = ['error' => "Paid amount should be less than balance due!"];
            return $notify;
        }

        if ($paymentMehod->slug == "account-funds") {
            $userBalance = $charge->order->user->balance();
            $totalConverted = $charge->order->currency->value * $paidAmount;
            $amount = (float) str_replace(',', '', $totalConverted);

            if ($userBalance <= 0 || $userBalance < $amount) {
                $notify = ['error' => "Your Account Balance is not enough!"];
                return $notify;
            }
        }

        $charge->payment_id = $request->payment_method;
        $charge->paid_amount = $paidAmount;
        $charge->save();

        $charge->order->balance_due = number_format($balanceDue - $charge->paid_amount, 2);

        if ($charge->order->balance_due == 0)
            $charge->order->payment_status_id = 2;
        else
            $charge->order->payment_status_id = 1;

        $charge->order->save();

        $charge->order->load('billing');

        // if($order->balance_due == 0){
        //     $notify = ['success' => "Order payment completed successfully!", 'redirect' => route('purchasing.order.list')];
        // }
        // else{
        $table = view('admin.purchasing.ajax.order-billings', ['order' => $charge->order])->render();

        $html = ['selector' => 'billing-tbody', 'data' => $table];
        $notify = ['success' => "Charge updated successfully!", 'html' => $html];
        // }

        return $notify;
    }

    public function deleteCharge($id)
    {
        $charge = OrderPayment::findOrFail($id);

        $charge->order->balance_due = $charge->order->balance_due + $charge->paid_amount;

        $charge->order->payment_status_id = 1;

        $charge->order->save();

        $charge->delete();

        $charge->order->load('billing');

        // if($order->balance_due == 0){
        //     $notify = ['success' => "Order payment completed successfully!", 'redirect' => route('purchasing.order.list')];
        // }
        // else{
        $table = view('admin.purchasing.ajax.order-billings', ['order' => $charge->order])->render();

        $html = ['selector' => 'billing-tbody', 'data' => $table];
        $notify = ['success' => "Charge deleted successfully!", 'html' => $html];
        // }

        return $notify;
    }


    public function calc()
    {
        return [
            'shipping' => $this->getShipping(true),
            'tax' => $this->getTax(true),
            'total' => $this->getSubTotal(true),
            'paypal' => $this->paypalFee(true),
            'tenOrderFee' => $this->tenOrderFee(0, 'public', true),
            'adminFee' => $this->adminFee(true),
            'totalConverted' => $this->totalConverted($this->products[0]->currency_id, true),
        ];
    }

    public function addToCart(StoreRequest $request)
    {
        $purchase = Purchase::create($request->all());

        PurchaseCart::create(['user_id' => $purchase->user_id, 'purchase_id' => $purchase->id]);
        Session::put('user_id', $purchase->user_id);
        $html = $this->getCardData($purchase->user_id);
        $notify = [
            'success' => "Product added to cart successfully.",
            'redirect' => route('purchasing.get.cart'),
            'html' => $html,
        ];
        return $notify;
    }


    public function getCardData($userId)
    {
        $cartData = PurchaseCart::with('purchase', 'user')->where('user_id', $userId)->get();
        $this->products = Purchase::where(['user_id' => $userId, 'status' => 0])->get();
        $paymentMethods = Payment::orderBy('name', 'ASC')->get();
        if (count($this->products) > 0)
            $cal = (object) $this->calc();
        else
            $cal = null;

        return view('admin.purchasing.cart', compact('cartData', 'paymentMethods', 'cal'))->render();
    }

    public function editCardData(Request $request)
    {
        $purchase = Purchase::find($request->id);
        return $purchase;
    }


    public function updateCardData(UpdateRequest $request)
    {
        $purchase = Purchase::updateOrCreate(['id' => $request->purchase_id], $request->all());

        $html = $this->getCardData($purchase->user_id);
        $notify = [
            'success' => "Cart data updated successfully.",
            'redirect' => route('purchasing.get.cart'),
            'html' => $html,
        ];
        return $notify;
    }


    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            PurchaseCart::where('purchase_id', $request->id)->delete();
            Purchase::find($request->id)->delete();

            $userId = Session::get('user_id');
            $html = $this->getCardData($userId);
            $notify = [
                'success' => "Product removed from cart successfully.",
                'redirect' => route('purchasing.get.cart'),
                'html' => $html,
            ];


            return $notify;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // dd($request);


        $CalcOld = intval($request->subtotal) - (intval($request->old_shipping_price) + intval($request->old_tax));
        $getsubtotal = $CalcOld + (intval($request->shipping_price) + intval($request->tax));

        $paypalFee = ($getsubtotal * 4.62 / 100) + 0.3;
        $adminfee = $getsubtotal + $paypalFee + 3.1;
        $eGaroshiTax = $adminfee;
        // egaratoshi tax


        $cal = ($adminfee * 1.1) + 2;
        if ($request->discountCheck) {
            $discountA = isset($request->discountA) ? intval($request->discountA) : 0;
        } else {
            $discountA = 0;
        }
        $percent = ($cal * intval($discountA)) / 100;
        $total = $cal - $percent;
        $currency = Currency::findOrFail($request->currency_id);
        $total_Converted = $total * $currency->value;
        $total_Converted = number_format($total_Converted, 2);
        $discountA = isset($request->discountA) ? intval($request->discountA) : 0;
        // dd($total_Converted); 
        $paymentStatuses = PaymentStatus::all();
        $user = User::findOrFail($request->user_id);
        $paymentStatusId = $paymentStatuses->where('slug', 'unpaid')->pluck('id')->first();

        $pendingStatus = ConfigStatus::where('slug', 'pending')->first();
        if ($pendingStatus)
            $deliveryStatusId = $pendingStatus->id;
        else
            $deliveryStatusId = null;

        $id = Order::orderBy('id', 'desc')->pluck('id')->first();
        if ($id)
            $id = $id + 1;
        else
            $id = 1;

        $quantity = Purchase::whereIn('id', $request->purchase_id)->sum('quantity');

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->purchase_id = $request->purchase_id;
        $order->code = substr(str_shuffle(md5(rand(1000, 9999))), 0, 7);
        $order->currency_id = $request->currency_id;
        // $order->payment_id = $request->payment_method_id;
        $order->shipping_address_id = $request->shipping_address_id;
        $order->payment_status_id = $paymentStatusId;
        $order->delivery_status = $deliveryStatusId;
        $order->total_qty = $quantity;
        $order->status = 0;
        $order->insurance_tax = str_replace(',', '', $eGaroshiTax);
        $order->discount = ($request->discount) ? $request->discount : 0;
        $order->shipping_price = $request->shipping_price;
        $order->tax = $request->tax;
        // $order->sub_total = str_replace(',', '', $request->subtotal);
        $order->sub_total = str_replace(',', '', $getsubtotal);
        // $order->total = str_replace(',', '', $request->total);
        // $order->balance_due = str_replace(',', '', $request->total);
        $order->total = str_replace(',', '', $total);
        $order->balance_due = str_replace(',', '', $total);
        // $order->amount_converted = str_replace(',', '', $request->converted_amount);
        $order->amount_converted = str_replace(',', '', $total_Converted);

        $order->invoice = general_setting('setting')->invoice_no . $id;
        $order->awb = general_setting('setting')->waybil_no . $id;
        $order->save();

        $admin = Admin::first();

        $user = User::findOrFail($order->user_id);

        $template = EmailTemplate::where('slug', 'new-purchase-order')->first();

        if ($template) {

            $shortCodes = [
                'order_no' => $order->code,
                'order_status' => $order->deliveryStatus->name,
                'invoice_url' => route('purchasing.order.invoice.print', ['id' => $order->id]),
            ];

            //Send notification to user
            event(new OrderEvent($template, $shortCodes, $order, $admin, 'CreateOrder'));

            //Send notification to user
            event(new OrderEvent($template, $shortCodes, $order, $user, 'CreateOrder'));
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }

        $redirect = route('purchasing.payment.add', ['id' => $order->id]);
        $notify = ['success' => "Order created successfully.", 'redirect' => $redirect];
        return $notify;
    }

    public function addPayment(string $id)
    {

        $order = Order::findOrFail($id);
        // $paymentMethods = Payment::orderBy('name', 'ASC')->get();
        // $recieverAddresses = $order->user->shipping;
        // return view('admin.purchasing.add_payment', compact('order', 'paymentMethods', 'recieverAddresses'));
        return view('admin.purchasing.order-payment', compact('order'));
    }

    public function getPaymentInfo(string $id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $payment = Payment::findOrFail($id);
        if ($payment->slug == "account-funds") {
            $userBalance = $user->balance();
            if ($userBalance < 0) {
                $html = "<p><u>Account Info</u></p><p>Wallet Balance: <strong class='text-danger'>ƒ " . $userBalance . " ANG</strong></p><p>Sincerely,</p><p>Noah Imports Courier Team</p>";
            } else {
                $html = "<p><u>Account Info</u></p><p>Wallet Balance: <strong>ƒ " . $userBalance . " ANG</strong></p><p>Sincerely,</p><p>Noah Imports Courier Team</p>";
            }
            return $html;
        }
        return $payment->information;
    }

    public function pendingOrder()
    {
        $orderAmountDue = 0;
        $status = 'pending-order';
        $title = 'Pending Orders';
        $orders = Order::where('balance_due', '>', 0)->get();
        foreach ($orders as $order) {
            $orderAmountDue += str_replace(',', '', number_format($order->balance_due * $order->currency->value, 2));
        }

        return view('admin.purchasing.index', compact('orderAmountDue', 'status', 'title'));
    }
    public function updatePayment(UpdatePaymentRequest $request, string $id)
    {
        $paymentStatusId = PaymentStatus::where('slug', 'paid')->pluck('id')->first();
        $paymentMethod = Payment::findOrFail($request->payment_method_id);
        $order = Order::findOrFail($id);
        $balanceFlag = 0;
        if ($paymentMethod->slug == "account-funds") {
            $userBalance = $order->user->balance();
            $amount = $order->amount_converted;

            if ($userBalance < 0 || $userBalance < $amount) {
                $notify = ['error' => "Your Account Balance is not enough!"];
                return $notify;
            } else {
                $balanceFlag = 1;
            }
        }
        if (isset($request->payment_receipt)) {
            $order->payment_receipt = $this->fileUpload($request->payment_receipt, $order->payment_receipt);
        }
        $order->payment_id = $request->payment_method_id;
        $order->payment_status_id = $paymentStatusId;
        $order->shipping_address_id = $request->shipping_address_id;
        $order->save();

        if ($balanceFlag) {
            $wallet = new Wallet();
            $wallet->payment_id = $order->payment_id;
            $wallet->currency_id = $order->currency_id;
            $wallet->type = 'debit';
            $wallet->amount = $order->total;
            $wallet->amount_converted = $order->amount_converted;
            $wallet->description = 'Purchase Order Amount';
            $wallet->status = 'approved';
            $wallet->reason = 'Payment Approved';
            $wallet->morphable()->associate($order->user);
            $wallet->save();
        }

        $notify = [
            'success' => "Payment updated successfully.",
            'redirect' => route('purchasing.order.list'),
        ];
        return $notify;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $order = Order::findOrFail($id);
        $purchases = Purchase::whereIn('id', $order->purchase_id)->get();
        $this->products = $purchases;
        $cal = (object) $this->calc();
        $senderAddress = ShippingAddress::whereHasMorph('morphable', [Admin::class])->first();
        return view('admin.purchasing.show', ['order' => $order, 'purchases' => $purchases, 'cal' => $cal, 'senderAddress' => $senderAddress]);
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {
            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {
                // return Reply::error('This file format not allowed');
            }
            if (Storage::exists('assets/payment/' . $oldFile)) {
                Storage::Delete('assets/payment/' . $oldFile);
                $file->storeAs('assets/payment/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/payment/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $configStatuses = ConfigStatus::get();
        $paymentStatuses = PaymentStatus::get();
        $order = Order::findOrFail($id);
        return view('admin.purchasing.edit', compact('order', 'configStatuses', 'paymentStatuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function createItem()
    {
        $userId = Session::get('user_id');
        $users = User::orderBy('first_name', 'ASC')->get();
        return view('admin.purchasing.add-item', compact('users', 'userId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = Order::with('deliveryStatus')->findOrFail($id);
        $order->courier = $request->courier;

        if (isset($request->delivery_status) && $order->delivery_status != $request->delivery_status) {

            $order->delivery_status = $request->delivery_status;

            $statusFlag = 1;
        } else {
            $statusFlag = 0;
        }

        // $order->invoice = $request->invoice;
        // $order->awb = $request->awb;
        $order->external_awb = $request->external_awb;
        $order->tracking = $request->tracking;
        $order->payment_status_id = $request->payment_status;
        $order->status = 1;
        // $order->shipping_price = $request->shipping_price;
        // $order->tax = $request->tax;
        $order->save();

        $order->load('deliveryStatus');

        $admin = Admin::first();

        $user = User::findOrFail($order->user_id);

        if (isset($request->delivery_status) && $statusFlag == 1) {


            $template = EmailTemplate::where('slug', 'purchase-order-status')->first();

            if ($template) {

                $shortCodes = [
                    'order_no' => $order->code,
                    'order_status' => $order->deliveryStatus->name,
                    'invoice_url' => route('purchasing.order.invoice.print', ['id' => $order->id]),
                ];

                //Send notification to user
                event(new OrderEvent($template, $shortCodes, $order, $admin, 'OrderStatus'));

                //Send notification to user
                event(new OrderEvent($template, $shortCodes, $order, $user, 'OrderStatus'));
            } else {

                $notify = [
                    'error' => "Somethign went wrong contact your admin.",
                ];

                // return $notify;
            }
        }

        if (isset($order) && isset($order->tracking)) {

            $this->addParcel($order);
        }

        $admin = Admin::first();

        if (isset($request->send_invoice)) {
            $user = User::findOrFail($order->user_id);

            $template = EmailTemplate::where('slug', 'purchase-order-update')->first();

            if ($template) {

                $shortCodes = [
                    'order_no' => $order->code,
                    'tracking_no' => $order->tracking,
                    'order_status' => $order->deliveryStatus->name,
                    'invoice_url' => route('purchasing.order.invoice.print', ['id' => $order->id]),
                ];

                //Send notification to user
                event(new OrderEvent($template, $shortCodes, $order, $admin, 'UpdateOrder'));

                //Send notification to user
                event(new OrderEvent($template, $shortCodes, $order, $user, 'UpdateOrder'));
            } else {

                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];

                // return $notify;
            }

            // if (isset($request->send_invoice)) {

            // }

            $notify = [
                'success' => "Order updated successfully.",
                'redirect' => route('purchasing.order.list'),
            ];
            return $notify;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPaymentHtml($id)
    {
        $payment = Order::select('id', 'payment_status_id', 'payment_receipt')->where('id', $id)->first();
        $paymentStatuses = PaymentStatus::get();
        return view('admin.purchasing.payment', ['payment' => $payment, 'paymentStatuses' => $paymentStatuses]);
    }

    public function getChargePaymentHtml($id)
    {
        $charge = OrderPayment::select('id', 'payment_invoice')->where('id', $id)->first();
        return view('admin.purchasing.ajax.charge-receipt', compact('charge'));
    }

    public function approvedPayment($id)
    {
        $payment = Order::findOrFail($id);
        $payment->payment_status_id = 1;
        $payment->save();
        $notify = ['success' => "Payment has been approved."];

        return $notify;
    }

    public function updatePaymentStatus(Request $request)
    {
        $payment = Order::with('paymentStatus')->findOrFail($request->id);

        $payment->payment_status_id = $request->payment_status;

        if ($request->payment_method)
            $payment->payment_id = $request->payment_method;

        if ($request->payment_receipt) {

            $payment->payment_receipt = $this->fileUpload($request->payment_receipt, $payment->payment_receipt);
        }

        $payment->save();

        $payment->load('paymentStatus');

        $admin = Admin::first();


        $user = User::findOrFail($payment->user_id);


        $template = EmailTemplate::where('slug', 'purchase-order-payment-status')->first();

        if ($template) {

            $shortCodes = [
                'order_no' => $payment->code,
                'order_status' => $payment->deliveryStatus->name,
                'payment_status' => $payment->paymentStatus->name,
                'invoice_url' => route('purchasing.order.invoice.print', ['id' => $payment->id]),
            ];

            //Send notification to user
            event(new OrderEvent($template, $shortCodes, $payment, $admin, 'OrderPaymentStatus'));

            //Send notification to user
            event(new OrderEvent($template, $shortCodes, $payment, $user, 'OrderPaymentStatus'));
        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }

        $notify = ['success' => "Payment status updated."];

        return $notify;
    }

    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        $purchases = Purchase::whereIn('id', $order->purchase_id)->get();
        $this->products = $purchases;
        $cal = (object) $this->calc();
        $barcode = $this->generateQRcode(route('purchasing.order.invoice.print', ['id' => $order->id]));
        return view('admin.purchasing.print_invoice', compact('order', 'purchases', 'barcode', 'cal'));
    }

    public function generateQRcode($data = null, $barcodeType = null)
    {

        $QRData = QrCode::generate($data);

        return $QRData;
    }

    public function changeOrderStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_status = $request->status_id;
        $order->save();
        $notify = ['success' => "Order status changed successfully.", 'status_id' => $order->delivery_status];

        return $notify;
    }

    public function createItemParcel(Request $request)
    {
        $parcel = Parcel::where('purchase_id', $request->purchase_id)->first();
        if (is_null($parcel)) {
            return view('admin.purchasing.item-parcel-add', ['purchaseID' => $request->purchase_id, 'orderID' => $request->order_id])->render();
        } else {
            return view('admin.purchasing.item-parcel-edit', ['purchaseID' => $request->purchase_id, 'orderID' => $request->order_id, 'parcel' => $parcel])->render();
        }
    }

    public function storeItemParcel(Request $request)
    {
        $parcel = Parcel::where('purchase_id', $request->purchase_id)->first();
        if (is_null($parcel)) {
            $parcel = new Parcel();
        }
        return view('admin.purchasing.item-parcel-add', ['purchaseID' => $request->purchase_id, 'orderID' => $request->order_id, 'parcel' => $parcel])->render();
    }


    public function data(Request $request)
    {


        if (isset($request->user_id) && $request->user_id != '' && $request->user_id != null) {

            $data = Order::where('user_id', $request->user_id);

            $data = $data->get();

        } else if (isset($request->status) && $request->status != '' && $request->status != null) {

            $data = Order::where('status', $request->status);
            if ($request->statusvalue == "pending-order") {


                $data = $data->where('status', 0);
            } else {
                $data = $data->where('status', '!=', 0);
            }

            $data = $data->get();

        } else {


            if ($request->statusvalue == "pending-order") {
                $data = Order::where('status', 0)->get();
            } else {
                $data = Order::where('status', '!=', 0)->get();
            }

        }


        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown dropstart">
                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>print
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">
                        <li><a class="dropdown-item order-data-view" href="' . route('purchasing.order.show', ['id' => $row->id]) . '">View</a></li>
                        <li><a class="dropdown-item order-data-edit" href="' . route('purchasing.order.edit', ['id' => $row->id]) . '">Edit</a></li>
                        <li><a class="dropdown-item order-data-invoice" href="' . route('purchasing.payment.add', ['id' => $row->id]) . '" target="_blank">Upload Payment</a></li>
                        <!-- <li><a class="dropdown-item ni-payment-show-modal" href="javascript:void(0)" data-order-id="' . $row->id . '">View Reciept</a></li>-->
                        <li><a class="dropdown-item order-data-invoice" href="' . route('purchasing.order.invoice.print', ['id' => $row->id]) . '" target="_blank">Print Invoice</a></li>';
                // if ($row->status == 0) {
                $actionBtn .= '
                    <li><a class="dropdown-item approve-order" href="#" data-order-id=' . $row->id . '>Approve</a></li>
                    <li><a class="dropdown-item reject-order" href="#" data-order-id=' . $row->id . '>Reject</a></li>';
                //   }
                $actionBtn .= '</ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('delivery_status', function ($row) {
                $html = $row->deliveryStatus->name ?? 'N/A';
                if (isset ($row->deliveryStatus->color)) {
                    $html = '<span class="mb-1 badge" style="background-color:' . $row->deliveryStatus->color . '">' . $row->deliveryStatus->name . '</span>';
                }
                return $html;
            })
            ->addColumn('status', function ($row) {

                if ($row->status == 0) {
                    $html = '<span class="mb-1 badge bg-danger">Pending</span>';
                } else if ($row->status == 3) {

                    $html = '<span class="mb-1 badge  bg-success">Approved</span>';

                } else if ($row->status == 3) {
                    $html = '<span class="mb-1 badge  bg-success">Approved</span>';
                } else {
                    $html = '<span class="mb-1 badge bg-danger">Rejected</span>';
                }

                return $html;
            })
            ->addColumn('payment_status', function ($row) {
                if ($row->paymentStatus->slug == 'paid') {
                    $html = '<span class="mb-1 badge bg-success">' . $row->paymentStatus->name . '</span>';
                } else {
                    $html = '<a href="' . route('purchasing.payment.add', ['id' => $row->id]) . '" target="_blank"><span class="mb-1 badge bg-danger" data-order-id="' . $row->id . '">Unpaid</span></a>';
                }
                return $html;
            })
            ->addColumn('total', function ($row) {

                return (isset ($row->total) ? 'ƒ ' . number_format($row->amount_converted, 2) . ' ANG' : 'ƒ 0.00 ANG');
            })
            ->addColumn('reciever', function ($row) {
                $address = 'N/A';
                if (isset ($row->shipperAddress)) {
                    $address = $row->shipperAddress->first_name . ' ' . $row->shipperAddress->last_name . ' - ' . $row->shipperAddress->country->name;
                }

                return $address;
            })
            ->addColumn('created_at', function ($row) {
                return (isset ($row->created_at) ? $row->created_at->format('F j, Y h:i A') : 'N/A');
            })
            ->rawColumns(['action', 'status', 'delivery_status', 'payment_status', 'total', 'reciever'])
            ->make(true);
    }

    public function addParcel($order = null)
    {
        $orderCount = Parcel::whereHasMorph('orderable', [Order::class])
            ->where('orderable_id', $order->id)->count();

        if (isset($order->tracking) && $orderCount == 0) {

            $parcels = new Parcel();

            $parcels->invoice_no = $order->invoice;

            $parcels->waybill = $order->awb;

            $parcels->payment_status_id = $order->payment_status_id;

            // $parcels->payment_id = $order->payment_id;

            // $parcels->payment_receipt = $order->payment_receipt;

            $parcels->parcel_status_id = $order->delivery_status;

            $parcels->delivery_method = 0;

            $parcels->show_delivery_date = 0;

            $parcels->important = 0;

            $parcels->show_invoice = 0;

            $parcels->external_shipper_id = $order->courier;

            $parcels->external_tracking = $order->tracking;

            $parcels->tax = $order->tax;

            $parcels->delivery_fee = $order->shipping_price;

            $parcels->discount = $order->discount;

            $parcels->quantity = 1;

            $parcels->weight = 0;

            $parcels->length = 0;

            $parcels->width = 0;

            $parcels->height = 0;

            $parcels->dimension = 0;

            $parcels->item_value = (isset($order->total) ? $order->total : 0);

            $parcels->reciever_address_id = (isset($order->shipping_address_id) ? $order->shipping_address_id : null);

            $parcels->orderable_id = $order->id;

            $parcels->user_id = $order->user_id;

            $parcels->currency_id = $order->currency_id;

            $parcels->orderable()->associate($order);

            $parcels->save();

            $admin = Admin::first();

            $user = User::findOrFail($parcels->user_id);

            $template = EmailTemplate::where('slug', 'new-shipment')->first();

            if ($template) {
                $senderName = @$parcels->sender->first_name . ' ' . @$parcels->sender->last_name;
                $shortCodes = [
                    'sender_name' => $senderName,
                    'tracking_no' => $parcels->external_tracking,
                    'delivery_time' => $parcels->es_delivery_date,
                    'invoice_url' => route('parcel.invoice', ['id' => $parcels->id]),
                ];

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $admin, 'CreateParcel'));

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $user, 'CreateParcel'));
            } else {

                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];

                // return $notify;
            }
        }
    }

    public function addItemParcel(Request $request)
    {
        $parcelCount = Parcel::whereHasMorph('orderable', [Order::class])
            ->where('orderable_id', $request->order_id)->where('purchase_id', $request->purchase_id)->count();

        $purchase = Purchase::findOrFail($request->purchase_id);
        $order = Order::findOrFail($request->order_id);

        if (isset($request->tracking) && $parcelCount == 0) {

            $id = Parcel::orderBy('id', 'desc')->pluck('id')->first();

            if ($id) {
                $id = $id + 1;
            } else {
                $id = 1;
            }

            $parcels = new Parcel();

            if ($request->payment_file) {

                $parcels->payment_receipt = $this->fileUpload($request->payment_file);
            }

            $parcels->invoice_no = general_setting('setting')->invoice_no . $id;

            $parcels->waybill = general_setting('setting')->waybil_no . $id;

            $parcels->external_waybill = $request->external_awb;

            $parcels->full_name = @$purchase->user->first_name . ' ' . @$purchase->user->last_name;

            $parcels->payment_status_id = $request->payment_status;

            $parcels->payment_id = $request->payment_method;

            $parcels->purchase_id = $request->purchase_id;

            $parcels->parcel_status_id = $request->parcel_status;

            $parcels->external_shipper_id = $request->courier;

            $parcels->product_description = $purchase->description;

            $parcels->external_tracking = $request->tracking;

            $parcels->delivery_method = 0;

            $parcels->show_delivery_date = 0;

            $parcels->important = 0;

            $parcels->show_invoice = 0;

            $parcels->tax = $purchase->tax;

            $parcels->delivery_fee = $purchase->shipping_price;

            $parcels->discount = $order->discount;

            $parcels->quantity = 1;

            $parcels->weight = 0;

            $parcels->length = 0;

            $parcels->width = 0;

            $parcels->height = 0;

            $parcels->dimension = 0;

            $parcels->reciever_address_id = (isset($order->shipping_address_id) ? $order->shipping_address_id : null);

            $parcels->item_value = $purchase->price;

            $parcels->user_id = $purchase->user_id;

            $parcels->currency_id = $purchase->currency_id;

            $parcels->es_delivery_date = $request->delivery_date;

            $parcels->orderable()->associate($order);

            $parcels->save();

            $admin = Admin::first();

            $user = User::findOrFail($parcels->user_id);

            $template = EmailTemplate::where('slug', 'new-shipment')->first();

            if ($template) {

                $shortCodes = [
                    'tracking_no' => $parcels->external_tracking,
                    'delivery_time' => $parcels->es_delivery_date,
                    'invoice_url' => route('parcel.invoice', ['id' => $parcels->id]),
                ];

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $admin, 'CreateParcel'));

                //Send notification to user
                event(new ParcelEvent($template, $shortCodes, $parcels, $user, 'CreateParcel'));

            } else {

                $notify = [
                    'error' => "Something went wrong contact your admin.",
                ];

                // return $notify;
            }

            $notify = ['success' => "Purchase item added as parcel successfully"];
        } else {
            $notify = ['error' => "Something went wrong! contact admin"];
        }

        return $notify;
    }

    public function updateItemParcel(Request $request, $id)
    {

        $parcels = Parcel::findOrFail($id);

        if ($request->payment_file) {

            $parcels->payment_receipt = $this->fileUpload($request->payment_file);
        }

        $parcels->external_waybill = $request->external_awb;

        $parcels->payment_status_id = $request->payment_status;

        $parcels->parcel_status_id = $request->parcel_status;

        $parcels->payment_id = $request->parcel_status;

        $parcels->external_shipper_id = $request->courier;

        $parcels->external_tracking = $request->tracking;

        $parcels->es_delivery_date = $request->delivery_date;

        $parcels->save();

        $notify = ['success' => "Parcel updated successfully"];


        return $notify;
    }

    public function getSiteContent(Request $request)
    {
        $url = $request->site_url;

        $product = $this->scrapeProductImages($url);
        $client = new Client(['verify' => false]);





        $title = $product['title'];
        $website = $product['website'];
        $price = preg_replace('/[^0-9.]/', "", $product['price']);
        $itemNumber = @$product['item_number'];
        $imageUrls = $product['images'];
        if (count($imageUrls) > 0) {

            $html = view('admin.purchasing.product_images', compact('imageUrls', 'title', 'website', 'price', 'itemNumber'))->render();
            $notify = ['success' => "Product images fetched successfully", 'html' => $html];
        } else {

            $notify = ['error' => "Product images failed to retrieve"];
        }

        return $notify;
    }
}
