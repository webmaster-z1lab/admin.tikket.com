<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Z1lab\OpenID\Models\User;
use App\Services\ApiService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
         * ACL de Role Supreme
         */
        \Gate::before(function (User $user) {
            if (in_array('SysAdmin', $user->roles)) {
                return true;
            }
        });

        /*
         * ACL de Roles
         */
        \Gate::define('admin', function (User $user, $event_id) {
            $permission = (new ApiService('events', 'GET'))->find($event_id . '/my-permission')->collect();

            return in_array($permission->attributes->type, ['master', 'organizer']);
        });

        \Gate::define('pdv', function (User $user, $event_id) {
            $permission = (new ApiService('events', 'GET'))->find($event_id . '/my-permission')->collect();

            return $permission->attributes->type === 'pdv';
        });

        \Gate::define('checkIn', function (User $user, $event_id) {
            $permission = (new ApiService('events', 'GET'))->find($event_id . '/my-permission')->collect();

            return $permission->attributes->type === 'checkin';
        });
    }
}
