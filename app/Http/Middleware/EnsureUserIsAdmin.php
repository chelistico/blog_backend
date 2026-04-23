<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * Verifies that the user is authenticated and has admin role.
     * Handles both API and Livewire requests appropriately.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Check authentication
        if (!$user) {
            return $this->handleUnauthorized($request, 'Usuario no autenticado');
        }
        
        // Check admin role
        if (!$user->isAdmin()) {
            $this->logAuthorizationFailure($request, $user, 'Usuario no tiene rol de administrador');
            return $this->handleForbidden($request, 'Usuario no tiene permisos de administrador');
        }

        return $next($request);
    }

    /**
     * Handle unauthorized (not authenticated) responses.
     */
    private function handleUnauthorized(Request $request, string $message): Response
    {
        $this->logAuthorizationFailure($request, null, $message);
        
        // For Livewire requests, return HTML with redirect
        if ($this->isLivewireRequest($request)) {
            return response()->redirectTo(route('filament.admin.auth.login'))
                ->with('error', 'Sesión expirada. Por favor, inicia sesión de nuevo.');
        }

        // For API requests, return JSON
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'UNAUTHENTICATED',
                'message' => $message,
            ],
        ], 401);
    }

    /**
     * Handle forbidden (authenticated but not authorized) responses.
     */
    private function handleForbidden(Request $request, string $message): Response
    {
        // For Livewire requests, return HTML with redirect
        if ($this->isLivewireRequest($request)) {
            return response()->redirectTo(route('filament.admin.auth.login'))
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // For API requests, return JSON
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'FORBIDDEN',
                'message' => $message,
            ],
        ], 403);
    }

    /**
     * Detect if this is a Livewire update request.
     * 
     * Livewire uses specific headers and routes for component updates.
     */
    private function isLivewireRequest(Request $request): bool
    {
        return $request->isMethod('post') 
            && (
                $request->path() === 'livewire/update'
                || $request->path() === 'livewire/message'
                || $request->hasHeader('X-Livewire')
                || $request->hasHeader('X-Livewire-Component')
            );
    }

    /**
     * Log authorization failures for debugging and security monitoring.
     */
    private function logAuthorizationFailure(?object $user, string $reason): void
    {
        try {
            Log::warning('Admin authorization failed', [
                'user_id' => $user?->id ?? 'anonymous',
                'user_email' => $user?->email ?? 'N/A',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'path' => request()->path(),
                'method' => request()->method(),
                'reason' => $reason,
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            // Silently fail logging to avoid breaking the application
            \error_log('Failed to log authorization failure: ' . $e->getMessage());
        }
    }
}
