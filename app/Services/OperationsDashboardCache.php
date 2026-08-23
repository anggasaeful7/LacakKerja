<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\Cache;

class OperationsDashboardCache
{
    private const TTL_SECONDS = 60;

    /**
     * @template T
     *
     * @param  Closure(): T  $callback
     * @return T
     */
    public function remember(int $organizationId, string $dateKey, Closure $callback): mixed
    {
        $versionKey = $this->versionKey($organizationId);
        Cache::add($versionKey, 1, now()->addDays(2));
        $version = (int) Cache::get($versionKey, 1);

        return Cache::remember(
            $this->dataKey($organizationId, $dateKey, $version),
            self::TTL_SECONDS,
            $callback,
        );
    }

    public function invalidate(int $organizationId): void
    {
        $versionKey = $this->versionKey($organizationId);

        if (! Cache::add($versionKey, 1, now()->addDays(2))) {
            Cache::increment($versionKey);
        }
    }

    private function versionKey(int $organizationId): string
    {
        return "lacakkerja:ops-dashboard:version:{$organizationId}";
    }

    private function dataKey(int $organizationId, string $dateKey, int $version): string
    {
        return "lacakkerja:ops-dashboard:{$organizationId}:{$dateKey}:v{$version}";
    }
}
