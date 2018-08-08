<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'lastname', 'firstname', 'birthdate', 'password', 'address_line1', 'address_line2',
        'zipcode', 'city', 'email', 'gender_joint', 'lastname_joint', 'firstname_joint', 'birthdate_joint', 'email_joint', 'phone_number_1',
        'phone_number_2', 'volonteer', 'details_volonteer', 'delivery', 'newspaper', 'newsletter', 'mailing', 'comment', 'alert'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /** RELATIONS */

    public function newsletters()
    {
        return $this->hasMany('App\Newsletter');
    }

    public function gifts()
    {
        return $this->hasMany('App\Gift');
    }

    public function role()
    {
        return $this->hasOne('App\Role');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function quality()
    {
        return $this->belongsTo('App\Quality');
    }

    public function subscription()
    {
        return $this->hasOne('App\Subscription');
    }

}
