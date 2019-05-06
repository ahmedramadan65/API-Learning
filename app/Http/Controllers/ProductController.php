<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Resources\ProductCollection;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth:api')->except('index','show');
    }
    public function index()
    {
       return  ProductCollection::collection(Product::paginate(25));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->save();
        return response([
            'data'=> new ProductResource ($product)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {        
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {   
        $this->productUserCheck($product);
        $product->update($request->all());
        return response([
            'data'=> new ProductResource ($product)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {   
        $this->productUserCheck($product);
        $product->delete();
        return response(null,204);
    }
    
    public function productUserCheck($product){
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
}
