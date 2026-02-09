<?php

namespace App\Http\Controllers;

use App\Models\VehicleTransfer;
use App\Models\Payment;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function transferForm($id)
    {
        $transfer = VehicleTransfer::with([
            'vehicle',
            'buyer',
            'seller',
            'witness',
            'buyerSpouse',
            'payment'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.transfer-form', compact('transfer'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->stream('vehicle-transfer-' . $transfer->transfer_number . '.pdf');
    }

    public function paymentReceipt($id)
    {
        $payment = Payment::with(['transfer', 'transfer.vehicle', 'transfer.buyer'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.payment-receipt', compact('payment'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('receipt-' . $payment->id . '.pdf');
    }

    public function customerDetails($id)
    {
        $customer = Customer::with([
            'boughtTransfers.vehicle',
            'soldTransfers.vehicle'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.customer-details', compact('customer'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('customer-' . $customer->citizenship_number . '.pdf');
    }
}
