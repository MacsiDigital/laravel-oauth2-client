<?php
namespace MacsiDigital\OAuth2;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'accessToken', 'refreshToken', 'expires', 'additional',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'accessToken', 'refreshToken', 'expires', 'additional',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'additional' => 'array',
    ];

    public function getTable()
    {
        return config('oauth2.table_name', parent::getTable());
    }
}
