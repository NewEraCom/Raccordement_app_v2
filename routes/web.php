<?php

declare(strict_types=1);


use App\Http\Controllers\PDFGenerator;
use App\Http\Controllers\BlocageController;
use App\Http\Livewire\Auth\CheckYourEmailPage;
use App\Http\Livewire\Auth\ForgetPasswordPage;
use App\Http\Livewire\Auth\LoginPage;
use App\Http\Livewire\Auth\RecoverPasswordPage;
use App\Http\Livewire\Backoffice\AffectationsMapPage;
use App\Http\Livewire\Backoffice\AffectationsPage;
use App\Http\Livewire\Backoffice\BlocageReport;
use App\Http\Livewire\Backoffice\CitiesPage;
use App\Http\Livewire\Backoffice\ClientsPage;
use App\Http\Livewire\Backoffice\ClientsRepports;
use App\Http\Livewire\Backoffice\ControleQaulitePage;
use App\Http\Livewire\Backoffice\Dashboard;
use App\Http\Livewire\Backoffice\LogsTechnicienPage;
use App\Http\Livewire\Backoffice\PlaquesPage;
use App\Http\Livewire\Backoffice\ProfileCityPage;
use App\Http\Livewire\Backoffice\ProfileClientPage;
use App\Http\Livewire\Backoffice\ProfilePlaquePage;
use App\Http\Livewire\Backoffice\ProfileSoustraitantPage;
use App\Http\Livewire\Backoffice\ReportsPreviewPage;
use App\Http\Livewire\Backoffice\RouteursPage;
use App\Http\Livewire\Backoffice\SoustraitantPage;
use App\Http\Livewire\Backoffice\StockDemandPage;
use App\Http\Livewire\Backoffice\StockHistoric;
use App\Http\Livewire\Backoffice\StockPage;
use App\Http\Livewire\Backoffice\StockSav;
use App\Http\Livewire\Backoffice\TechnicienPage;
use App\Http\Livewire\Backoffice\TechniciensPage;
use App\Http\Livewire\Backoffice\ReportsPageView;
use App\Http\Livewire\Controller\AffectationsPage as ControllerAffectationsPage;
use App\Http\Livewire\Controller\IndexPage as ControllerIndexPage;
use App\Http\Livewire\Controller\PlanificationPage;
use App\Http\Livewire\Controller\ReportsPage;
use App\Http\Livewire\Sales\IndexPage;
use App\Http\Livewire\Sav\ClientSavPage;
use App\Http\Livewire\Sav\SavAffectation;
use App\Http\Livewire\Sav\SavHomePage;
use App\Http\Livewire\Sav\SavViewScreen;
use App\Http\Livewire\Sav\StockSav as SavStockSav;
use App\Http\Livewire\Sav\Technicien as SavTechnicien;
use App\Http\Livewire\Sav\Techniciens;
use App\Http\Livewire\shared\TechPosPage;
use App\Http\Livewire\Soustraitant\HomePage as SoustraitantHomePage;
use App\Http\Livewire\Soustraitant\SoustraitantAffectationsPage;
use App\Http\Livewire\SousTraitant\SousTraitantComponent;
use App\Http\Livewire\Soustraitant\SoustraitantStockPage;
use App\Http\Livewire\Soustraitant\SoustraitantTechnicienPage;
use App\Http\Livewire\Soustraitant\Tickets;
use App\Http\Livewire\StoreKeeper\DemandesPage;
use App\Http\Livewire\StoreKeeper\HomePage as StoreKeeperHomePage;
use App\Http\Livewire\StoreKeeper\StockPage as StoreKeeperStockPage;
use App\Http\Livewire\Supervisor\HomePage;
use App\Models\User;
use App\Services\web\LoginService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Mail\RecapMail;
use Carbon\Carbon;
use App\Models\Declaration;
use App\Models\Client;
use App\Models\MailList;
use App\Models\Plaque;
use App\Mail\DeclarationMail;
use App\Models\Technicien;
use App\Services\web\ClientSavService;
use App\Services\web\ClientsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


Route::middleware('guest')->group(function () {
    Route::any('/', LoginPage::class)->name('login');
 //   Route::any('/login', LoginPage::class)->name('login');
    Route::any('/forget-password', ForgetPasswordPage::class)->name('forget-password');
    Route::any('/check-your-email', CheckYourEmailPage::class)->name('check-your-email');
    Route::any('/reset-password/{token}', RecoverPasswordPage::class)->name('password.reset');
});

Route::any('/logout', function () {
    return LoginService::logout();
})->name('logout');


Route::middleware(['auth', 'role:admin|sav|controller'])->name('admin.')->prefix('admin')->group(function () {
    Route::any('/dashboard', Dashboard::class)->name('dashboard');
    Route::any('/clients', ClientsPage::class)->name('clients');
    Route::any('/clients/{client}', ProfileClientPage::class)->name('clients.profile');
    //Route::any('/affectations', AffectationsPage::class)->name('affectations');
    Route::any('/affectations/map', AffectationsMapPage::class)->name('affectations.map');
    Route::any('/plaques', PlaquesPage::class)->name('plaques');
    Route::any('/plaques/{plaque}', ProfilePlaquePage::class)->name('plaques.profile');
    Route::any('/soustraitant', SoustraitantPage::class)->name('soustraitant');
    Route::any('/soustraitant/profile/{soustraitant}', ProfileSoustraitantPage::class)->name('soustraitant.profile');
    Route::any('/cities', CitiesPage::class)->name('cities');
    Route::any('/cities/{city}', ProfileCityPage::class)->name('cities.profile');
    Route::any('/routeurs', RouteursPage::class)->name('routeurs');
    Route::any('/techniciens', TechniciensPage::class)->name('techniciens');
    Route::any('/techniciens/{technicien}', TechnicienPage::class)->name('techniciens.profile');
    Route::any('/client/report/{client}', ReportsPreviewPage::class)->name('client.report');
    Route::any('/stock', StockPage::class)->name('stock');
    Route::any('/stock/demande', StockDemandPage::class)->name('stock.demande');
    Route::any('/stock/hostiric', StockHistoric::class)->name('stock.historic');
    Route::any('/client/report/blocage/{blocage}', BlocageReport::class)->name('client.blocage.report');
    Route::any('/logs', LogsTechnicienPage::class)->name('logs');
    Route::any('/controle-qualite', ControleQaulitePage::class)->name('clients.controle');
    Route::any('/reports-client', ClientsRepports::class)->name('clients.reports');
    Route::any('/affectations2',AffectationsPage::class)->name('affectations');
    Route::any('/reports',ReportsPageView::class)->name('reports');
});

Route::middleware(['auth', 'role:supervisor'])->name('supervisor.')->prefix('supervisor')->group(function () {
    Route::any('/dashboard', HomePage::class)->name('dashboard');
    Route::any('/soustraitant', SoustraitantPage::class)->name('soustraitant');
    Route::any('/soustraitant/profile/{soustraitant}', ProfileSoustraitantPage::class)->name('soustraitant.profile');
    Route::any('/cities', CitiesPage::class)->name('cities');
    Route::any('/cities/{city}', ProfileCityPage::class)->name('cities.profile');
    Route::any('/clients', ClientsPage::class)->name('clients');
    Route::any('/client/report/{client}', ReportsPreviewPage::class)->name('client.report');
    Route::any('/clients/{client}', ProfileClientPage::class)->name('clients.profile');
    Route::any('/stock', StockPage::class)->name('stock');
    Route::any('/stock/demande', StockDemandPage::class)->name('stock.demande');
    Route::any('/stock/hostiric', StockHistoric::class)->name('stock.historic');
});


Route::middleware(['auth', 'role:responsable'])->name('responsable.')->prefix('responsable')->group(function () {
    Route::any('/clients/{client}', ProfileClientPage::class)->name('clients.profile');
});


Route::middleware(['auth', 'role:soustraitant'])->name('soustraitant.')->prefix('soustraitant')->group(function () {
    Route::any('/dashboard', SoustraitantHomePage::class)->name('dashboard');
    Route::any('/stock', SoustraitantStockPage::class)->name('stock');
    Route::any('/techniciens', SoustraitantTechnicienPage::class)->name('techniciens');
    Route::any('/affectations', SoustraitantAffectationsPage::class)->name('affectations');
});

Route::middleware(['auth', 'role:controller|admin'])->name('controller.')->prefix('controller')->group(function () {
    Route::any('/dashboard', ControllerIndexPage::class)->name('dashboard');
    Route::any('/clients/{client}', ProfileClientPage::class)->name('clients.profile');
    Route::any('/client/report/{client}', ReportsPreviewPage::class)->name('client.report');
    Route::any('/affectations', ControllerAffectationsPage::class)->name('affectations');
    Route::any('/planification', PlanificationPage::class)->name('planification');
    Route::any('/reports', ReportsPage::class)->name('reports');
});

Route::middleware(['auth', 'role:storekeeper'])->name('storekeeper.')->prefix('storekeeper')->group(function () {
    Route::any('/dashboard', StoreKeeperHomePage::class)->name('dashboard');
    Route::any('/demandes', DemandesPage::class)->name('demandes');
    Route::any('/stock', StoreKeeperStockPage::class)->name('stock');
});

Route::middleware(['auth', 'role:sales'])->name('sales.')->prefix('sales')->group(function () {
    Route::any('/dashboard', IndexPage::class)->name('dashboard');
    Route::any('/client/profile/{client}', ProfileClientPage::class)->name('clients.profile');
});


Route::middleware(['auth'])->name('sav.')->prefix('sav')->group(function () {
    Route::any('/dashboard', SavHomePage::class)->name('dashboard');
    Route::any('/clientsav', ClientSavPage::class)->name('clientsav');
    Route::any('/stock', SavStockSav::class)->name('stock');
    Route::any('/affectation', SavAffectation::class)->name('savaffectation');
    Route::any('/client/profile/{client}', SavViewScreen::class)->name('clients.screen');
    Route::any('/techniciens', Techniciens::class)->name('techniciens');
    Route::any('/soustraitant', SoustraitantPage::class)->name('soustraitant');
    Route::any('/technicien/{technicien}', SavTechnicien::class)->name('technicien');
    Route::any('/soustraitant/profile/{soustraitant}', ProfileSoustraitantPage::class)->name('soustraitant.profile');
});

Route::any('/pdf/{client}', PDFGenerator::class)->name('pdf');
Route::any('/blocage-pdf/{blocage}', BlocageController::class)->name('blocage-pdf');

// Route::middleware(['auth', 'role:sav','role:supervisor'])->group(function () {
    Route::any('/techpos', TechPosPage::class)->name('techpos');
// });

Route::any('/decl', function () {
    set_time_limit(0);
    $declarations = Declaration::whereHas('affectation', function ($query) {
        $query->whereHas('client', function ($query) {
            $query->whereIn('sip', [
                '0530202323',
                '0530173903',
                '0530202920',
                '0530202997',
                '0530202930',
                '0530203422'
            ]);
        });
    })->get();
    foreach ($declarations as $item) {
        Mail::to(MailList::where([['type', 'orange'], ['status', 1]])->get('email'))->cc(MailList::where([['type', 'declaration'], ['status', 1]])->get('email'))->send(new DeclarationMail($item));
    }
    return 'done';
});

Route::any('/create-user', function () {
    try {
        DB::beginTransaction();
        $user = User::firstOrCreate([
            'email' => 'h.eljaouani@neweracom.ma',
        ], [
            'uuid' => Str::uuid(),
            'first_name' => 'Hamza',
            'last_name' => 'El Jaouani',
            'email' => 'h.eljaouani@neweracom.ma',
            'password' => bcrypt('hamza123'),
        ]);
        Role::firstOrCreate(['name' => 'admin'], ['name' => 'admin']);
        $user->assignRole('admin');
        DB::commit();
        dd('done');
    } catch (\Throwable $th) {
        DB::rollBack();
        dd($th);
    }

    //User::where('email', 'a.khyari@neweracom.ma')->first()->assignRole('responsable');
});

Route::any('/test-fun', function () {
    phpinfo();
});

Route::any('/update-usr',function(){
    try {
        DB::beginTransaction();
        $user = User::where('email','sav@neweracom.ma')->first();
        $user->syncRoles('sav');
        DB::commit();
        dd('done');
    } catch (\Throwable $th) {
        DB::rollBack();
        dd($th);
    }
});

Route::any('/mail-test', function () {
    try {
        Mail::to(['a.chahid@neweracom.ma'])->send(new RecapMail());
        return 'done';
    } catch (\Throwable $th) {
        dd($th);
    }
});
