<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

use Illuminate\Support\Str;

use App\Models\ProductImage;

use App\Models\SubCategory;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\ProductTag;

class ProductController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        return view('admin.ecommerce.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        return view('admin.ecommerce.product.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
       
        $product = new Product;
        $product->title = (isset($request->title)) ? $request->title : '';
        $product->slug = (isset($request->title)) ? Str::slug($request->title) : '';
        $product->cat_id = (isset($request->category)) ? $request->category : 1;
        $product->child_cat_id = (isset($request->sub_category)) ? $request->sub_category : 1;
        $product->price = (isset($request->price)) ? $request->price : 0;
        $product->size = (isset($request->size)) ? $request->size : 'M';
        $product->discount =(isset($request->discount)) ? $request->discount : 0;
        $product->brand_id = (isset($request->brand)) ? $request->brand : 1;
        $product->condition = (isset($request->condition)) ? $request->condition : 'default';
        $product->status = (isset($request->status)) ? $request->status : 'active';
        $product->tax = (isset($request->tax)) ? $request->tax : 0;
        $product->shipping_price = (isset($request->shipping_price)) ? $request->shipping_price : 0;
        $product->stock = (isset($request->stock)) ? $request->stock : 0; 
        $product->description = (isset($request->product_desc)) ? $request->product_desc : '';
        $product->is_featured = ($request->is_featured == 'on') ? 1 : 0;
        $product->save();
        $product->tags()->sync($request->product_tags);
        $notify = [
            'success' => "Product has been Updated.",
            'redirect' => route('product.index'),
            'id' => $product->id,
             ];

        return $notify;
    }
    
    public function fileStore(Request $request) {

        $this->fileUploadMultiple($request->file, $request->product_id);

    }

    public function getSubCategories(Request $request) {

        $subCategories = SubCategory::where('category_id',$request->cat_id)->pluck('title','id')->toArray();
        return $subCategories;

    }

    public function fileUploadMultiple($files, $id = null)
    {

        if (isset($files)) {

            foreach ($files as $key => $value) {

                $parcelImage = new ProductImage();

                $parcelImage->name = $value->getClientOriginalName();

                $parcelImage->hash_name = $value->hashName();

                $parcelImage->size = $value->getSize();

                $parcelImage->type = $value->getClientOriginalExtension();

                $parcelImage->product_id = $id;

                $parcelImage->save();

                $value->storeAs('assets/product/', $value->hashName());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $subcategories = SubCategory::where('category_id',$product->cat_id)->get();
        $tags = ProductTag::where('product_id',$id)->get();
        return view('admin.ecommerce.product.edit', ['product' => $product,'tags' => $tags,'subcategories' => $subcategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->title = (isset($request->title)) ? $request->title : '';
        if($product->title != $request->title){
            $product->slug = (isset($request->title)) ? Str::slug($request->title) : '';
        } 
        $product->cat_id = (isset($request->category)) ? $request->category : 1;
        $product->child_cat_id = (isset($request->sub_category)) ? $request->sub_category : 1;
        $product->price = (isset($request->price)) ? $request->price : 0;
        $product->size = (isset($request->size)) ? $request->size : 'M';
        $product->discount =(isset($request->discount)) ? $request->discount : 0;
        $product->brand_id = (isset($request->brand)) ? $request->brand : 1;
        $product->condition = (isset($request->condition)) ? $request->condition : 'default';
        $product->stock = (isset($request->stock)) ? $request->stock : 0; 
        $product->description = (isset($request->product_desc)) ? $request->product_desc : '';
        $product->is_featured = ($request->is_featured == 'on') ? 1 : 0;
        $product->status = (isset($request->status)) ? $request->status : 'active';
        $product->tax = (isset($request->tax)) ? $request->tax : 0;
        $product->shipping_price = (isset($request->shipping_price)) ? $request->shipping_price : 0;
        $product->save();
        $product->tags()->sync($request->product_tags);
        $notify = [
            'success' => "Product has been Updated.",
            'redirect' => route('product.index'),
             ];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        $notify = ['success' => "Shipment Mode has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = Product::get();

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
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">
                        <li><a class="dropdown-item product-data-edit" href="' .route("product.edit",[$row->id]). '" data-product-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item product-data-delete" href="#" data-product-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('sub_category', function ($row) {
                return $row->subCategory->title;
            })
            ->addColumn('category', function ($row) {
                return $row->category->title;
            })
            ->addColumn('price', function ($row) {
                return $row->price;
            })
            ->addColumn('status', function ($row) {
                return $row->price;
            })
            ->addColumn('stock', function ($row) {
                return $row->stock;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['action', 'created_at', 'name'])
            ->make(true);
    }
}
