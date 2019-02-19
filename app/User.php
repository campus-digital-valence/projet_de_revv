<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'lastname', 'firstname', 'birthdate', 'password', 'address_line1', 'address_line2',
        'zipcode', 'city', 'email', 'gender_joint', 'lastname_joint', 'firstname_joint', 'birthdate_joint', 'email_joint', 'phone_1',
        'phone_2', 'volonteer', 'details_volonteer', 'delivery', 'newspaper', 'newsletter', 'mailing', 'comment', 'alert',
    ];

    /**
     * Set the user's first name.
     * @param  string $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['firstname'] = mb_convert_case(strtolower($value), MB_CASE_TITLE);
    }

    /**
     * Set the user's last name.
     * @param  string $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['lastname'] = mb_strtoupper($value);
    }

    /**
     * Set the user adressline.
     * @param  string $value
     * @return void
     */
    public function setAddressLineOneAttribute($value)
    {
        $this->attributes['address_line1'] = mb_strtolower($value);
    }

    /**
     * Set the user adressline.
     * @param  string $value
     * @return void
     */
    public function setAddressLineTwoAttribute($value)
    {
        $this->attributes['address_line2'] = mb_strtolower($value);
    }

    /**
     * Set the users city.
     * @param $value
     * @return void
     */
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = mb_convert_case(mb_strtolower($value), MB_CASE_TITLE);
    }

    /**
     * Set the user email font.
     * @param  string $value
     * @return void
     */
    public function setEmailttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * Set the user joint first name.
     * @param  string $value
     * @return void
     */
    public function setFirstNameJointAttribute($value)
    {
        $this->attributes['firstname_joint'] = mb_convert_case(mb_strtolower($value), MB_CASE_TITLE);
    }

    /**
     * Set the user joint last name.
     * @param  string $value
     * @return void
     */
    public function setLastNameJointAttribute($value)
    {
        $this->attributes['lastname_joint'] = mb_strtoupper($value);
    }

    /**
     * Set the user joint email.
     * @param  string $value
     * @return void
     */
    public function setEmailJointAttribute($value)
    {
        $this->attributes['email_joint'] = mb_strtolower($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function scopeNewsletter($query)
    {
        return $query->where('newsletter', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsletters()
    {
        return $this->hasMany('App\Newsletter')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gifts()
    {
        return $this->hasMany('App\Gift')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment')->orderBy('date_start', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription')->orderBy('date_start', 'desc');
    }

    public function lastSubscription()
    {
        return $this->hasOne('App\Subscription')->orderBy('date_end', 'desc')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function sessions()
    {
        return $this->hasMany('App\Session')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function posts()
    {
        return $this->hasMany('App\Posts')->latest();
    }
}
