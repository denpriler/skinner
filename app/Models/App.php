<?php

namespace App\Models;

use App\Enums\AppSlug;
use App\Models\Traits\HasModelFields;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasModelFields;

    public const string FIELD_SLUG = 'slug';

    public const string FIELD_NAME = 'name';

    public const string FIELD_DESCRIPTION = 'description';

    public const string FIELD_IMAGE_URL = 'image_url';

    public const string FIELD_STEAM_APP_ID = 'steam_app_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        self::FIELD_SLUG,
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
        self::FIELD_IMAGE_URL,
        self::FIELD_STEAM_APP_ID,
    ];

    protected $casts = [
        self::FIELD_SLUG => AppSlug::class,
        self::FIELD_STEAM_APP_ID => 'integer',
    ];
}
