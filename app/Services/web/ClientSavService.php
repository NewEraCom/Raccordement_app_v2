<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Models\City;
use App\Models\Client;
use App\Models\SavClient;
use App\Models\Plaque;
use App\Models\savhistory;
use App\Models\SavTicket;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Webklex\IMAP\Facades\Client as ClientIMAP;

class ClientSavService
{

    // static function ImportAuto()
    // {
    //     try {
    //         set_time_limit(0);
    //         $countClient = 0;
    //         $oClient = ClientIMAP::account('default')->connect();
    //         $inbox = $oClient->getFolder('new_sav');
    //         $messages = $inbox->query()->unseen()->text('Case-Notif Intervenant Orange')->get();
    //         if (count($messages) > 0) {
    //             foreach ($messages as $message) {
    //                 $stringWithNewline = trim(str_replace('&nbsp;', ' ', strip_tags($message->getHTMLBody(true))));
    //                 if (substr($stringWithNewline, 0, 7) === "ID CASE") {
    //                     $data = self::ImportsClientSAV(trim($stringWithNewline));
    //                     $date = $message->getDate()->toDate();

    //                     SavClient::firstOrCreate(
    //                         [
    //                             'n_case' => $data['n_case'],
    //                         ],
    //                         [
    //                             'n_case' => $data['n_case'],
    //                             'sip' => $data['sip'],
    //                             'login' => $data['login'],
    //                             'address' => Str::title(Str::lower($data['address'])),
    //                             'client_name' => Str::title(Str::lower($data['client_name'])),
    //                             'contact' => $data['contact'],
    //                             'date_demande' => $date,
    //                             'city_id' => $data['city_id'],
    //                             'plaque_id' => $data['plaque_id'],
    //                         ]
    //                     );
    //                 }
    //             }
    //         }
    //     } catch (Exception $e) {
    //         dd($e);
    //         return $e->getMessage();
    //     }
    // }
    static function ImportAuto()
{
    try {
        set_time_limit(0);
        $countClient = 0;

        // Connect to IMAP client
        $oClient = ClientIMAP::account('default')->connect();
        $inbox = $oClient->getFolder('new_sav');
        $messages = $inbox->query()->unseen()->text('Case-Notif Intervenant Orange')->get();

        if (count($messages) > 0) {
            foreach ($messages as $message) {
                // Extract and normalize email content
                $stringWithNewline = trim(str_replace('&nbsp;', ' ', strip_tags($message->getHTMLBody(true))));

                if (substr($stringWithNewline, 0, 7) === "ID CASE") {
                    Log::info('Processing Message: ' . $stringWithNewline);

                    // Extract client data
                    $data = self::ImportsClientSAV($stringWithNewline);
                    $date = $message->getDate()->toDate();

                    Log::info('Extracted Data:', $data);

                    // Save or update client record
                    SavClient::firstOrCreate(
                        [
                            'n_case' => $data['n_case'],
                        ],
                        [
                            'n_case' => $data['n_case'],
                            'sip' => $data['sip'],
                            'login' => $data['login'],
                            'address' => Str::title(Str::lower($data['address'])),
                            'client_name' => Str::title(Str::lower($data['client_name'])),
                            'contact' => $data['contact'],
                            'date_demande' => $date,
                            'city_id' => $data['city_id'],
                            'plaque_id' => $data['plaque_id'],
                        ]
                    );
                }
            }
        }
    } catch (Exception $e) {
        Log::error('Error in ImportAuto: ' . $e->getMessage());
        return $e->getMessage();
    }
}
    // static public function ImportsClientSAV($content)
    // {
    //     try {
    //         $id_case_pattern = '/ID CASE\s*:\s*(.*)\n/';
    //         $client_name_pattern = '/Client\s*:\s*(.*)\n/';
    //         $phone_number_pattern = '/Téléphone\s*:\s*(.*)\n/';
    //         $acces_reseau_pattern = '/Accès réseau\s*:\s*(.*)\n/';
    //         $address_pattern = '/Adresse\s*:\s*(.*)\n/';
    //         $address_installation_pattern = '/Adresse Installation\s*:\s*(.*)\n/';
    //         $code_pattern = '/CODE\s*([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/';
    //         $sip_pattern = '/Login\s+Internet\s*:\s*([0-9]+)/';

    //         preg_match($id_case_pattern, $content, $case);
    //         $id_case = isset($case[1]) ? trim($case[1]) : "";

    //         preg_match($client_name_pattern, $content, $client);
    //         $client_name = isset($client[1]) ? trim($client[1]) : "";

    //         preg_match($phone_number_pattern, $content, $phone);
    //         $phone_number = isset($phone[1]) ? trim($phone[1]) : "";

    //         preg_match($acces_reseau_pattern, $content, $login);
    //         $acces_reseau = isset($login[1]) ? trim($login[1]) : "";

    //         preg_match($address_pattern, $content, $address);
    //         $address_client = isset($address[1]) ? trim($address[1]) : "";

    //         preg_match($address_installation_pattern, $content, $addre_installation);
    //         $address_installation = isset($addre_installation[1]) ? trim($addre_installation[1]) : "";

    //         preg_match($sip_pattern, $content, $sip);
    //         $sip_client = isset($sip[1]) ? trim($sip[1]) : "";

    //         preg_match('/CODE\s*(.{7})/', $content, $plaque);

    //         if (!empty($plaque)) {
    //             $plaque = Plaque::with('city')->where('code_plaque', 'LIKE', $plaque[1])->first();
    //         }

    //         try {
    //             return [
    //                 'n_case' => $id_case,
    //                 'sip' => $sip_client ?? '',
    //                 'login' => $acces_reseau ?? '',
    //                 'address' => $address_client == null ? ($address_installation == null ? '' : $address_installation) : $address_client,
    //                 'client_name' => $client_name ?? '',
    //                 'contact' => $phone_number ?? '',
    //                 'date_demande' => Carbon::now(),
    //                 'plaque_id' => $plaque->id  ?? 114,
    //                 'city_id' => $plaque != null ? $plaque->city_id : 12,
    //             ];
    //         } catch (Exception $e) {
    //             dd($e);
    //         }
    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    // }
static public function ImportsClientSAV($content)
{
    try {
        // Normalize content: handle different line breaks and trim unnecessary spaces
        $content = preg_replace("/\r\n|\r|\n/", "\n", $content); // Normalize line breaks
        $content = preg_replace("/\s+/", " ", $content); // Remove extra spaces

        // Define regex patterns
        $patterns = [
            'id_case' => '/ID CASE\s*:\s*(CAS-\d{8}-[A-Z0-9]{6})/i', // Adjusted to capture correctly
            'client_name' => '/Client\s*:\s*(.+?)\s*(Téléphone|$)/i',
            'phone_number' => '/Téléphone\s*:\s*([\d\s]+)/i',
            'acces_reseau' => '/Accès réseau\s*:\s*([\d\s]+)/i',
            'address_client' => '/Adresse\s*:\s*([\s\S]+?)(?=\b(Ndc|Nombre|Id Connexion|Adresse Installation|Login Internet|Code|$))/i',
            'address_installation' => '/Adresse Installation\s*:\s*(.+?)\s*(Login Internet|$)/i',
            'code_plaque' => '/Code\s*([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/i',
            'sip' => '/Login Internet\s*:\s*([\d]+)/i',
        ];

        // Extract data using patterns
        $results = [];
        foreach ($patterns as $key => $pattern) {
            preg_match($pattern, $content, $matches);
            $results[$key] = isset($matches[1]) ? trim($matches[1]) : '';
        }

        // Debugging: Log intermediate data
        Log::info('Extracted Data:', ['raw' => $content, 'results' => $results]);

        // Fetch plaque if code_plaque is matched
        $plaque = null;
        if (!empty($results['code_plaque'])) {
            $plaque = Plaque::with('city')->where('code_plaque', 'LIKE', $results['code_plaque'])->first();
        }

        return [
            'n_case' => $results['id_case'], // id_case without extra characters
            'sip' => $results['sip'],
            'login' => $results['acces_reseau'],
            'address' => $results['address_client'] ?: $results['address_installation'] ?: '',
            'client_name' => $results['client_name'],
            'contact' => $results['phone_number'],
            'date_demande' => Carbon::now(),
            'plaque_id' => $plaque->id ?? 114,
            'city_id' => $plaque->city_id ?? 12,
        ];
    } catch (\Throwable $th) {
        Log::error('Error in ImportsClientSAV: ' . $th->getMessage());
        throw $th; // Rethrow to handle it at a higher level
    }
}





    static function index($start_date, $end_date, $search, $status)
    {
        return Client::with(['city', 'technicien'])
            ->whereNotNull('statusSav')
            ->whereNotNull('created_at') // Add this line if necessary
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('phone_no', 'like', '%' . $search . '%')

                        ->whereNotNull('statusSav')
                        ->orWhere('sip', 'like', '%' . $search . '%')
                        ->orWhereHas('city', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('statusSav', $status);
            })
            ->orderBy('created_at', 'desc');
    }

    static function countClient($start_date, $end_date)
    {
        return Client::with(['city'])->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
        })->whereNotNull('statusSav')->orderBy('created_at', 'desc');
    }

    static public function getClientsSavStatistic()
    {
        $clients = Client::query();
        return [
            'allClients' => $clients->whereNotNull('statusSav')->count(),
            'clientsOfTheDay' => $clients->whereNotNull('statusSav')->whereDate('created_at', today())->count(),
            'clientsSaisie' => Client::where('statusSav', 'Down')->count(),
            'clientAffecte' => Client::where('statusSav', 'Affecté')->count(),
            'clientConnecte' => Client::where('statusSav', 'Connecté')->count(),
        ];
    }

    static public function edit($data, $client_id)
    {
        try {
            $client = Client::find($client_id);

            $client->update([
                'address' => $data['e_address'],
                'name' => $data['e_name'],
                'phone_no' => $data['e_phone'],
                'type' => $data['e_type'],
                'debit' => $data['e_debit'],
                'sip' => $data['e_sip'],
                'routeur_type' => $data['e_routeur'],
            ]);
            $client->savTicket->last()->update([
                'description' => $data['e_description'],
                'type' => $data['e_type_prob'],
            ]);
            DB::beginTransaction();
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();

            // Log::chanel('error')->error('Function edit in ClientService.php : ' . $th->getMessage());
            return false;
        }
    }
}
