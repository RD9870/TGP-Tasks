<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Receipt_items;
use App\Models\Product;

class ProfitController extends Controller
{
    public function detailedProfits()
{
    $profits = Receipt_items::with('product.stock')
        ->get()
        ->groupBy('product_id')
        ->map(function ($items, $productId) {
             $firstItem = $items->first();
            $totalQuantity = $items->sum('quantity');

             $profit = ($firstItem->product->price - $firstItem->product->stock->cost_price) * $totalQuantity;

            return [
                'product' => $firstItem->product->name,
                'quantity_sold' => $totalQuantity,
                'profit' => $profit
            ];
        })->values();
    return response()->json($profits);
}
    public function monthlyProfitRate()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $receipts = Receipt::whereMonth('created_at', $currentMonth)
                           ->whereYear('created_at', $currentYear)
                           ->get();

        $totalProfit = 0;

        foreach ($receipts as $receipt) {
            foreach ($receipt->items as $item) {
                $totalProfit += ($item->product->price - $item->product->stock->cost_price) * $item->quantity;
            }
        }

        return response()->json([
            'month' => $currentMonth,
            'year' => $currentYear,
            'total_profit' => $totalProfit
        ]);
    }
}
