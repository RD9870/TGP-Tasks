<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Receipt;
use App\Models\Receipt_items;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if the request has a query parameter 'q'
            if ($request->has('q')) {
            // validate the query parameter
                $request->validate([
                    'q'=> 'required|string|min:1'
                ]);
            // get the query parameter
                $keyWord = $request->q;
            // find product that contain the keyword in their name
                $results = Product::where('name','like' ,"%{$keyWord}%")->get();
            // return the results
                return response()->json($results);
            }
            // paginate the products with it's subcategory, manufacture and import company
                $products = Product::with(['subcategory', 'manufacture', 'importCompany']) ->paginate(5);
            // return the products
                return response()->json($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
{
    // validate the request data
    $request->validated();
    // create a new product with the details
    $product = Product::create([
            'code'=> $request->code,
            'name'=> $request->name,
            'subcategory_id'=> $request->subcategory_id,
            'price'=> $request->price,
            'manufacture_id'=> $request->manufacture_id,
            'import_company_id'=> $request->import_company_id,
            'minimum'=> $request->minimum,
    ]);
    // create a new stock for the product
    $product->stock()->create([
        'quantity' => $request->quantity,
        'cost_price' => $request->cost_price,
         'isStockLow' => $request->quantity < $request->minimum,
    ]);
    // return a success message and the product
    return response()->json([
        'message' => 'Product and stock created successfully',
        'product' => $product->load('stock')], 201);
}

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    // get the product with the specified id as wekk as it's subcategory, manufacture and import company
    $product = Product::with(['subcategory', 'manufacture', 'importCompany'])->find($id);
    // product does not existt
    if (!$product) {
        // return a not found message
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }
    // product exist, return the product
    return response()->json($product);
}


    /**
     * Update the specified resource in storage.
     */
  public function update(UpdateProductRequest $request, string $id)
{
    // find the product with the specified id
    $product = Product::findOrFail($id);
    // validate the request data
    $data = $request->validated();
    // set the isStockLow field based on the quantity
    if (array_key_exists('quantity', $data)) {
        $data['isStockLow'] = $data['quantity'] < 10;
    }
    // update the product
    $product->update($data);
    // return the response
    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // find the product with the specified id or return a not found message
    $product = Product::findOrFail($id);
    // delete the product
    $product->delete();
    // return a success message
    return response()->json([
        'message' => 'Product deleted successfully'
    ], 200);
}

public function productsOverview(int $limit){
    // join the receipt_items table with the products table
    $bestProducts = Receipt_items::join('products', 'receipt_items.product_id', '=', 'products.id')
    // select the product id, code, name, image, price
    ->select('receipt_items.product_id', 'products.code', 'products.name', 'products.image',
    // calculate the total quantity sold for each product
    'products.price', DB::raw('SUM(quantity) as total_quantity'))
    // group the results by product id
    ->groupBy('product_id')
    // order the results by total quantity sold in descending order
    ->orderBy('total_quantity', 'desc')
    // with the set limit
    ->limit($limit)
    ->get();

    // join products and receipt_items tables
    $worstProducts = Receipt_items::join('products', 'receipt_items.product_id', '=', 'products.id')
    // get the product id, code, name, image, price and total quantity sold for each product
    ->select( 'receipt_items.product_id', 'products.code', 'products.name', 'products.image', 'products.price', DB::raw('SUM(quantity) as total_quantity'))
    // group the results by product id
    ->groupBy('product_id')
    // order by quantity sold ascendimg
    ->orderBy('total_quantity', 'ASC')
    // with a set limit
    ->limit($limit)
    ->get();
    // return the best and worset products
    return response()->json(
        ['best sellers' => $bestProducts,
        'worst sellers' => $worstProducts,]
    );
}

public function lowStockCount(){
    // get product where the stock is low
    $items = Product::select('image','id','name')->where('isStockLow', true)->get();
        // return the products
        return response()->json(
            ['number-of-low-stock-items' => $items->count(),
            'items'=> $items
        ]
    );
}

public function filterBySub(string $subCat){
    // get thr subcategor id
    $sub = Subcategory::select('id')->where('name',$subCat)->first();
    // get the products with the specified subcategory id
    $items = Product::select()->where('subcategory_id', $sub->id)->get();
    // return the response
    return response()->json(
        ['number-results' => $items->count(),
        'results'=> $items,
        ]);
}
}
