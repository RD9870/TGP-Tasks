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
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $cashierId = Auth::id();

        $groupedItems = [];
        foreach ($request->items as $item) {
            $productId = $item['product_id'];
            if (!isset($groupedItems[$productId])) {
                $groupedItems[$productId] = 0;
            }
            $groupedItems[$productId] += $item['quantity'];
        }

        DB::beginTransaction();

        try {
            $totalReceipt = 0;

            $receipt = Receipt::create([
                'cashier_id' => $cashierId,
                'total' => 0,
            ]);

            foreach ($groupedItems as $productId => $quantity) {
                $product = Product::find($productId);

                if (!$product) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Product with ID {$productId} not found"
                    ], 404);
                }

                $stock = Stock::where('product_id', $productId)->first();

                if (!$stock) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Stock record not found for product {$product->name}"
                    ], 404);
                }

                if ($stock->quantity < $quantity) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Not enough stock for product {$product->name}"
                    ], 400);
                }

                $itemTotal = $product->price * $quantity;
                $totalReceipt += $itemTotal;

                $receipt->items()->create([
                    'recipt_id' => $receipt->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal,
                ]);

                $stock->decrement('quantity', $quantity);

                $stockAmmount = Stock::where('product_id', $productId)->sum('quantity');
                if ($stockAmmount  < $product->minimum) {
                    $product->isStockLow = true;
                    $product->save();
                }
            }

            $receipt->update([
                'total' => $totalReceipt
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Receipt created successfully',
                'receipt' => $receipt->load('items')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
