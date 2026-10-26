<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityTestingOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('security_testing.enabled') !== true) {
            abort(404);
        }

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, private');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        if ($response->isSuccessful() && str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            // Only the trusted shell requests a document for its opaque-origin sandbox.
            // Never let stored lab scripts run in the normal storefront's origin.
            if ($request->header('X-Security-Lab-Document') !== '1') {
                $response->setContent(view('security-testing.shell', [
                    'document' => $response->getContent(),
                    'origin' => $request->getSchemeAndHttpHost(),
                ])->render());
            }
            // srcdoc is supplied directly; no network frame destination is needed.
            $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'; frame-src 'none'; object-src 'none'; base-uri 'none'; form-action 'none'");
        }

        return $response;
    }
}
