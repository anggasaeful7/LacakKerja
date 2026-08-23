<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

#[Signature('lacakkerja:demo-reset {--force : Allow resetting demo data in production}')]
#[Description('Reset only the LacakKerja demo organization and reseed safe fictional data')]
class DemoReset extends Command
{
    public function handle(): int
    {
        if ((app()->environment('production') || config('app.env') === 'production') && ! $this->option('force')) {
            $this->error('Demo reset in production requires the --force flag.');

            return self::FAILURE;
        }

        $password = config('demo.password');
        if (! is_string($password) || strlen($password) < 12) {
            $this->error('Set DEMO_PASSWORD to a value with at least 12 characters before resetting demo data.');

            return self::FAILURE;
        }

        try {
            DB::transaction(function (): void {
                $this->guardDemoUserScope();

                $organization = Organization::withTrashed()
                    ->where('slug', config('demo.organization_slug', 'lacakkerja-demo'))
                    ->first();

                if ($organization !== null) {
                    $organization->forceDelete();
                }

                User::query()
                    ->whereIn('email', config('demo.emails', []))
                    ->whereDoesntHave('memberships')
                    ->delete();

                app(DemoSeeder::class)->run();
            });
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info('Demo data reset successfully.');
        $this->line('Dispatcher: dispatcher@lacakkerja.test');
        $this->line('Technician: technician1@lacakkerja.test');
        $this->line('Password: value from DEMO_PASSWORD');

        return self::SUCCESS;
    }

    private function guardDemoUserScope(): void
    {
        $organizationId = Organization::withTrashed()
            ->where('slug', config('demo.organization_slug', 'lacakkerja-demo'))
            ->value('id');

        $conflictingEmails = User::query()
            ->whereIn('email', config('demo.emails', []))
            ->whereHas('memberships', function ($query) use ($organizationId): void {
                $query->when(
                    $organizationId !== null,
                    fn ($membershipQuery) => $membershipQuery->where('organization_id', '!=', $organizationId),
                    fn ($membershipQuery) => $membershipQuery->where('organization_id', '>', 0),
                );
            })
            ->pluck('email')
            ->all();

        if ($conflictingEmails !== []) {
            throw new RuntimeException('Demo emails belong to another organization: '.implode(', ', $conflictingEmails));
        }
    }
}
