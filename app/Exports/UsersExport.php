<?php

namespace App\Exports;

use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    private $settings;
    private $query;

    public function __construct($validate)
    {
        $this->settings = $validate;
    }

    public function query()
    {
        //init Query Builder with $query
        switch ($this->settings['state']) {
            case 'withTrashed':
                $query = User::query()->withTrashed();
                break;
            case 'onlyTrashed':
                $query = User::query()->onlyTrashed();
                break;
            default:
                $query = User::query();
        }
        //Check gifts relationship
        if (! is_null($this->settings['gift'])) {
            switch ($this->settings['gift']) {
                case 0:
                    $query = $query->has('gifts');
                    break;
                case 1:
                    $query = $query->doesntHave('gifts');
                    break;
                default:;
            }
        }
        /*todo
        *Mettre softdelete sur subs plus facile avec request sur subs
         * Que les comptes actifs sont pris dans le requete
         * sinon trouvé un moyen de check que latest
         *
         */

        //Type of last membership
        if (! is_null($this->settings['status'])) {
            switch ($this->settings['status']) {
                case 0:
                    $query = $query->whereHas('subscriptions', function ($sub) {
                        $sub->where('date_end', '>=', Carbon::now()->toDateString());
                    });
                    break;
                case 1:
                    $query = $query->whereHas('subscriptions', function ($sub) {
                        $sub->where('date_end', '<', Carbon::now()->toDateString());
                    });
                default:
            }
        }
        //Start and End date
        if (is_null($this->settings['status'])) {
            if (! is_null($this->settings['startDate'])) {
                $date = $this->settings['startDate'];
                $query = $query->whereHas('subscriptions', function ($sub) use ($date) {
                    $sub->where('date_end', '>=', $date);
                });
            }
            if (! is_null($this->settings['endDate'])) {
                $date = $this->settings['endDate'];
                $query = $query->whereHas('subscriptions', function ($sub) use ($date) {
                    $sub->where('date_start', '<=', $date);
                });
            }
        }

        //Where Clause array
        $queries = [];

        //Regex cellphone and phone
        if (! is_null($this->settings['phone'])) {
            $query = $query->where('phone_1', 'REGEXP', $this->settings['phone']);
            $query = $query->orWhere('phone_2', 'REGEXP', $this->settings['phone']);
        }

        //Age query
        if (! is_null($this->settings['ageNumber'])) {
            array_push($queries, ['birthdate', $this->settings['ageOperator'], Carbon::now()
                ->subYear($this->settings['ageNumber']), ]);
        }
        //unset bad $key in array settings for foreach
        unset($this->settings['exportFile'], $this->settings['exportFormat'], $this->settings['state'],
            $this->settings['status'], $this->settings['startDate'], $this->settings['endDate'],
            $this->settings['ageOperator'], $this->settings['ageNumber'], $this->settings['phone'],
            $this->settings['gift']);

        //Build last queries
        foreach ($this->settings as $key => $value) {
            if (! is_null($value)) {
                array_push($queries, [$key, '=', $value]);
            }
        }

        //Add where clause in query
        if (! empty($queries)) {
            $this->query = $query->where($queries);
        } else {
            $this->query = $query;
        }

        return $this->query;
    }

    //Set labels first row of table
    public function headings(): array
    {
        return [
            '#',
            'Genre',
            'Nom',
            'Prenom',
            'Date de naissance',
            'Adresse 1',
            'Adresse 2',
            'Code postal',
            'Ville',
            'Email',
            'Genre conjoint',
            'Prenom conjoint',
            'Nom conjoint',
            'Naissance conjoint',
            'Email conjoint',
            'Telephone 1',
            'Telephone 2',
            'Bénévole',
            'Détails bénévolat',
            'Distributeur',
            'Journal',
            'Newsletter',
            'Mailing',
            'Commentaire',
            'Alerte',
            'Date de création',
            'Date de mise à jour',
        ];
    }

    //Map value 0/1 to Female/Male
    public function map($users): array
    {
        $users = $users->toArray();
        foreach ($users as $key => $value) {
            if (is_int($value) && ($key == 'gender' || $key == 'gender_joint')) {
                if ($value == 1) {
                    $users[$key] = 'Masculin';
                } elseif ($value == 2) {
                    $users[$key] = 'Feminin';
                } else {
                    $users[$key] = 'Indéfini';
                }
            }
        }

        return $users;
    }
}
