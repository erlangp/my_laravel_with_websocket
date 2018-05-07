<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([], 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = (int) $request->price;

        if ($product->save()) {
            // Send message to websocket server
            $client = new \WebSocket\Client("ws://127.0.0.1:8092/");
            $client->send("New Product Created: {$product->id} , {$product->name} , {$product->price}");
            $client->send(json_encode([
                'code'=> 'NEW_PRODUCT_CREATED',
                'data' => [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price
                    ]
                ]
            ]));

            return response()->json([
                'success' => true,
                'description' => 'Product saved successfully.',
                'data' => [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price
                    ]
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'description' => 'Failed to save product'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json([], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([], 403);
    }
}
