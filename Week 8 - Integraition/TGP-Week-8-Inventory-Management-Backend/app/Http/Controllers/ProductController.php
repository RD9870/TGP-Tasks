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

            if ($request->has('q')) {

                $request->validate([
                    'q'=> 'required|string|min:1'
                ]);
                $keyWord = $request->q;

                $results = Product::where('name','like' ,"%{$keyWord}%")->get();

                    return response()->json($results);

            }
    $products = Product::with(['subcategory', 'manufacture', 'importCompany']) ->paginate(5);

    return response()->json($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
{
    $data = $request->validated();


    $product = Product::create([
            'code'=> $request->code,
            'name'=> $request->name,
            'subcategory_id'=> $request->subcategory_id,
            'price'=> $request->price,
            'manufacture_id'=> $request->manufacture_id,
            'import_company_id'=> $request->import_company_id,
            'minimum'=> $request->minimum,
    ]);


    $product->stock()->create([
        'quantity' => $request->quantity,
        'cost_price' => $request->cost_price,
         'isStockLow' => $request->quantity < $request->minimum,
    ]);

    return response()->json([
        'message' => 'Product and stock created successfully',
        'product' => $product->load('stock')], 201);
}

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $product = Product::with(['subcategory', 'manufacture', 'importCompany'])->find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json($product);
}


    /**
     * Update the specified resource in storage.
     */
  public function update(UpdateProductRequest $request, string $id)
{
    $product = Product::findOrFail($id);

    $data = $request->validated();

    if (array_key_exists('quantity', $data)) {
        $data['isStockLow'] = $data['quantity'] < 10;
    }

    $product->update($data);

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
    $product = Product::findOrFail($id);

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ], 200);
}

public function productsOverview(int $limit){
    $bestProducts = Receipt_items::join('products', 'receipt_items.product_id', '=', 'products.id')
        ->select('receipt_items.product_id', 'products.code', 'products.name', 'products.image', 'products.price', DB::raw('SUM(quantity) as total_quantity'))
    ->groupBy('product_id')
    ->orderBy('total_quantity', 'desc')
    ->limit($limit)
    ->get();

    $worstProducts = Receipt_items::join('products', 'receipt_items.product_id', '=', 'products.id')
        ->select( 'receipt_items.product_id', 'products.code', 'products.name', 'products.image', 'products.price', DB::raw('SUM(quantity) as total_quantity'))
    ->groupBy('product_id')
    ->orderBy('total_quantity', 'ASC')
    ->limit($limit)
    ->get();


    return response()->json(
        ['best sellers' => $bestProducts,
        'worst sellers' => $worstProducts,]
    );
}

public function lowStockCount(){
        $items = Product::select('image','id','name')->where('isStockLow', true)->get();
            return response()->json(
        ['number-of-low-stock-items' => $items->count(),
        'items'=> $items
        ]
    );
}


public function filterBySub(string $subCat){
    $sub = Subcategory::select('id')->where('name',$subCat)->first();

    $items = Product::select()->where('subcategory_id', $sub->id)->get();

         return response()->json(
        ['number-results' => $items->count(),
        'results'=> $items,

         ]);
}


}
