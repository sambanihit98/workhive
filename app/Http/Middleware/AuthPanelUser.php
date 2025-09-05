<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Filament\Actions\Exports\Models\Export;

class AuthPanelUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check panel guards first
        if (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
            return $next($request);
        }

        if (Auth::guard('employer')->check()) {
            Auth::shouldUse('employer');
            return $next($request);
        }

        // Export-specific logic
        $exportId = $request->route('export');

        if ($exportId) {
            if (is_object($exportId) && $exportId instanceof Export) {
                $export = $exportId;
            } else {
                $export = Export::find($exportId);
            }

            if (! $export) {
                abort(404, 'Export not found.');
            }

            $guard = match ($export->user_type) {
                \App\Models\Admin::class => 'admin',
                \App\Models\Employer::class => 'employer',
                default => null,
            };

            if ($guard && Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);
                return $next($request);
            }

            abort(403, 'Unauthorized.');
        }

        // If not export route, just continue (or redirect as needed)
        return $next($request);
    }
}
