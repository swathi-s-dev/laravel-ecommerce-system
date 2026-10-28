<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
{
    $customers = Customer::latest()->get();

    $products = Product::where('status', 1)
        ->latest()
        ->get();

    return view('orders.create', compact('customers', 'products'));
}

   public function show($id)
{
    $order = Order::with([
        'customer',
        'orderItems.product'
    ])->findOrFail($id);

    return response()->json([
        'success' => true,
        'order' => $order
    ]);
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'order_date' => 'required|date',
        'status' => 'required|in:Pending,Processing,Completed,Cancelled',
        'product_id' => 'required|array|min:1',
        'product_id.*' => 'required|distinct|exists:products,id',
        'quantity' => 'required|array|min:1',
        'quantity.*' => 'required|integer|min:1',
    ]);

    if (count($validated['product_id']) !== count($validated['quantity'])) {
        return response()->json([
            'message' => 'Each product must have a quantity.',
        ], 422);
    }

    $order = \Illuminate\Support\Facades\DB::transaction(
        function () use ($validated) {

            $total = 0;
            $items = [];

            foreach ($validated['product_id'] as $index => $productId) {

                // Get product and lock its stock during this transaction
                $product = Product::where('id', $productId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $validated['quantity'][$index];

                // Check available stock
                if ($product->stock < $quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => [
                            "Insufficient stock for {$product->name}. Available stock: {$product->stock}."
                        ],
                    ]);
                }

                $price = (float) $product->price;
                $subtotal = round($price * $quantity, 2);

                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];

                // REDUCE PRODUCT STOCK
                $product->decrement('stock', $quantity);
            }

            // Create order
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'total_amount' => round($total, 2),
                'status' => $validated['status'],
            ]);

            // Save ordered products
            $order->orderItems()->createMany($items);

            return $order;
        }
    );

    return response()->json([
        'success' => true,
        'message' => 'Order created successfully! Product stock updated.',
        'order_id' => $order->id,
    ], 201);
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully!'
        ]);
    }
}