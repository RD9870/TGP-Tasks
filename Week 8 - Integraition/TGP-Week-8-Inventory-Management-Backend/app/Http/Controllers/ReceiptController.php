<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function store(Request $request)
    {
        // validate the incoming request data
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        // get the authenticated cashier's ID
        $cashierId = Auth::id();
        // initialize an array to group items by product ID
        $groupedItems = [];
        // loop through the items in the request and group them by product ID
        foreach ($request->items as $item) {
            $productId = $item['product_id'];
            // if this is the first time we see this product ID
            if (!isset($groupedItems[$productId])) {
                // initialize it with a quantity of 0
                $groupedItems[$productId] = 0;
            }
            // this is not the first time we see this product ID, so add to the total
            $groupedItems[$productId] += $item['quantity'];
        }
        // start a database transaction to ensure data integrity
        DB::beginTransaction(); //If any part of the process fails, we can roll back to this point
        try {
            // initialize the recipt total
            $totalReceipt = 0;
            // create a new receipt with the cashier's ID and a total of 0
            $receipt = Receipt::create([
                'cashier_id' => $cashierId,
                'total' => 0,
            ]);
            // loop through the grouped items
            foreach ($groupedItems as $productId => $quantity) {
                // create receipt items
                $product = Product::find($productId);
                // cancel the transaction if the product is not found
                if (!$product) {
                    DB::rollBack();
                    //return an error message
                    return response()->json([
                        'message' => "Product with ID {$productId} not found"
                    ], 404);
                }
                //update stock
                $stock = Stock::where('product_id', $productId)->first();
                // cancel the transaction if the stock record is not found or if there is not enough stock to fulfill the order
                if (!$stock) {
                    DB::rollBack();
                    // return an error message
                    return response()->json([
                        'message' => "Stock record not found for product {$product->name}"
                    ], 404);
                }
                // check if there is enough stock to fulfill the order
                if ($stock->quantity < $quantity) {
                    DB::rollBack();
                    // return an error message
                    return response()->json([
                        'message' => "Not enough stock for product {$product->name}"
                    ], 400);
                }
                // calculate the totsl for each item
                $itemTotal = $product->price * $quantity;
                // add it to the receipt total
                $totalReceipt += $itemTotal;
                // create the receipt item and associate it with the receipt
                $receipt->items()->create([
                    'recipt_id' => $receipt->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal,
                ]);
                // update the stock quantity for the product
                $stock->decrement('quantity', $quantity);
                //  check if the stock quantity is below the minimum
                $stockAmmount = Stock::where('product_id', $productId)->sum('quantity');
                if ($stockAmmount  < $product->minimum) {
                    //update the product's isStockLow
                    $product->isStockLow = true;
                    $product->save();
                }
            }
            // update the receipt total
            $receipt->update([
                'total' => $totalReceipt
            ]);
            // commit the transaction to save all changes to the database
            DB::commit();
            // return a success message with the created receipt and its items
            return response()->json([
                'message' => 'Receipt created successfully',
                'receipt' => $receipt->load('items')
            ], 201);
        }
        // if an error occurs
        catch (\Exception $e) {
            // roll back the transaction to undo changes
            DB::rollBack();
            // return an error message
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
