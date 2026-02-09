<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\VehicleTransfer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['transfer', 'transfer.vehicle'])
            ->latest()
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function store(Request $request, $transfer_id)
    {
        $request->validate([
            'total_price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:100',
            'payment_notes' => 'nullable|string',
        ]);

        $payment = Payment::create([
            'transfer_id' => $transfer_id,
            'total_price' => $request->total_price,
            'amount_paid' => $request->amount_paid,
            'amount_received' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'payment_notes' => $request->payment_notes,
            'payment_date' => now(),
        ]);

        // Update transfer status if fully paid
        $transfer = VehicleTransfer::find($transfer_id);
        if ($request->amount_paid >= $request->total_price) {
            $transfer->update(['status' => 'completed']);
        }

        return redirect()->route('vehicle-transfers.show', $transfer_id)
            ->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['transfer', 'transfer.vehicle', 'transfer.buyer', 'transfer.seller']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:100',
            'payment_notes' => 'nullable|string',
        ]);

        $payment->update([
            'amount_paid' => $request->amount_paid,
            'amount_received' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'payment_notes' => $request->payment_notes,
        ]);

        // Update transfer status
        $transfer = $payment->transfer;
        if ($request->amount_paid >= $payment->total_price) {
            $transfer->update(['status' => 'completed']);
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $transfer_id = $payment->transfer_id;
        $payment->delete();

        return redirect()->route('vehicle-transfers.show', $transfer_id)
            ->with('success', 'Payment deleted successfully!');
    }

    public function byTransfer($transfer_id)
    {
        $payments = Payment::where('transfer_id', $transfer_id)->get();
        return response()->json($payments);
    }

    public function generateReceipt($id)
    {
        $payment = Payment::with(['transfer', 'transfer.vehicle', 'transfer.buyer'])->findOrFail($id);
        return view('payments.receipt', compact('payment'));
    }
}
