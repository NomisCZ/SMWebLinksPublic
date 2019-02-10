<?php

namespace App\Http\Middleware;

use App\Classes\AppUserAgent;
use App\Classes\AppResponseVDF;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Closure;

class ApiCheckAgent
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param null $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type = null)
    {
        $userAgent = new AppUserAgent();

        if (is_null($type)) {

            if (!$userAgent->isValveClient()) {

                AppResponseVDF::sendError(array(
                    'code' => '401',
                    'http_code' => 'API_UNAUTHORIZED',
                    'message' => 'Unauthorized.',
                ));
            }

        } else if (!$userAgent->isValveInGameBrowser()) {

            throw new UnauthorizedHttpException('Unauthorized');
        }

        return $next($request);
    }
}
