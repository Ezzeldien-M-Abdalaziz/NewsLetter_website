<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkNotificationReadAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->query('notification')){

            $notification = auth()->user()->unreadNotifications()->where('id' , $request->query('notification'))->first();
            if($notification){
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
