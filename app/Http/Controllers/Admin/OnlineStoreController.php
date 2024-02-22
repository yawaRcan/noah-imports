<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\ConfigStatus;
use App\Models\User;
use App\Models\EcommerceOrder;

use Illuminate\Http\Request;

use App\Models\EcommerceCart;

use App\Traits\CartCalculation;

use App\Models\EcommerceWishlist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EcommerceCoupon;

class OnlineStoreController extends Controller
{
    use CartCalculation;

    protected $product = null;

    protected $user_id = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $carts = EcommerceCart::where('user_id', $this->user_id)->where('order_id', null)->get();

        $products = Product::with('files')->get();

        $paymentMethods = Payment::orderBy('name', 'ASC')->get();

        return view('admin.ecommerce.online-store.index', compact('products', 'carts', 'paymentMethods'));
    }

    public function addToCart(Request $request)
    {

        if ($request->user_id != null && $request->user_id != 'null' && $request->user_id != '' && $request->user_id != 'undefined') {

            $this->user_id = $request->user_id;
        } else {

            $notify = ['error' => "select user first"];

            return $notify;
        }

        if (empty($request->id)) {

            $notify = ['error' => "Invalid Products"];

            return $notify;
        }
        $product = Product::where('id', $request->id)->first();

        if (empty($product)) {

            $notify = ['error' => "Invalid Products"];

            return $notify;
        }

        $already_cart = EcommerceCart::where('user_id', $this->user_id)->where('order_id', null)->where('product_id', $product->id)->first();
        if ($already_cart) {

            $already_cart->quantity = $already_cart->quantity + 1;

            $already_cart->amount = $product->price + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {

                $notify = ['error' => "Stock not sufficient!."];

                return $notify;
            }
            $already_cart->save();
        } else {

            $cart = new EcommerceCart;

            $cart->user_id = auth()->user()->id;

            $cart->product_id = $product->id;

            $cart->price = ($product->price - ($product->price * $product->discount) / 100);

            $cart->quantity = 1;

            $cart->currency_id = 2;

            $cart->amount = $cart->price * $cart->quantity;

            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                $notify = ['error' => "Stock not sufficient"];
                return $notify;
            }

            $cart->save();

            $wishlist = EcommerceWishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }

        $carts = EcommerceCart::where('user_id', $this->user_id)->where('order_id', null)->get();

        $this->products = DB::table('products')
            ->join('ecommerce_carts', 'products.id', '=', 'ecommerce_carts.product_id')
            ->select(
                'ecommerce_carts.currency_id',
                'ecommerce_carts.price',
                'ecommerce_carts.quantity',
                'products.shipping_price',
                'products.tax'
            )
            ->where('ecommerce_carts.user_id', $this->user_id)
            ->where('products.status', 'active')
            ->get();

        $calc = $this->calc($carts[0]->currency_id);

        $paymentMethods = Payment::orderBy('name', 'ASC')->get();

        $cartView = view('admin.ecommerce.online-store.cart', compact('carts', 'calc', 'paymentMethods'))->render();

        $html = ['selector' => 'navpill-222', 'data' => $cartView];

        $notify = [
            'success' => "Product successfully added to cart",
            'html' => $html
        ];

        return $notify;
    }



    public function cartDelete($id)
    {
        $cart = EcommerceCart::find($id);

        if ($cart) {

            $cart->delete();

            $carts = EcommerceCart::where('user_id', $this->user_id)->where('order_id', null)->get();

            $this->products = DB::table('products')
                ->join('ecommerce_carts', 'products.id', '=', 'ecommerce_carts.product_id')
                ->select(
                    'ecommerce_carts.currency_id',
                    'ecommerce_carts.price',
                    'ecommerce_carts.quantity',
                    'products.shipping_price',
                    'products.tax'
                )
                ->where('ecommerce_carts.user_id', $this->user_id)
                ->where('products.status', 'active')
                ->get();

            $calc = $this->calc($carts[0]->currency_id);

            $cartView = view('admin.ecommerce.online-store.cart', compact('carts', 'calc'))->render();

            $html = ['selector' => 'navpill-222', 'data' => $cartView];

            $notify = [
                'success' => "Product successfully removed",
                'html' => $html
            ];

            return $notify;
        }
        $notify = ['error' => "Error please try again"];
        return $notify;
    }

    public function cartHtml(Request $request)
    {
        $this->user_id = $request->id;

        $carts = EcommerceCart::where('user_id', $this->user_id)->where('order_id', null)->get();

        $this->products = DB::table('products')
            ->join('ecommerce_carts', 'products.id', '=', 'ecommerce_carts.product_id')
            ->select(
                'ecommerce_carts.currency_id',
                'ecommerce_carts.price',
                'ecommerce_carts.quantity',
                'products.shipping_price',
                'products.tax'
            )
            ->where('ecommerce_carts.user_id', $this->user_id)
            ->where('products.status', 'active')
            ->get();

        if (count($carts) > 0)
            $calc = $this->calc($carts[0]->currency_id);
        else
            $calc = $this->calc(1);



        $paymentMethods = Payment::orderBy('name', 'ASC')->get();

        $cartView = view('admin.ecommerce.online-store.cart', compact('carts', 'calc', 'paymentMethods'))->render();

        $html = ['selector' => 'navpill-222', 'data' => $cartView];

        $notify = ['html' => $html];

        return $notify;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('admin.ecommerce.product.show', ['product' => $product]);
    }

    public function calc($currencyId)
    {
        return [
            'shipping' => number_format($this->getShipping(false), 2),
            'tax' => number_format($this->getTax(false), 2),
            'total' => number_format($this->getSubTotal(false), 2),
            'paypal' => number_format($this->paypalFee(false), 2),
            'tenOrderFee' => number_format($this->tenOrderFee(0, 'public', false), 2),
            'adminFee' => number_format($this->adminFee(false), 2),
            'totalConverted' => $this->totalConverted($currencyId, true),
        ];
    }

    public function applyCoupon(Request $request)
    {


        $totalConverted = doubleval(str_replace(',', '', $request->totalConverted));

        $coupon = EcommerceCoupon::where('code', $request->code)->first();

        if ($coupon) {

            if ($coupon->type == 'fixed') {

                $totalConverted = $totalConverted - doubleval($coupon->value);
            } else {
                $totalConverted = doubleval($totalConverted - ($totalConverted * doubleval($coupon->value)) / 100);
            }

            $html = ['selector' => 'ni-total-converted-coupon', 'data' => $totalConverted];

            $notify = [
                'success' => "Coupon Code Applied Successfully",
                'html' => $html
            ];

            return $notify;
        } else {

            $notify = [
                'error' => "Coupon Code Does Not Exist"
            ];

            return $notify;
        }
    }

    public function search(Request $request)
    {
        $query = Product::query();

        // Filter by product name
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Apply additional filters based on your requirements

        $products = $query->get();

        $view = view('admin.ecommerce.online-store.product-search', compact('products'))->render();

        $html = ['selector' => 'ni-product-search', 'data' => $view];

        $notify = ['html' => $html];

        return $notify;
    }
}
