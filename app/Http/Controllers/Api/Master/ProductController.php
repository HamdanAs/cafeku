<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {


        $product = Product::create([
            'code'      => 'product-code',
            'name'      => $request->name,
            'price'     => $request->price,
            'picture'   => 'product-picture',
            'stock'     => 0
        ]);

        return $this->sendResponse($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try {
            return $this->sendResponse($product);
        } catch (ModelNotFoundException $e){
            return $this->sendError("Data tidak ditemukan");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'name'      => $request->name,
            'price'     => $request->price,
            'picture'   => 'product-picture',
        ]);

        return $this->sendResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->sendResponse($product);
    }

    public function updateStock(Request $request, Product $product)
    {
        $stock = $product->getAttributeValue('stock');

        $product->update(['stock' => $stock + $request->amount]);

        return $this->sendResponse($product);
    }
}
