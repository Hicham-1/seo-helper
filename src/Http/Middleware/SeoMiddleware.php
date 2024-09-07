<?php

namespace Seo\SeoHelper\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Seo\SeoHelper\Models\SeoHelper;
use Symfony\Component\HttpFoundation\Response;

class SeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $route_name = Route::currentRouteName();

        $seo_data = SeoHelper::where(function ($query) use ($route_name) {
            $query->where('route', 'LIKE', "%|$route_name")
                ->orWhere('route', 'LIKE', "$route_name|%")
                ->orWhere('route', 'LIKE', "%|$route_name|%")
                ->orWhere('route', 'LIKE', "$route_name")
                ->orWhere('route', '*');
        })->get(['name', 'value', 'content']);

        if ($response->headers->get('content-type') === 'application/json') {
            $content = $response->getContent();

            $data = json_decode($content, true);

            if ($seo_data && count($seo_data)) {
                $meta_data = [];
                foreach ($seo_data as $key => $value) {
                    $meta_data[$value['name']] = [
                        'value' => $value['value'],
                        'content' => $value['content'],
                    ];
                }

                $data['metadata'] = $meta_data;
            }

            $response->setContent(json_encode($data));
        } else if ($response->headers->get('content-type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();

            if ($seo_data && count($seo_data)) {
                $meta_tags = [];
                foreach ($seo_data as $key => $value) {
                    $meta_tag = "<meta {$value['name']}=\"{$value['value']}\" content=\"{$value['content']}\">";
                    $meta_tags[] = $meta_tag;
                }

                $meta_tags = implode('', $meta_tags);
                $content = preg_replace('/<head>/i', '<head>' . $meta_tags, $content, 1);

                $response->setContent($content);
            }
        }

        return $response;
    }
}
