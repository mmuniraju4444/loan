<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;

trait UUID
{
    /**
     * @param string $uuid
     * @return self|null
     */
    public static function getModel(?string $uuid, $with = []): ?Model
    {
        return static::where('uuid', '=', $uuid)
            ->with($with)
            ->first();
    }

    /**
     * @param array $uuids
     * @return array|null
     */
    public static function getIds(array $uuids): ?array
    {
        return static::whereIn('uuid', $uuids)->pluck('id')->values()->toArray();
    }

    /**
     * @param string $uuid
     * @return int|null
     */
    public static function getId(string $uuid): ?int
    {
        return static::where('uuid', '=', $uuid)->first()->id;
    }

    /**
     * @param string $id
     * @return string|null
     */
    public static function getUUID(string $id): ?string
    {
        return static::where('id', '=', $id)->first()->uuid;
    }
}
