<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    // 1. استخراج اللغة من الجزء الأول في الرابط (segment 1)
        $locale = $request->segment(1);

        // 2. التحقق من اللغة وتطبيقها
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        } else {
            // إذا لم يتم تحديد لغة، استخدم الافتراضية من الإعدادات
            App::setLocale(config('app.locale'));
        }

        // 3. تثبيت اللغة كقيمة افتراضية لجميع الروابط المتولدة عبر دالة route()
        // هذا السطر يمنع ظهور خطأ Missing Parameter في الروابط
        URL::defaults(['locale' => App::getLocale()]);


        return $next($request);
    }
}
