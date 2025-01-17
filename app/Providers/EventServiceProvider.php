<?php

namespace App\Providers;

use App\Models\Affectation;
use App\Models\Blocage;
use App\Models\BlocageSav;
use App\Models\Deblocage;
use App\Models\Technicien;
use App\Observers\TechnicienObserver;
use App\Models\Declaration;
use App\Models\FeedBackSav;
use App\Models\SavTicket;
use App\Models\Validation;
use App\Observers\AffectationObserver;
use App\Observers\DeblocageObserver;
use App\Observers\BlocageObserver;
use App\Observers\BlocageSavObserver;
use App\Observers\ValidationObserver;
use App\Observers\DeclarationObserver;
use App\Observers\FeedBackSavObserver;
use App\Observers\SavTicketObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            AffectationObserver::class,
                        DeblocageObserver::class,

            BlocageObserver::class,
            DeclarationObserver::class,
            ValidationObserver::class,
            TechnicienObserver::class,
            

        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Affectation::observe(AffectationObserver::class);
        Blocage::observe(BlocageObserver::class);
        Declaration::observe(DeclarationObserver::class);
        Validation::observe(ValidationObserver::class);
        Technicien::observe(TechnicienObserver::class);
        Deblocage::observe(DeblocageObserver::class);
        BlocageSav::observe(BlocageSavObserver::class);
        SavTicket::observe(SavTicketObserver::class);
        FeedBackSav::observe(FeedBackSavObserver::class);


    }
    
}
