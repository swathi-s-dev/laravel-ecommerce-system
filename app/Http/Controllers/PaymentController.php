<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    // List all payments
    public function index()
    {
        $payments = Payment::with('order.customer')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'payments' => $payments
        ]);
    }

    // Load create form data
    public function create()
    {
        $orders = Order::with('customer')->latest()->get();

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    // Store payment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => [
                'required',
                Rule::in(['Cash', 'Card', 'UPI', 'Net Banking'])
            ],
            'transaction_id' => 'nullable|string|max:255',
            'status' => [
                'required',
                Rule::in(['Pending', 'Completed', 'Failed', 'Refunded'])
            ],
            'payment_date' => 'nullable|date',
        ]);

        $payment = Payment::create($validated);
        $payment->load('order.customer');

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully!',
            'payment' => $payment
        ], 201);
    }

    // Show one payment
    public function show(Payment $payment)
    {
        $payment->load('order.customer');

        return response()->json([
            'success' => true,
            'payment' => $payment
        ]);
    }

    // Update payment
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => [
                'required',
                Rule::in(['Cash', 'Card', 'UPI', 'Net Banking'])
            ],
            'transaction_id' => 'nullable|string|max:255',
            'status' => [
                'required',
                Rule::in(['Pending', 'Completed', 'Failed', 'Refunded'])
            ],
            'payment_date' => 'nullable|date',
        ]);

        $payment->update($validated);
        $payment->load('order.customer');

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully!',
            'payment' => $payment
        ]);
    }

    // Delete payment
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully!'
        ]);
    }
}
