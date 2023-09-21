<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(protected FileService $FileService)
    {
    }
    public function index()
    {
        $product = Product::orderBy('id','desc')->get()->map(function($item) {
            $item->timeFormat = $item->created_at->format('Y/m/d');
            return $item;
        });
        return Inertia::render('Backend/Product/Index',[ 'response' => rtFormat($product)]);
    }

    public function product_create()
    {
        return Inertia::render('Backend/Product/CreateProduct');
    }

    public function product_store(Request $request)
    {
        // dd($request->image);
        $request->validate([
            'name' => 'required|max:255|string',
            'price' => 'required|min:0|numeric',
            'public' => 'required|numeric',
            'desc' => 'max:255',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'public' => $request->public,
            'desc' => $request->desc,
            'image' => $this->FileService->base64Upload($request->image, 'product'),
        ]);

        foreach ($request->otherImage ?? [] as $key => $value) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $this->FileService->base64Upload($value['image'], 'otherImage'),
            ]);
        }

        return back()->with(['message' => rtFormat($product)]);
    }

    public function product_delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
        $product = Product::find($request->id);
        $this->FileService->deleteUpload($product->image);
        $product->delete();

        return back()->with(['message' => rtFormat($product)]);
    }

    public function product_edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect(route('product.list'))->with(['message' => rtFormat($id, 0, '查無資料')]);
        }
        return Inertia::render('Backend/Product/EditProduct', ['response'=>rtFormat($product)]);
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'formData.name' => 'required|max:25|string',
            'formData.price' => 'required|min:0|numeric',
            'formData.public' => 'required|numeric',
            'formData.desc' => 'max:255',
            'id' => 'required|exists:products,id'
        ],[
            'formData.name.max' => '字數不可超過25字',
            'formData.name.required' => '商品名稱必填',
            'formData.price.required' => '商品價格必填',
            'formData.price.min' => '不可低於0元',
            'formData.price.numeric' => '請填入數字',
        ]);
        $product = Product::find($request->id);

        //寫法一
        // $product->update([
        //     'name' => $request->formData['name'],
        //     'price' => $request->formData['price'],
        //     'public' => $request->formData['public'],
        //     'desc' => $request->formData['desc'],
        // ]);

        //寫法二
        $formData = (object)$request->formData;
        $product->update([
            'name' => $formData->name,
            'price' => $formData->price,
            'public' => $formData->public,
            'desc' => $formData->desc,
            'image' => $this->FileService->base64Upload($formData->image, 'product'),
        ]);

        return back()->with(['message' => rtFormat($product)]);
    }
}
