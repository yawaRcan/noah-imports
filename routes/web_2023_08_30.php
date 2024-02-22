<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/clear', function () {
//     \Illuminate\Support\Facades\Artisan::call('optimize:clear');
//     \Illuminate\Support\Facades\Artisan::call('cache:clear');
//     \Illuminate\Support\Facades\Artisan::call('view:clear');
//     \Illuminate\Support\Facades\Artisan::call('config:clear');
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
// });

Route::get('/app-config', function () {

    // DB setup
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    \Illuminate\Support\Facades\Artisan::call('db:seed');

    // linking public with storage
    \Illuminate\Support\Facades\Artisan::call('storage:link');

    // clearing app cache
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    

    return redirect()->route('admin.login');
});

// Route::get('/storage-link', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
// });

// Route::get('/seed-db', function () {
//     \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
//     \Illuminate\Support\Facades\Artisan::call('db:seed');
//     dd('done');
// });

Route::get('/getroutes', function () {
    $routeCollection = Route::getRoutes();
    echo "<table style='width:100%;border:2px;'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>";
        foreach ($value->methods as $method) {
            echo " " . $method . ",";
        }
        echo "</td>";
        echo "<td>" . $value->uri . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    ['namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth:admin'],
    function () {

        Route::group(
            ['prefix' => 'admin'],
            function () {
                Route::controller(DashboardController::class)->name('admin.')->group(function () {
                    Route::get('/', 'index')->name('index');
                });
                Route::controller(ShipmentModeController::class)->name('shipment-mode.')->group(function () {
                    Route::get('/shipment-mode', 'index')->name('index');
                    Route::get('/shipment-mode/data', 'data')->name('data');
                    Route::get('/shipment-mode/create', 'create')->name('create');
                    Route::post('/shipment-mode/store', 'store')->name('store');
                    Route::get('/shipment-mode/edit/{id}', 'edit')->name('edit');
                    Route::put('/shipment-mode/update/{id}', 'update')->name('update');
                    Route::delete('/shipment-mode/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ShipmentTypeController::class)->name('shipment-type.')->group(function () {
                    Route::get('/shipment-type', 'index')->name('index');
                    Route::get('/shipment-type/data', 'data')->name('data');
                    Route::get('/shipment-type/create', 'create')->name('create');
                    Route::post('/shipment-type/store', 'store')->name('store');
                    Route::get('/shipment-type/edit/{id}', 'edit')->name('edit');
                    Route::put('/shipment-type/update/{id}', 'update')->name('update');
                    Route::delete('/shipment-type/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ConfigStatusController::class)->name('config-status.')->group(function () {
                    Route::get('/config-status', 'index')->name('index');
                    Route::get('/config-status/data', 'data')->name('data');
                    Route::get('/config-status/create', 'create')->name('create');
                    Route::post('/config-status/store', 'store')->name('store');
                    Route::get('/config-status/edit/{id}', 'edit')->name('edit');
                    Route::put('/config-status/update/{id}', 'update')->name('update');
                    Route::delete('/config-status/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ExternalShipperController::class)->name('external-shipper.')->group(function () {
                    Route::get('/external-shipper', 'index')->name('index');
                    Route::get('/external-shipper/data', 'data')->name('data');
                    Route::get('/external-shipper/create', 'create')->name('create');
                    Route::post('/external-shipper/store', 'store')->name('store');
                    Route::get('/external-shipper/edit/{id}', 'edit')->name('edit');
                    Route::post('/external-shipper/update/{id}', 'update')->name('update');
                    Route::delete('/external-shipper/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(PaymentController::class)->name('payment.')->group(function () {
                    Route::get('/payment', 'index')->name('index');
                    Route::get('/payment/data', 'data')->name('data');
                    Route::get('/payment/create', 'create')->name('create');
                    Route::post('/payment/store', 'store')->name('store');
                    Route::get('/payment/edit/{id}', 'edit')->name('edit');
                    Route::put('/payment/update/{id}', 'update')->name('update');
                    Route::delete('/payment/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(CurrencyController::class)->name('currency.')->group(function () {
                    Route::get('/currency', 'index')->name('index');
                    Route::get('/currency/data', 'data')->name('data');
                    Route::get('/currency/create', 'create')->name('create');
                    Route::post('/currency/store', 'store')->name('store');
                    Route::get('/currency/edit/{id}', 'edit')->name('edit');
                    Route::put('/currency/update/{id}', 'update')->name('update');
                    Route::delete('/currency/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ImportDutyController::class)->name('import-duty.')->group(function () {
                    Route::get('/import-duty', 'index')->name('index');
                    Route::get('/import-duty/data', 'data')->name('data');
                    Route::get('/import-duty/create', 'create')->name('create');
                    Route::post('/import-duty/store', 'store')->name('store');
                    Route::get('/import-duty/edit/{id}', 'edit')->name('edit');
                    Route::put('/import-duty/update/{id}', 'update')->name('update');
                    Route::delete('/import-duty/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(DiscountController::class)->name('discount.')->group(function () {
                    Route::get('/discount', 'index')->name('index');
                    Route::get('/discount/data', 'data')->name('data');
                    Route::get('/discount/create', 'create')->name('create');
                    Route::post('/discount/store', 'store')->name('store');
                    Route::get('/discount/edit/{id}', 'edit')->name('edit');
                    Route::put('/discount/update/{id}', 'update')->name('update');
                    Route::delete('/discount/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(BranchController::class)->name('branch.')->group(function () {
                    Route::get('/branch', 'index')->name('index');
                    Route::get('/branch/create', 'create')->name('create');
                    Route::post('/branch/store', 'store')->name('store');
                    Route::get('/branch/edit/{id}', 'edit')->name('edit');
                    Route::put('/branch/update/{id}', 'update')->name('update');
                    Route::delete('/branch/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(RateController::class)->name('rate.')->group(function () {
                    Route::get('/rate', 'index')->name('index');
                    Route::get('/rate/data', 'data')->name('data');
                    Route::get('/rate/create', 'create')->name('create');
                    Route::post('/rate/store', 'store')->name('store');
                    Route::get('/rate/edit/{id}', 'edit')->name('edit');
                    Route::put('/rate/update/{id}', 'update')->name('update');
                    Route::delete('/rate/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(SettingController::class)->name('settings.')->group(function () {
                    Route::get('/settings', 'index')->name('index');
                    Route::get('/configurations', 'configurations')->name('configurations');
                    Route::put('/settings/setting/{id}', 'setting')->name('setting');
                    Route::put('/settings/freight/{id}', 'freight')->name('freight');
                    Route::put('/settings/config/{id}', 'config')->name('config');
                    Route::post('/settings/company/{id}', 'company')->name('company');
                    Route::post('/settings/smtp/{id}', 'smtp')->name('smtp');
                    Route::post('/settings/aftership/{id}', 'aftership')->name('aftership');
                });
                Route::controller(ShippingAddressController::class)->name('shipping-address.')->group(function () {
                    Route::get('/shipping-address', 'index')->name('index');
                    Route::get('/shipping-address/create', 'create')->name('create');
                    Route::post('/shipping-address/store', 'store')->name('store');
                    Route::get('/shipping-address/edit/{id}', 'edit')->name('edit');
                    Route::put('/shipping-address/update/{id}', 'update')->name('update');
                    Route::delete('/shipping-address/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(PickupStationController::class)->name('pickup-station.')->group(function () {
                    Route::get('/pickup-station', 'index')->name('index');
                    Route::get('/branch-wise', 'getBranchWisePickupStations')->name('branch-wise');
                    Route::get('/pickup-station/create', 'create')->name('create');
                    Route::post('/pickup-station/store', 'store')->name('store');
                    Route::get('/pickup-station/edit/{id}', 'edit')->name('edit');
                    Route::put('/pickup-station/update/{id}', 'update')->name('update');
                    Route::delete('/pickup-station/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(AccountController::class)->name('account.')->group(function () {
                    Route::get('/account', 'userAccount')->name('index');
                    Route::put('/update/{id}', 'updateAccount')->name('update');
                    Route::get('/account/privacy', 'userProfilePrivacy')->name('profile.view');
                    Route::post('/account/privacy/update/{id}', 'updateProfilePrivacy')->name('privacy.update');
                    Route::post('/account/password/update/{id}', 'updatePassword')->name('password.update');
                });
                Route::controller(ReportController::class)->name('reports.')->group(function () {

                    Route::get('/reports/list', 'index')->name('list');

                    // Order report routes
                    Route::get('/reports/all-orders', 'allOrders')->name('orders.list');
                    Route::get('/reports/pending-orders', 'pendingOrders')->name('orders.pending');
                    Route::get('/reports/paid-orders', 'paidOrders')->name('orders.paid');
                    Route::get('/reports/unpaid-orders', 'unpaidOrders')->name('orders.unpaid');

                    // Parcel report routes
                    Route::get('/reports/all-parcels', 'allParcels')->name('parcels.list');
                    Route::get('/reports/pending-parcels', 'pendingParcels')->name('parcels.pending');
                    Route::get('/reports/paid-parcels', 'paidParcels')->name('parcels.paid');
                    Route::get('/reports/unpaid-parcels', 'unpaidParcels')->name('parcels.unpaid');

                    // Consolidate report routes
                    Route::get('/reports/all-consolidates', 'allConsolidates')->name('consolidates.list');
                    Route::get('/reports/pending-consolidates', 'pendingConsolidates')->name('consolidates.pending');
                    Route::get('/reports/paid-consolidates', 'paidConsolidates')->name('consolidates.paid');
                    Route::get('/reports/unpaid-consolidates', 'unpaidConsolidates')->name('consolidates.unpaid');

                    // Backup routes
                    Route::get('/db-backup', 'databaseBackup')->name('database.backup');
                    Route::get('/remove-unused-files', 'removeUnusedFiles')->name('data.clean');
                    Route::get('/site-backup', 'siteBackup')->name('site.backup');
                    Route::get('/payment-recieved', 'recievePayment')->name('payment.recieve');
                });
                Route::controller(OrderController::class)->name('purchasing.')->group(function () {
                    Route::get('/order/list', 'index')->name('order.list');
                    Route::get('/order/data', 'data')->name('order.data'); 
                    Route::get('/order/pending', 'pendingOrders')->name('order.pendingOrders');
                    Route::get('/pending/order', 'pendingOrder')->name('pending.order'); 
                    Route::get('/order/create', 'create')->name('create');
                    Route::get('/order/create/item', 'createItem')->name('create.item');
                    Route::get('/order/edit/{id}', 'edit')->name('order.edit');
                    Route::put('/order/update/{id}', 'update')->name('order.update');
                    Route::post('/purchase/cart', 'addToCart')->name('product.cart');
                    Route::get('/get-cart-data', 'getCardData')->name('get.cart');
                    Route::get('/edit-cart-data', 'editCardData')->name('cart.edit');
                    Route::post('/update-cart-data', 'updateCardData')->name('update.cart');
                    Route::post('/change-order-status', 'changeOrderStatus')->name('changeOrderStatus');
                    Route::post('/purchase/checkout', 'store')->name('product.checkout');
                    Route::delete('remove-from-cart', 'removeFromCart')->name('remove.from.cart');

                    Route::get('/order/show/{id}', 'show')->name('order.show');
                    Route::get('/order/item/parcel/create', 'createItemParcel')->name('order.createItemParcel');

                    // order payment charge routes
                    Route::get('/charge/create/{id}', 'createCharge')->name('charge.create');
                    Route::post('/charge/store', 'storeCharge')->name('charge.store');
                    Route::get('/charge/edit/{id}', 'editCharge')->name('charge.edit');
                    Route::put('/charge/update/{id}', 'updateCharge')->name('charge.update');
                    Route::delete('/charge/delete/{id}', 'deleteCharge')->name('charge.delete');
                    Route::get('/charge/getpaymenthtml/{id}', 'getChargePaymentHtml')->name('getChargePaymentHtml');
                    //end order payment charge routes


                    Route::get('/order/invoice/print/{id}', 'printInvoice')->name('order.invoice.print');
                    Route::post('/get-site-content', 'getSiteContent')->name('url.content');
                    Route::get('/add-payment/{id}', 'addPayment')->name('payment.add');
                    Route::post('/update-order-payment/{id}', 'updatePayment')->name('payment.update');
                    Route::get('/order/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::put('/order/approvedpayment/{id}', 'approvedPayment')->name('approvedPayment');
                    Route::post('/order/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::post('/add-item-parcel', 'addItemParcel')->name('addItemParcel');
                    Route::post('/update-item-parcel/{id}', 'updateItemParcel')->name('updateItemParcel');

                    Route::get('/order/getPaymentInfo/{id}/{user_id}', 'getPaymentInfo')->name('get.paymentInfo');
                });
                Route::controller(AnnouncementController::class)->name('announcement.')->group(function () {
                    Route::get('/announcement/create', 'create')->name('create');
                    Route::post('/announcement/store', 'store')->name('store');
                });
                Route::controller(UserController::class)->name('user.val.')->group(function () {
                    Route::get('/user/list', 'index')->name('index');
                    Route::get('/user/data', 'data')->name('data');
                    Route::get('/user/show/{id}', 'show')->name('show');
                    Route::get('/user/edit/{id}', 'edit')->name('edit');
                    Route::get('/user/send-email/{id}', 'sendEmail')->name('sendEmail');
                    Route::post('/user/post-send-email/{id}', 'postSendEmail')->name('postSendEmail');
                    Route::put('/user/update/{id}', 'update')->name('update');
                    Route::delete('/user/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ParcelController::class)->name('parcel.')->group(function () {
                    Route::get('/parcels', 'index')->name('index');
                    Route::get('/pending/parcels', 'pendingParcels')->name('pendingParcels');
                    Route::get('/archived/parcels', 'archivedParcels')->name('archivedParcels');
                    Route::get('/drafted/parcels', 'draftedParcels')->name('draftedParcels');
                    Route::get('/parcel/show/{id}', 'show')->name('show');
                    Route::get('/parcel/data', 'data')->name('data');
                    Route::get('/parcel/create', 'create')->name('create');
                    Route::get('/parcel/getusers', 'getUsers')->name('getusers');
                    Route::get('/parcel/checkReciverAdd', 'checkReciverAdd')->name('checkReciverAdd');
                    Route::post('/parcel/addreciever', 'addRecieverAddress')->name('addreciever');
                    Route::post('/parcel/addSender', 'addSenderAddress')->name('addSender');
                    Route::get('/parcel/getrecieverhtml', 'getRecieverhtml')->name('getrecieverhtml');
                    Route::get('/parcel/getsenderhtml', 'getSenderhtml')->name('getsenderhtml');
                    Route::get('/parcel/getpickupstation', 'getPickupStation')->name('getPickupStation');
                    Route::get('/parcel/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::get('/parcel/getTracking/{id}', 'getParcelTracking')->name('getTracking');
                    Route::get('/parcel/getOnlineTracking', 'getOnlineTracking')->name('getOnlineTracking');
                    Route::put('/parcel/approvedpayment/{id}', 'approvedPayment')->name('approvedPayment');
                    Route::put('/parcel/delivery-date/update', 'updateDeliveryDate')->name('deliveryDate.update');
                    Route::post('/parcel/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::put('/parcel/changeinvoicestatus/{id}', 'changeInvoiceStatus')->name('changeInvoiceStatus');
                    Route::get('/parcel/imagesget/{id}', 'imagesGet')->name('imagesGet');
                    Route::post('/parcel/store', 'store')->name('store');
                    Route::post('/parcel/files/store', 'fileStore')->name('file.store');
                    Route::get('/parcel/edit/{id}', 'edit')->name('edit');
                    Route::get('/parcel/invoice/print/{id}', 'print')->name('print');
                    Route::get('/parcel/invoice/invoice/{id}', 'invoicePrint')->name('invoice');
                    Route::get('/parcel/invoice/invoice/label/{id}', 'invoiceLabel')->name('invoice.label');
                    Route::get('/parcel/recieve/{id}', 'recieveParcel')->name('delivery.recieve');
                    Route::post('/parcel/update/{id}', 'update')->name('update');
                    Route::post('/parcel/destroy/', 'destroy')->name('destroy');
                    Route::post('/parcel/draft/', 'toDraft')->name('toDraft');
                    Route::post('/parcel/exists/data/{tracking}', 'parcelData')->name('exist.data'); 
                    Route::post('/parcel/signature/save', 'saveParcelSignature')->name('signature.save');
                    Route::post('/parcel/shipment-delivery/{id}', 'shipmentDelivery')->name('deliver.shipment');
                    Route::get('/parcel/calculate/', 'calculateParcel')->name('calculateParcel');
                    Route::get('/parcel/calculate/ajax', 'calAjax')->name('calAjax.data');
                    Route::get('/parcel/payParcelsData', 'getPayParcelsData')->name('getPayParcelsData');
                    Route::post('/parcel/pay/amount', 'payParcelAmount')->name('pay.amount');
                });
                Route::controller(ProductController::class)->name('product.')->group(function () {
                    Route::get('/products', 'index')->name('index');
                    Route::get('/products/data', 'data')->name('data');
                    Route::get('/product/create', 'create')->name('create');
                    Route::get('/product/subCategories', 'getSubCategories')->name('get-sub-categories');
                    Route::post('/product/store', 'store')->name('store');
                    Route::post('/product/files/store', 'fileStore')->name('file.store');
                    Route::get('/product/edit/{id}', 'edit')->name('edit');
                    Route::post('/product/update/{id}', 'update')->name('update');
                    Route::delete('/product/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(CategoryController::class)->name('category.')->group(function () {
                    Route::get('/category', 'index')->name('index');
                    Route::get('/category/data', 'data')->name('data');
                    Route::get('/category/create', 'create')->name('create');
                    Route::post('/category/store', 'store')->name('store');
                    Route::get('/category/edit/{id}', 'edit')->name('edit');
                    Route::post('/category/update/{id}', 'update')->name('update');
                    Route::delete('/category/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(SubCategoryController::class)->name('subcategory.')->group(function () {
                    Route::get('/subcategory', 'index')->name('index');
                    Route::get('/subcategory/data', 'data')->name('data');
                    Route::get('/subcategory/create', 'create')->name('create');
                    Route::post('/subcategory/store', 'store')->name('store');
                    Route::get('/subcategory/edit/{id}', 'edit')->name('edit');
                    Route::post('/subcategory/update/{id}', 'update')->name('update');
                    Route::delete('/subcategory/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(OnlineStoreController::class)->name('online-store.')->group(function () {
                    Route::get('/online-store', 'index')->name('index'); 
                    Route::get('/online-store/search', 'search')->name('search'); 
                    // Cart section
                    Route::post('/add-to-cart/{id}/{user_id}','addToCart')->name('add-to-cart');
                    Route::delete('cart-delete/{id}','cartDelete')->name('cart-delete');
                    Route::get('online-store/cart','cartHtml')->name('cartHtml');
                    Route::get('online-store/show/{id}','show')->name('show');
                    Route::post('online-store/coupon-apply','applyCoupon')->name('coupon-apply');

                });

                Route::controller(ECOrderController::class)->name('ec-order.')->group(function () {
                    Route::get('/ecommerce-order/list/{status?}', 'index')->name('list');
                    Route::get('/ecommerce-order/data', 'data')->name('data');
                    Route::post('/ecommerce-order/store','store')->name('store');
                    Route::get('ecommerce-order/add-payment/{id}', 'addPayment')->name('payment.add');
                    Route::get('/ecommerce-order/getPaymentInfo/{id}/{user_id}', 'getPaymentInfo')->name('get.paymentInfo');
                    Route::get('/ecommerce-order/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::post('/ecommerce-order/update-order-payment/{id}', 'updatePayment')->name('payment.update');
                    Route::post('/ecommerce-order/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::get('/ecommerce-order/edit/{id}', 'edit')->name('edit');
                    Route::put('/ecommerce-order/update/{id}', 'update')->name('update');
                    Route::get('/ecommerce-order/show/{id}', 'show')->name('show');
                    Route::get('/ecommerce-order/invoice/print/{id}', 'printInvoice')->name('invoice.print');

                });
                Route::controller(WalletController::class)->name('wallet.')->group(function () {
                    Route::get('/wallet/transactions', 'index')->name('index');
                    Route::get('/transactions/data', 'data')->name('transaction.data');
                    Route::post('/deposit/store', 'storeDeposit')->name('deposit');
                    Route::post('/withDraw/store', 'storeWithDraw')->name('withdraw');
                    Route::get('/deposit/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::get('/wallet/getPaymentReceiptStatus/{id}', 'getPaymentReceiptStatus')->name('getPaymentReceiptStatus');
                    Route::post('/wallet/approve', 'approve')->name('approve');
                    Route::post('/wallet/reject', 'reject')->name('reject');
                    Route::post('/wallet/credit/debit', 'CreditDebit')->name('credit.debit');
                });
                Route::controller(BrandController::class)->name('brand.')->group(function () {
                    Route::get('/brand', 'index')->name('index');
                    Route::get('/brand/data', 'data')->name('data');
                    Route::get('/brand/create', 'create')->name('create');
                    Route::post('/brand/store', 'store')->name('store');
                    Route::get('/brand/edit/{id}', 'edit')->name('edit');
                    Route::post('/brand/update/{id}', 'update')->name('update');
                    Route::delete('/brand/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(CouponController::class)->name('coupon.')->group(function () {
                    Route::get('/coupon', 'index')->name('index');
                    Route::get('/coupon/data', 'data')->name('data');
                    Route::get('/coupon/create', 'create')->name('create');
                    Route::post('/coupon/store', 'store')->name('store');
                    Route::get('/coupon/edit/{id}', 'edit')->name('edit');
                    Route::post('/coupon/update/{id}', 'update')->name('update');
                    Route::delete('/coupon/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(EmailTemplateController::class)->name('email.templates.')->group(function () {
                    Route::get('/email/templates', 'index')->name('index');
                    Route::get('/email/templates/data', 'data')->name('data');
                    Route::get('/email/templates/create', 'create')->name('create');
                    Route::post('/email/templates/store', 'store')->name('store');
                    Route::get('/email/templates/edit/{id}', 'edit')->name('edit');
                    Route::put('/email/templates/update/{id}', 'update')->name('update');
                    Route::delete('/email/templates/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(ConsolidateController::class)->name('consolidate.')->group(function () {
                    Route::get('/consolidate', 'index')->name('index');
                    Route::get('/consolidate/data', 'data')->name('data');
                    Route::get('/consolidate/create', 'create')->name('create');
                    Route::get('/consolidate/show/{id}', 'show')->name('show');
                    Route::get('/parcel/invoice/{id}', 'invoicePrint')->name('invoice');
                    Route::post('/consolidate/store', 'store')->name('store');
                    Route::get('/consolidate/getpickupstation', 'getPickupStation')->name('getPickupStation');
                    Route::get('/consolidate/edit/{id}', 'edit')->name('edit');
                    Route::get('/consolidate/item/edit/{id}', 'itemEdit')->name('item.edit');
                    Route::get('/consolidate/imagesget/{id}', 'imagesGet')->name('imagesGet');
                    Route::put('/consolidate/item/update/{id}', 'itemUpdate')->name('item.update');
                    Route::post('/consolidate/files/store', 'fileStore')->name('file.store');
                    Route::post('/consolidate/update/{id}', 'update')->name('update');
                    Route::delete('/consolidate/destroy/{id}', 'destroy')->name('destroy');
                    Route::delete('/consolidate/item/destroy/{id}/{cid}', 'itemDestroy')->name('item.destroy');
                    Route::get('/consolidate/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::put('/consolidate/approvedpayment/{id}', 'approvedPayment')->name('approvedPayment');
                    Route::post('/consolidate/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::put('/consolidate/changeinvoicestatus/{id}', 'changeInvoiceStatus')->name('changeInvoiceStatus');
                    Route::put('/consolidate/delivery-date/update', 'updateDeliveryDate')->name('deliveryDate.update');
                });
                Route::controller(CalendarController::class)->name('calendar.')->group(function () {
                    Route::get('/calendar', 'index')->name('index'); 
                    Route::get('/calendar/parcels', 'parcels')->name('parcel'); 
                    Route::get('/calendar/orders', 'orders')->name('order'); 
                    Route::get('/calendar/consolidates', 'consolidates')->name('consolidate'); 
                });
                Route::controller(PurchaseCategoryController::class)->name('purchase.category.')->group(function () {
                    Route::get('/purchase/category', 'index')->name('index');
                    Route::get('/purchase/category/data', 'data')->name('data');
                    Route::get('/purchase/category/create', 'create')->name('create');
                    Route::post('/purchase/category/store', 'store')->name('store');
                    Route::get('/purchase/category/edit/{id}', 'edit')->name('edit');
                    Route::post('/purchase/category/update/{id}', 'update')->name('update');
                    Route::delete('/purchase/category/destroy/{id}', 'destroy')->name('destroy');
                });
                Route::controller(NotificationController::class)->name('notification.')->group(function () {
                    Route::get('/read/all/notification', 'markAllRead')->name('markAllRead');
                    Route::get('/read/notification', 'markAsRead')->name('markAsRead');
                });

                Route::controller(CarCalculatorController::class)->name('carCalculator.')->group(function () {
                    Route::get('/car-calculator', 'index')->name('index');
                    Route::get('/car-calculator/models', 'getModels')->name('getModels');
                });

                Route::controller(ShippingCalculatorController::class)->name('shippingCalulator.')->group(function () {
                    Route::get('/shipping/calculator', 'index')->name('index'); 
                    Route::post('/shipping/calculator/store', 'store')->name('store'); 
                });
            }
        );
    }
);


Route::group(
    ['namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth','verified'] ],
    function () {

        Route::group(
            ['prefix' => 'user', 'as' => 'user.'],
            function () {
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/check/shipping/alert', 'checkShipper')->name('checkShipper');
                });

                Route::controller(ShippingAddressController::class)->name('shipping-address.')->group(function () {
                    Route::get('/shipping-address', 'index')->name('index');
                    Route::get('/shipping-address/create', 'create')->name('create');
                    Route::post('/shipping-address/store', 'store')->name('store');
                    Route::get('/shipping-address/edit/{id}', 'edit')->name('edit');
                    Route::put('/shipping-address/update/{id}', 'update')->name('update');
                    Route::delete('/shipping-address/destroy/{id}', 'destroy')->name('destroy');
                });

                Route::middleware('address')->controller(AccountController::class)->name('account.')->group(function () {
                    Route::get('/account', 'userAccount')->name('index');
                    Route::put('/update/{id}', 'updateAccount')->name('update');
                    Route::get('/account/privacy', 'userProfilePrivacy')->name('profile.view');
                    Route::post('/account/privacy/update/{id}', 'updateProfilePrivacy')->name('privacy.update');
                    Route::post('/account/password/update/{id}', 'updatePassword')->name('password.update');
                });

                Route::middleware('address')->controller(RateController::class)->name('rate.')->group(function () {
                    Route::get('/rate', 'index')->name('index');
                    Route::get('/rate/data', 'data')->name('data');
                });

                Route::middleware('address')->controller(OrderController::class)->name('purchasing.')->group(function () {
                    Route::get('/order/list', 'index')->name('order.list');
                    Route::get('/order/data', 'data')->name('order.data');
                    Route::get('/order/pendingorder', 'pendingOrders')->name('order.pendingOrders');
                    Route::get('/order/create', 'create')->name('create');
                    Route::get('/order/create/item', 'createItem')->name('create.item');
                    Route::post('/purchase/cart', 'addToCart')->name('product.cart');
                    Route::get('/get-cart-data', 'getCardData')->name('get.cart');
                    Route::get('/edit-cart-data', 'editCardData')->name('cart.edit');
                    Route::post('/update-cart-data', 'updateCardData')->name('update.cart');
                    Route::post('/purchase/checkout', 'store')->name('product.checkout');
                    Route::delete('remove-from-cart', 'removeFromCart')->name('remove.from.cart');

                    Route::get('/order/show/{id}', 'show')->name('order.show');

                    Route::post('/get-site-content', 'getSiteContent')->name('url.content');

                    // order payment charge routes
                    Route::get('/charge/create/{id}', 'createCharge')->name('charge.create');
                    Route::post('/charge/store', 'storeCharge')->name('charge.store');
                    Route::get('/charge/edit/{id}', 'editCharge')->name('charge.edit');
                    Route::put('/charge/update/{id}', 'updateCharge')->name('charge.update');
                    Route::delete('/charge/delete/{id}', 'deleteCharge')->name('charge.delete');
                    Route::get('/charge/getpaymenthtml/{id}', 'getChargePaymentHtml')->name('getChargePaymentHtml');
                    //end order payment charge routes

                    Route::get('/order/invoice/print/{id}', 'printInvoice')->name('order.invoice.print');

                    Route::get('/add-payment/{id}', 'addPayment')->name('payment.add');
                    Route::post('/update-order-payment/{id}', 'updatePayment')->name('payment.update');
                    Route::get('/order/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::get('/order/getPaymentInfo/{id}', 'getPaymentInfo')->name('get.paymentInfo');
                });
                Route::controller(ParcelController::class)->name('parcel.')->group(function () {
                    Route::post('/parcel/addreciever', 'addRecieverAddress')->name('addreciever');
                });
                Route::middleware('address')->controller(ParcelController::class)->name('parcel.')->group(function () {
                    Route::get('/parcels', 'index')->name('index');
                    
                    Route::get('/pending/parcels', 'pendingParcels')->name('pendingParcels');
                    Route::get('/archived/parcels', 'archivedParcels')->name('archivedParcels');
                    Route::get('/parcel/show/{id}', 'show')->name('show');
                    Route::get('/parcel/data', 'data')->name('data');
                    Route::post('/parcel/draft/', 'toDraft')->name('toDraft');
                    Route::post('/parcel/add-receipt/', 'addReceipt')->name('addReceipt');
                    Route::get('/drafted/parcels', 'draftedParcels')->name('draftedParcels');
                    Route::get('/parcel/create', 'create')->name('create');
                    Route::get('/parcel/calculate/ajax', 'calAjax')->name('calAjax.data');
                    Route::get('/parcel/calculate/', 'calculateParcel')->name('calculateParcel');
                    Route::get('/parcel/getusers', 'getUsers')->name('getusers');
                    Route::get('/parcel/checkReciverAdd', 'checkReciverAdd')->name('checkReciverAdd'); 
                    Route::post('/parcel/exists/data/{tracking}', 'parcelData')->name('exist.data');
                    Route::post('/parcel/addSender', 'addSenderAddress')->name('addSender');
                    Route::get('/parcel/getrecieverhtml', 'getRecieverhtml')->name('getrecieverhtml');
                    Route::get('/parcel/getsenderhtml', 'getSenderhtml')->name('getsenderhtml');
                    Route::get('/parcel/getpickupstation', 'getPickupStation')->name('getPickupStation');
                    Route::get('/parcel/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::get('/parcel/getTracking/{id}', 'getParcelTracking')->name('getTracking');
                    Route::put('/parcel/changeinvoicestatus/{id}', 'changeInvoiceStatus')->name('changeInvoiceStatus');
                    Route::put('/parcel/delivery-date/update', 'updateDeliveryDate')->name('deliveryDate.update');
                    Route::get('/parcel/imagesget/{id}', 'imagesGet')->name('imagesGet');
                    Route::post('/parcel/store', 'store')->name('store');
                    Route::post('/parcel/files/store', 'fileStore')->name('file.store');
                    Route::get('/parcel/edit/{id}', 'edit')->name('edit');
                    Route::get('/parcel/invoice/print/{id}', 'print')->name('print');
                    Route::get('/parcel/invoice/invoice/{id}', 'invoicePrint')->name('invoice');
                    Route::get('/parcel/invoice/invoice/label/{id}', 'invoiceLabel')->name('invoice.label');
                    Route::post('/parcel/update/{id}', 'update')->name('update');
                    Route::delete('/parcel/destroy/{id}', 'destroy')->name('destroy');
                });

                Route::middleware('address')->controller(WalletController::class)->name('wallet.')->group(function () {
                    Route::get('/wallet/transactions', 'index')->name('index');
                    Route::get('/transactions/data', 'data')->name('transaction.data');
                    Route::post('/deposit/store', 'storeDeposit')->name('deposit');
                    Route::post('/withDraw/store', 'storeWithDraw')->name('withdraw');
                    Route::get('/deposit/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::get('/wallet/getPaymentReceiptStatus/{id}', 'getPaymentReceiptStatus')->name('getPaymentReceiptStatus');
                });
                Route::middleware('address')->controller(ShippingCalculatorController::class)->name('shipping.calculator.')->group(function () {
                    Route::get('/shipping/calculator', 'index')->name('index'); 
                    Route::post('/shipping/calculator/store', 'store')->name('store'); 
                });
                Route::middleware('address')->controller(ConsolidateController::class)->name('consolidate.')->group(function () {
                    Route::get('/consolidate', 'index')->name('index');
                    Route::get('/consolidate/data', 'data')->name('data'); 
                    Route::get('/consolidate/show/{id}', 'show')->name('show');
                    Route::post('/consolidate/store', 'store')->name('store');
                    Route::get('/parcel/invoice/{id}', 'invoicePrint')->name('invoice'); 
                    Route::get('/consolidate/imagesget/{id}', 'imagesGet')->name('imagesGet'); 
                    Route::get('/consolidate/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml'); 
                    Route::post('/consolidate/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::put('/consolidate/delivery-date/update', 'updateDeliveryDate')->name('deliveryDate.update'); 
                });
                Route::middleware('address')->controller(NotificationController::class)->name('notification.')->group(function () {
                    Route::get('/read/all/notification', 'markAllRead')->name('markAllRead');
                    Route::get('/read/notification', 'markAsRead')->name('markAsRead');
                });

                Route::middleware('address')->controller(OnlineStoreController::class)->name('online-store.')->group(function () {
                    Route::get('/online-store', 'index')->name('index'); 
                    Route::get('/online-store/search', 'search')->name('search'); 
                    // Cart section
                    Route::post('/add-to-cart/{id}/{user_id}','addToCart')->name('add-to-cart');
                    Route::delete('cart-delete/{id}','cartDelete')->name('cart-delete');
                    Route::get('online-store/cart','cartHtml')->name('cartHtml');
                    Route::get('online-store/show/{id}','show')->name('show');
                    Route::post('online-store/coupon-apply','applyCoupon')->name('coupon-apply');

                });
                Route::middleware('address')->controller(ECOrderController::class)->name('ec-order.')->group(function () {
                    Route::get('/ecommerce-order/list/{status?}', 'index')->name('list');
                    Route::get('/ecommerce-order/data', 'data')->name('data');
                    Route::post('/ecommerce-order/store','store')->name('store');
                    Route::get('ecommerce-order/add-payment/{id}', 'addPayment')->name('payment.add');
                    Route::get('/ecommerce-order/getPaymentInfo/{id}/{user_id}', 'getPaymentInfo')->name('get.paymentInfo');
                    Route::get('/ecommerce-order/getpaymenthtml/{id}', 'getPaymentHtml')->name('getPaymentHtml');
                    Route::post('/ecommerce-order/update-order-payment/{id}', 'updatePayment')->name('payment.update');
                    Route::post('/ecommerce-order/updatepaymentstatus', 'updatePaymentStatus')->name('paymentStatus.update');
                    Route::get('/ecommerce-order/edit/{id}', 'edit')->name('edit');
                    Route::put('/ecommerce-order/update/{id}', 'update')->name('updaet');
                    Route::get('/ecommerce-order/show/{id}', 'show')->name('show');
                    Route::get('/ecommerce-order/invoice/print/{id}', 'printInvoice')->name('invoice.print');

                });

                Route::middleware('address')->controller(CarCalculatorController::class)->name('carCalculator.')->group(function () {
                    Route::get('/car-calculator', 'index')->name('index');
                    Route::get('/car-calculator/models', 'getModels')->name('getModels');
                });

                Route::middleware('address')->controller(CalendarController::class)->name('calendar.')->group(function () {
                    Route::get('/calendar', 'index')->name('index'); 
                    Route::get('/calendar/parcels', 'parcels')->name('parcel'); 
                    Route::get('/calendar/orders', 'orders')->name('order'); 
                    Route::get('/calendar/consolidates', 'consolidates')->name('consolidate'); 
                });
            }
        );
    }
);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
