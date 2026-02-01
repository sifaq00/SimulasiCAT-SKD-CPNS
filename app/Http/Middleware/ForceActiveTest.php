<?php

namespace App\Http\Middleware;

use App\Models\TestAttempt;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceActiveTest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated users
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // 1. Check if user has an active test attempt
        // We use the model directly or via relationship.
        // Assuming we want to catch ANY in_progress test.
        $activeAttempt = TestAttempt::where('user_id', $user->id)
            ->where('status', TestAttempt::STATUS_IN_PROGRESS)
            ->with(['package', 'transaction'])
            ->first();

        // If no active test, proceed as normal
        if (!$activeAttempt) {
            return $next($request);
        }

        // 2. Define Allowed Routes
        // - test.simulation: The actual test page
        // - livewire.*: Essential for Livewire updates/interactions
        // - logout: User should be able to log out
        // - sanitizer/debugbar/etc: If development (optional, skipping for now)
        
        $currentRouteName = $request->route()->getName();
        
        $allowedRoutes = [
            'test.simulation',
            'logout',
        ];

        // Check if current route is allowed
        // also allow livewire internal routes
        if (in_array($currentRouteName, $allowedRoutes) || $request->is('livewire/*')) {
            // OPTIONAL: If they are on 'test.simulation' but for a DIFFERENT test?
            // e.g. active is ID 1, but they try to access test/ID-2
            // That would be handled by the component itself (Simulation.php usually checks ownership/status).
            // But to be strict, we could enforce it here explicitly.
            return $next($request);
        }

        // 3. Redirect to the active test
        // We need packageSlug and transactionId for the route
        if ($activeAttempt->package && $activeAttempt->transaction) {
            return redirect()->route('test.simulation', [
                'packageSlug' => $activeAttempt->package->slug,
                'transactionId' => $activeAttempt->transaction->id,
            ]);
        }

        // Fallback (should normally not happen if data integrity is good)
        return $next($request);
    }
}
