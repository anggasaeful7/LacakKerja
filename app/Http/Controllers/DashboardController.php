<?php

namespace App\Http\Controllers;

use App\Services\CurrentOrganization;
use App\Services\OperationsDashboardQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(
        private readonly OperationsDashboardQuery $dashboardQuery,
    ) {}

    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->resolve($request->user());

        if ($organization === null) {
            return view('dashboard', [
                'organization' => null,
                'dashboardError' => null,
            ]);
        }

        try {
            return view('dashboard', [
                'organization' => $organization,
                'dashboard' => $this->dashboardQuery->dashboard($organization, $request->user()),
                'dashboardError' => null,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return view('dashboard', [
                'organization' => $organization,
                'dashboard' => null,
                'dashboardError' => 'Ringkasan operasional sedang bermasalah. Coba muat ulang beberapa saat lagi.',
            ]);
        }
    }
}
