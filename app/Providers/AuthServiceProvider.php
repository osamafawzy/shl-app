<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        //
        Gate::resource('services', 'App\Policies\ServicePolicy');
        Gate::define('services.price','App\Policies\ServicePolicy@price');


        Gate::resource('clients', 'App\Policies\ClientPolicy');
        Gate::resource('providers', 'App\Policies\ProviderPolicy');


        Gate::resource('polls', 'App\Policies\PollPolicy');
        Gate::define('polls.deleteall','App\Policies\PollPolicy@deleteall');
        Gate::define('polls.showquestion','App\Policies\PollPolicy@showquestion');
        Gate::define('polls.showresult','App\Policies\PollPolicy@showresult');


        Gate::define('reports.services','App\Policies\ReportPolicy@services');
        Gate::define('reports.providers','App\Policies\ReportPolicy@providers');
        Gate::define('reports.followproviders','App\Policies\ReportPolicy@followproviders');


        Gate::define('other.contact','App\Policies\OtherPolicy@contact');
        Gate::define('other.condition','App\Policies\OtherPolicy@condition');
        Gate::define('other.social','App\Policies\OtherPolicy@social');


        Gate::resource('manager', 'App\Policies\ManagerPolicy');
    }
}
