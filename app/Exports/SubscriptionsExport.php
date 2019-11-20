<?php

namespace App\Exports;

use App\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Subscription::with('type')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Montant',
            'Stop relance',
            'Début',
            'Fin',
            'Source',
            'Identifiant membre',
            'Type',
            'Date de création',
            'Date de mise à jour',
        ];
    }

    public function map($sub): array
    {
        $subs = $sub->toArray();
        foreach ($subs as $key => $value) {
            if (is_int($value) && $key == 'subscription_source') {
                if ($value == 0) {
                    $subs[$key] = 'Agence';
                } else {
                    $subs[$key] = 'Application Web';
                }
            } elseif (is_int($value) && $key == 'subscription_type_id') {
                if ($value == 1) {
                    $subs[$key] = $sub->type->name;
                } elseif ($value == 2) {
                    $subs[$key] = $sub->type->name;
                } elseif ($value == 3) {
                    $subs[$key] = $sub->type->name;
                } elseif ($value == 4) {
                    $subs[$key] = $sub->type->name;
                }
            }
        }

        return [
            $subs['id'],
            $subs['amount'],
            $subs['opt_out_mail'],
            $subs['date_start'],
            $subs['date_end'],
            $subs['subscription_source'],
            $subs['user_id'],
            $subs['subscription_type_id'],
            $subs['created_at'],
            $subs['updated_at'],
        ];
    }
}
