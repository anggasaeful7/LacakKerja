<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $checks = [
            'database' => $this->databaseCheck(),
            'storage' => $this->storageCheck(),
            'queue' => $this->queueCheck(),
        ];
        $healthy = collect($checks)->every(fn (string $status): bool => $status === 'ok');

        return response()->json([
            'status' => $healthy ? 'ok' : 'degraded',
            'checks' => $checks,
        ], $healthy ? 200 : 503);
    }

    private function databaseCheck(): string
    {
        try {
            DB::select('select 1');

            return 'ok';
        } catch (Throwable $exception) {
            Log::warning('Health check database failed.', ['exception' => $exception]);

            return 'failed';
        }
    }

    private function storageCheck(): string
    {
        $path = 'health/'.Str::uuid().'.check';
        $disk = Storage::disk('local');

        try {
            if (! $disk->put($path, 'ok') || $disk->get($path) !== 'ok') {
                return 'failed';
            }

            return 'ok';
        } catch (Throwable $exception) {
            Log::warning('Health check storage failed.', ['exception' => $exception]);

            return 'failed';
        } finally {
            $disk->delete($path);
        }
    }

    private function queueCheck(): string
    {
        $connection = (string) config('queue.default');

        if ($connection === 'sync') {
            return 'ok';
        }

        try {
            $queue = config("queue.connections.{$connection}");

            if (! is_array($queue) || ! array_key_exists('driver', $queue) || ! is_string($queue['driver'])) {
                return 'failed';
            }

            $driver = $queue['driver'];
            $table = array_key_exists('table', $queue) && is_string($queue['table']) ? $queue['table'] : 'jobs';
            if ($driver === 'database' && ! Schema::hasTable($table)) {
                return 'failed';
            }

            return 'ok';
        } catch (Throwable $exception) {
            Log::warning('Health check queue failed.', ['exception' => $exception]);

            return 'failed';
        }
    }
}
