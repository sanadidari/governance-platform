<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // FORCE ABSOLUE (Nuclear Option pour HostPapa)
        $url = 'https://sanadidari.com/testftp/gov';
        \Illuminate\Support\Facades\URL::forceRootUrl($url);
        \Illuminate\Support\Facades\URL::forceScheme('https');

        // Force Laravel et Livewire à rester dans le sous-dossier
        config([
            'app.url' => $url,
            'livewire.asset_url' => $url,
            'livewire.update_route_group_config.prefix' => 'testftp/gov',
            'livewire.update_route_group_config.middleware' => ['web'],
        ]);

        if (!app()->runningInConsole()) {
            \Illuminate\Support\Facades\URL::formatRoot(null, $url);
        }

        \Illuminate\Support\Facades\Gate::policy(\App\Models\Huissier::class, \App\Policies\HuissierPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Acte::class, \App\Policies\ActePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Region::class, \App\Policies\NationalStructurePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Tribunal::class, \App\Policies\NationalStructurePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\User::class, \App\Policies\AdminOnlyPolicy::class);
        
        \App\Models\Huissier::observe(\App\Observers\HuissierObserver::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Complaint::class, \App\Policies\ComplaintPolicy::class);
    }
}
