<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\Submission;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        // Custom nested binding for submissions
        Route::bind('submission', function ($value, $route) {
            // Get the parent assignment id from the route
            $assignmentId = $route->parameter('assignment');

            // Find the submission belonging to that assignment
            return Submission::where('id', $value)
                             ->where('assignment_id', $assignmentId)
                             ->firstOrFail();
        });

        $this->routes(function () {
            Route::middleware('web')
                 ->group(base_path('routes/web.php'));

            Route::prefix('api')
                 ->middleware('api')
                 ->group(base_path('routes/api.php'));
        });
    }
}
