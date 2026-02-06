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
    // get all receipt items with their associated product and stock information
    $profits = Receipt_items::with('product.stock')
        ->get()
        ->groupBy('product_id')
        // calculate the profit for each product
        ->map(function ($items, $productId) {
            $firstItem = $items->first();
            $totalQuantity = $items->sum('quantity');
             $profit = ($firstItem->product->price - $firstItem->product->stock->cost_price) * $totalQuantity;
            // return the profit details for the product
            return [
                'product' => $firstItem->product->name,
                'quantity_sold' => $totalQuantity,
                'profit' => $profit
            ];
        })->values();
        // return the profits as a JSON response
        return response()->json($profits);
}


public function monthlyProfitRate()
    {
        // get the current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
        // get the receipts for the current month and year
        $receipts = Receipt::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();
        // initialize the total profit variable
        $totalProfit = 0;
        // calculate the total profit for the month
        foreach ($receipts as $receipt) {
            foreach ($receipt->items as $item) {
                $totalProfit += ($item->product->price - $item->product->stock->cost_price) * $item->quantity;
            }
        }
        // return the monthly profit rate as a JSON response
        return response()->json([
            'month' => $currentMonth,
            'year' => $currentYear,
            'total_profit' => $totalProfit
        ]);
    }
}
