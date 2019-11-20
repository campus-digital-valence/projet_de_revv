<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Payment::with('paymentMethod')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Type opération',
            'Identifiant opération',
            'Montant',
            'Identifiant membre',
            'Type paiement',
            'Date de création',
            'Date de mise à jour',
        ];
    }

    public function map($payment): array
    {
        $payments = $payment->toArray();
        foreach ($payments as $key => $value) {
            if (is_string($value) && $key == 'payment_type') {
                if ($value == 'App\Subscription') {
                    $payments[$key] = 'Adhesion';
                } else {
                    $payments[$key] = 'Donnation';
                }
            }
            if (is_int($value) && $key == 'payment_method_id') {
                if ($value == 1) {
                    $payments[$key] = $payment->paymentMethod->name;
                } elseif ($value == 2) {
                    $payments[$key] = $payment->paymentMethod->name;
                } elseif ($value == 3) {
                    $payments[$key] = $payment->paymentMethod->name;
                } elseif ($value == 4) {
                    $payments[$key] = $payment->paymentMethod->name;
                } elseif ($value == 5) {
                    $payments[$key] = $payment->paymentMethod->name;
                }
            }
        }

        return [
            $payments['id'],
            $payments['payment_type'],
            $payments['payment_id'],
            $payments['amount'],
            $payments['user_id'],
            $payments['payment_method_id'],
            $payments['created_at'],
            $payments['updated_at'],
        ];
    }
}
