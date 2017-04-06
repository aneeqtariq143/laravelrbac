<?php

namespace Aneeq\LaravelRbac\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RbacPermission {

    protected $auth;

    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions) {
        if($this->auth->guest() || !$request->user()->can(explode('|', $permissions))){
            if($request->ajax()){
                abort('403', 'Unauthorized Access');
            }else{
                return redirect('unauthorized-access');
            }
            
        }
        return $next($request);
    }

}
