<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');
        $range = $request->input('range');
        $optionsChart = [];

        switch ($type) {
            case 'general':
                $chartTitle = "Nombre d'adhésions";
                $chartType = 'line';

                $dataRange = [];
                switch ($range) {
                    case 'days':
                        $datas = DB::table('subscriptions')->select(DB::raw('count(*) as subscription_count'),
                            DB::raw('CONCAT(YEAR(date_start), \'-\', MONTH(date_start), \'-\', DAY(date_start)) as date'))
                            ->whereBetween('date_start', [$dateStart, $dateEnd])
                            ->orderBy('date_start')
                            ->groupBy('date')
                            ->get();

                        $tableDate = [];
                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addDay()) {
                            $tableDate[$dateStartCarb->format('Y-n-j')] = 0;
                            array_push($dataRange, $dateStartCarb->toDateString());
                        }
                        break;

                    case 'months':
                        $datas = DB::table('subscriptions')->select(DB::raw('count(*) as subscription_count'),
                            DB::raw('CONCAT(YEAR(date_start), \'-\', MONTH(date_start), \'-1\') as date'))
                            ->whereBetween('date_start', [$dateStart, $dateEnd])
                            ->orderBy('date_start')
                            ->groupBy('date')
                            ->get();

                        $tableDate = [];
                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addMonth()) {
                            $tableDate[$dateStartCarb->format('Y-n-1')] = 0;
                            array_push($dataRange, $dateStartCarb->format('F-y'));
                        }
                        break;

                    case 'years':
                        $datas = DB::table('subscriptions')->select(DB::raw('count(*) as subscription_count'),
                            DB::raw('CONCAT(YEAR(date_start), \'-1-1\') as date'))
                            ->whereBetween('date_start', [$dateStart, $dateEnd])
                            ->orderBy('date_start')
                            ->groupBy('date')
                            ->get();

                        $tableDate = [];
                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addYear()) {
                            $tableDate[$dateStartCarb->format('Y-1-1')] = 0;
                            array_push($dataRange, $dateStartCarb->format('Y'));
                        }
                        break;
                    default:
                        return response()->json(['message' => 'Not Found !'], 404);
                }

                foreach ($datas as $data) {
                    $tableDate[$data->date] = $data->subscription_count;
                }

                $dataFinals = array_values($tableDate);

                $stepSize = round((max($dataFinals) - min($dataFinals)) / 10);

                $chartData = [
                    'labels' => $dataRange,
                    'datasets' => [
                        [
                            'label' => [$chartTitle],
                            'data' => $dataFinals,
                            'borderColor' => [
                                'rgba(77,136,255,1)',
                            ],
                            'backgroundColor' => [
                                'rgba(0,0,0,0)',
                            ],
                            'borderWidth' => 2,
                            'lineTension' => 0,
                        ],
                    ],
                ];

                $optionsChart = [
                    'scales' => [
                        'yAxes' => [
                            [
                                'ticks' => [
                                    'beginAtZero' => true,
                                    'stepSize' => $stepSize != 0 ? $stepSize : 1,
                                ],
                            ],

                        ],
                    ],
                ];
                break;
            case 'subscriptions':
                $chartType = 'pie';
                $chartTitle = 'Adhésions par type';

                $datas = DB::table('subscriptions')->select(DB::raw('count(*) as subscriptionType_count'))
                    ->whereBetween('date_start', [$dateStart, $dateEnd])
                    ->groupBy('subscription_type_id')
                    ->get();

                foreach ($datas as $key => $data) {
                    $dataArray[$key] = $data->subscriptionType_count;
                }

                $chartData = [
                    'labels' => [
                        'Sans emploi',
                        'Famille',
                        'Individuel',
                        'Etudiant',
                    ],
                    'datasets' => [
                        [
                            'label' => $chartTitle,
                            'data' => $dataArray,
                            'backgroundColor' => [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#69D76B',
                            ],
                        ],
                    ],
                ];

                break;
            case 'cities':
                $chartType = 'pie';
                $chartTitle = 'Adhérents par villes';

                $cities = [];
                $datas = DB::table('subscriptions')
                    ->join('users', 'user_id', '=', 'users.id')
                    ->whereBetween('date_start', [$dateStart, $dateEnd])
                    ->select(DB::raw('count(*) as subscribersByCity_count'), DB::raw('users.city as city'))
                    ->groupBy('users.city')
                    ->get();

                foreach ($datas as $key => $data) {
                    $dataArray[$key] = $data->subscribersByCity_count;
                    $cities[$key] = $data->city;
                }

                $chartData = [
                    'labels' => $cities,
                    'datasets' => [
                        [
                            'data' => $dataArray,
                            'backgroundColor' => [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#69D76B',
                                '#ff33bb',
                                '#b982ee',
                                '#c40012',
                                '#d2ceda',
                                '#9ca4f1',
                                '#b2f19c',

                            ],
                        ],
                    ],
                ];
                break;
            case 'receipts':
                $chartType = 'line';
                $chartTitle = ['Adhésions', 'Dons'];
                $dataRange = [];

                switch ($range) {
                    case 'days':
                        $datasSubs = DB::table('payments')
                            ->where('payment_type', '=', 'App\Subscription')
                            ->join('subscriptions', 'payment_id', '=', 'subscriptions.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                            DB::raw('CONCAT(YEAR(subscriptions.date_start), \'-\', MONTH(subscriptions.date_start),
                             \'-\', DAY(subscriptions.date_start)) as date'))
                            ->whereBetween('subscriptions.date_start', [$dateStart, $dateEnd])
                            ->orderBy('subscriptions.date_start')
                            ->groupBy('date')
                            ->get();

                        $datasGifts = DB::table('payments')
                            ->where('payment_type', '=', 'App\Gift')
                            ->join('gifts', 'payment_id', '=', 'gifts.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                                DB::raw('CONCAT(YEAR(gifts.created_at), \'-\', MONTH(gifts.created_at),
                             \'-\', DAY(gifts.created_at)) as date'))
                            ->whereBetween('gifts.created_at', [$dateStart, $dateEnd])
                            ->orderBy('gifts.created_at')
                            ->groupBy('date')
                            ->get();

                        $tableDateSubs = [];
                        $tableDateGifts = [];

                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addDay()) {
                            $tableDateSubs[$dateStartCarb->format('Y-n-j')] = 0;
                            $tableDateGifts[$dateStartCarb->format('Y-n-j')] = 0;
                            array_push($dataRange, $dateStartCarb->toDateString());
                        }
                        break;

                    case 'months':
                        $datasSubs = DB::table('payments')
                            ->where('payment_type', '=', 'App\Subscription')
                            ->join('subscriptions', 'payment_id', '=', 'subscriptions.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                                DB::raw('CONCAT(YEAR(subscriptions.date_start), \'-\', MONTH(subscriptions.date_start),
                             \'-1\') as date'))
                            ->whereBetween('subscriptions.date_start', [$dateStart, $dateEnd])
                            ->orderBy('subscriptions.date_start')
                            ->groupBy('date')
                            ->get();

                        $datasGifts = DB::table('payments')
                            ->where('payment_type', '=', 'App\Gift')
                            ->join('gifts', 'payment_id', '=', 'gifts.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                                DB::raw('CONCAT(YEAR(gifts.created_at), \'-\', MONTH(gifts.created_at),
                             \'-1\') as date'))
                            ->whereBetween('gifts.created_at', [$dateStart, $dateEnd])
                            ->orderBy('gifts.created_at')
                            ->groupBy('date')
                            ->get();

                        $tableDateSubs = [];
                        $tableDateGifts = [];
                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addMonth()) {
                            $tableDateSubs[$dateStartCarb->format('Y-n-1')] = 0;
                            $tableDateGifts[$dateStartCarb->format('Y-n-1')] = 0;
                            array_push($dataRange, $dateStartCarb->format('F-y'));
                        }

                        break;

                    case 'years':
                        $datasSubs = DB::table('payments')
                            ->where('payment_type', '=', 'App\Subscription')
                            ->join('subscriptions', 'payment_id', '=', 'subscriptions.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                                DB::raw('CONCAT(YEAR(subscriptions.date_start), \'-1-1\') as date'))
                            ->whereBetween('subscriptions.date_start', [$dateStart, $dateEnd])
                            ->orderBy('subscriptions.date_start')
                            ->groupBy('date')
                            ->get();

                        $datasGifts = DB::table('payments')
                            ->where('payment_type', '=', 'App\Gift')
                            ->join('gifts', 'payment_id', '=', 'gifts.id')
                            ->select(DB::raw('sum(payments.amount) as amountSum'),
                                DB::raw('CONCAT(YEAR(gifts.created_at), \'-1-1\') as date'))
                            ->whereBetween('gifts.created_at', [$dateStart, $dateEnd])
                            ->orderBy('gifts.created_at')
                            ->groupBy('date')
                            ->get();

                        $tableDateSubs = [];
                        $tableDateGifts = [];
                        $dateStartCarb = Carbon::parse($dateStart);
                        $dateEndCarb = Carbon::parse($dateEnd);

                        for ($dateStartCarb; $dateStartCarb <= $dateEndCarb; $dateStartCarb->addYear()) {
                            $tableDateSubs[$dateStartCarb->format('Y-1-1')] = 0;
                            $tableDateGifts[$dateStartCarb->format('Y-1-1')] = 0;
                            array_push($dataRange, $dateStartCarb->format('Y'));
                        }
                        break;
                    default:
                        return response()->json(['message' => 'Not Found !'], 404);
                }

                foreach ($datasSubs as $data) {
                    $tableDateSubs[$data->date] = (int) $data->amountSum;
                }

                foreach ($datasGifts as $data) {
                    $tableDateGifts[$data->date] = (int) $data->amountSum;
                }

                $dataFinals1 = array_values($tableDateSubs);
                $dataFinals2 = array_values($tableDateGifts);

                $stepSize1 = round((max($dataFinals1) - min($dataFinals1)) / 10);
                $stepSize2 = round((max($dataFinals2) - min($dataFinals2)) / 10);

                $stepSize = max($stepSize1, $stepSize2);

               // dd($stepSize);
                $chartData = [
                    'labels' => $dataRange,
                    'datasets' => [
                        [
                            'label' => [$chartTitle[0]],
                            'data' => $dataFinals1,
                            'borderColor' => [
                                'rgba(77,136,255,1)',
                            ],
                            'backgroundColor' => [
                                'rgba(0,0,0,0)',
                            ],
                            'borderWidth' => 2,

                        ],
                        [
                            'label' => [$chartTitle[1]],
                            'data' => $dataFinals2,
                            'borderColor' => [
                                'rgba(45,190,40,1)',
                            ],
                            'backgroundColor' => [
                                'rgba(0,0,0,0)',
                            ],
                            'borderWidth' => 2,

                        ],
                    ],
                ];

                $optionsChart = [
                    'scales' => [
                        'yAxes' => [
                            [
                                'ticks' => [
                                    'beginAtZero' => true,
                                    'stepSize' => $stepSize != 0 ? $stepSize : 1,
                                ],
                            ],

                        ],
                    ],
                ];
                break;
            default:
                return response()->json(['message' => 'Not Found !'], 404);
        }

        $json = [
            'type' => $chartType,
            'data' => $chartData,
            'options' => $optionsChart,
        ];

        return $json;
    }
}
