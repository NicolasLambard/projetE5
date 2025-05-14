<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Commentaire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Directive Blade pour vérifier si l'utilisateur connecté peut valider les commentaires
        Blade::if('peutValiderCommentaire', function () {
            return Commentaire::peutValider(auth()->user());
        });
    }
}
