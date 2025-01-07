<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Enums\ClientStatusEnum;
use App\Models\Affectation;
use App\Models\Client;
use App\Models\Map;
use App\Models\Blocage;
use App\Models\ClientSav;
use App\Models\Notification;
use App\Models\Plaque;
use App\Models\SavClient;
use App\Models\SavTicket;
use App\Models\Soustraitant;
use Carbon\Carbon;
use DOMDocument;
use Exception;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Webklex\IMAP\Facades\Client as ClientIMAP;
use Illuminate\Support\Facades\Log;
use App\Models\Technicien;
use OneSignal;


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
    static public function getClients($search = null, $client_status = null, $start_date = null, $end_date = null)
    {
        return SavClient::with(['city'])
            ->when($search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('client_name', 'like', '%' . $search . '%')
                      ->orWhere('sip', 'like', '%' . $search . '%')
                      ->orWhere('n_case', 'like', '%' . $search . '%')
                      ->orWhereHas('city', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
                });
            })
            ->when($client_status, function ($q, $client_status) {
                if (is_array($client_status)) {
                    $q->whereIn('status', $client_status);
                } else {
                    $q->where('status', $client_status);
                }
            })
            ->when($start_date, function ($q, $start_date) {
                // Filter by start date
                $q->whereDate('date_demande', '>=', $start_date);
            })
            ->when($end_date, function ($q, $end_date) {
                // Filter by end date
                $q->whereDate('date_demande', '<=', $end_date);
            })
            ->orderByDesc('date_demande')
            ->paginate(15);
    }
    static public function getTechnicienTickets($searchTerm, $technicienId)
    {
        return SavTicket::with(['client', 'sousTraitant', 'blocage'])
            ->where('technicien_id', $technicienId) // Filter by technicien_id
            ->when($searchTerm, function ($q) use ($searchTerm) {
                $q->whereHas('client', function ($q) use ($searchTerm) {
                    $q->where('n_case', 'like', '%' . $searchTerm . '%') // Search by n_case
                      ->orWhere('client_name', 'like', '%' . $searchTerm . '%') // Search by client name
                      ->orWhere('sip', 'like', '%' . $searchTerm . '%'); // Search by SIP
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15);
    }
    
    
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
        
    static public function getClientsStatistic()
    {
        $clients = Client::query();
        return [
            'allClients' => $clients->count(),
            'clientsOfTheDay' => $clients->whereNull('statusSav')->whereDate('created_at', today())->count(),
            'clientsB2B' => Client::where('type', 'B2B')->count(),
            'clientsB2C' => Client::where('type', 'B2C')->count(),
            'clientsSaisie' => Client::where('status', ClientStatusEnum::SAISIE())->count(),
            'clientAffecte' => Client::where('status', 'Affecté')->count(),
            'clientDeclare' => Client::where('status', 'Déclaré')->count(),
            'clientValide' => Client::where('status', 'Validé')->count(),
        ];
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


    static public function importsClients($content)
    {
        preg_match('/Adresse d�installation\s*:\s*(.*)/', $content, $client_address);
        preg_match('/Client\s*:\s*(\D*)Contact/', $content, $client_fullname);
        preg_match('/Offre\s*:\s*(\d*)/', $content, $client_debit);
        preg_match('/Login SIP\s*:\s*(\d*)/', $content, $client_sip);
        preg_match('/Contact Client\s*:\s*(\d*)/', $content, $client_phone);
        preg_match('/CODE\s*(.{7})/', $content, $plaque);
        preg_match('/CODE\s*(.{2})/', $content, $city);
        preg_match('/Login internet:\s*(\d*)/', $content, $client_login);
        preg_match('/Routeur.*(F\d{3,4})/', $content, $routeur);
        preg_match('/Sous Type Opportunit�\s*: (.+)/', $content, $offre);
        preg_match('/Longitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lng);
        preg_match('/Latitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lat);
        preg_match('/Plan: FTTH (.*)/', $content, $typeClient);

        $plaque = Plaque::with('city')->where('code_plaque', $plaque[1])->first();

        return [
            'name' => $client_fullname ? trim(Str::title($client_fullname[1])) : '-',
            'login_internet' => $client_login[1] ?? '',
            'address' => Str::upper((trim($client_address[1]))),
            'type' => trim($typeClient[1]) ?? 'B2B',
            'debit' => $client_debit[1],
            'lat' => $lat[1] ?? 'NaN',
            'lng' => $lng[1] ?? 'Nan',
            'sip' => $client_sip[1],
            'plaque' => $plaque->id ?? 114,
            'city' => $plaque->city->id ?? 12,
            'phone' => $client_phone[1],
            'routeur' => $routeur ? 'ZTE ' . $routeur[1] : '-',
            'offre' => $offre ? (trim($offre[1]) === 'D�m�nagement' ?  'Déménagement' : trim($offre[1])) : '-',
        ];
    }

    static public function importsPipe($content)
    {
        try {
            preg_match('/\sF(.{1,4})_/', $content[2], $routeur_type);
            preg_match('/_(\d*)\s*Méga Fibre/', $content[2], $debit);
            preg_match('/CODE\s*(.{7})/', $content[1], $plaque);
            preg_match('/CODE\s*(.{2})/', $content[1], $city);
            preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $content[1], $code);

            if ($plaque) {
                $plaque = Plaque::with('city')->where('code_plaque', $plaque[1])->first();
            }

            return [
                'name' => $content[10] ?? '-',
                'routeur' => $routeur_type ? 'ZTE F' . $routeur_type[1] : '-',
                'debit' => $debit ? $debit[1] : '-',
                'plaque' => $plaque->id ?? 114,
                'city' => $plaque->city->id ?? 12,
                'code' => $code ? $code[0] : '-',
            ];
        } catch (\Throwable $th) {
            dd('0' . $content[6], $th->getMessage());
        }
    }

    static public function importsClientsAuto($content)
    {
        preg_match('/Adresse d’installation\s*:\s*(.*)/', $content, $client_address);
        preg_match('/Client\s*:\s*(\D*)Contact/', $content, $client_fullname);
        preg_match('/Offre\s*:\s*(\d*)/', $content, $client_debit);
        preg_match('/Login SIP:\s*(.*)/', $content, $client_sip);
        preg_match('/Contact Client\s*:\s*(\d*)/', $content, $client_phone);
        preg_match('/CODE\s*(.{7})/', $content, $plaque);
        preg_match('/CODE\s*(.{2})/', $content, $city);
        preg_match('/Login internet:\s*(.*)/', $content, $client_login);
        preg_match('/Routeur.*(F\d{3,4})/', $content, $routeur);
        preg_match('/Sous Type Opportunité\s*:\s*(.+)/', $content, $offre);
        preg_match('/Longitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lng);
        preg_match('/Latitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lat);

        $plaque = Plaque::with('city')->where('code_plaque', $plaque[1])->first();
        try {
            return [
                'address' => $client_address ? trim($client_address[1]) : '-',
                'name' => $client_fullname ? trim(Str::title($client_fullname[1])) : '-',
                'debit' => $client_debit ? trim($client_debit[1]) : '-',
                'sip' => $client_sip ? trim($client_sip[1]) : '-',
                'phone' => trim($client_phone[1]),
                'plaque' => $plaque != null ? $plaque->id : 114,
              //'plaque'=> 114,
                'city' => $plaque != null ?  $plaque->city->id : 12,
                  //'city' => 12,
                'login_internet' => $client_login[1] ?? '',
                'routeur' => $routeur ? 'ZTE ' . $routeur[1] : '-',
                'offre' => $offre ? trim($offre[1]) : '-',
                'lat' => $lat[1] ?? 'NaN',
                'lng' => $lng[1] ?? 'Nan',
                'type' => 'B2C',
            ];
        } catch (Exception $e) {
            dd($e);
        }
    }


    static public function importB2BClient($content)
    {
        preg_match('/Adresse d’installation\s*:\s*((?:.*\n)*.*)\s*Intervenant/', $content, $client_address);
        preg_match('/Client\s*:\s*(.*)Contact Client/', $content, $client_fullname);
        preg_match('/Offre\s*:\s*FTTH\s*(\d*)/', $content, $client_debit);
        preg_match('/Login SIP:\s*(\d+)(?:-.*)?/', $content, $client_sip);
        preg_match('/Numéro de la personne mandatée\s*:\s*(\d*)/', $content, $client_phone);
        preg_match('/CODE\s*(.{7})/', $content, $plaque);
        preg_match('/CODE\s*(.{2})/', $content, $city);
        preg_match('/Login internet:\s*(.*)Login/', $content, $client_login);
        preg_match('/Routeur.*(F\d{3,4})/', $content, $routeur);
        preg_match('/Sous Type Opportunité\s*:\s*(.+)\s*B/', $content, $offre);
        preg_match('/Longitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lng);
        preg_match('/Latitude\s*:\s*([+-]?\d+(\.\d+)?)/', $content, $lat);

        if ($plaque) {
            $plaque = Plaque::with('city')->where('code_plaque', $plaque[1])->first();
        }

        try {
            return [
                'address' => $client_address ? trim($client_address[1]) : '-',
                'name' => $client_fullname ? trim(Str::title($client_fullname[1])) : '-',
                'debit' => trim($client_debit[1] ?? ''),
                'sip' => $client_sip ? trim($client_sip[1] ?? '-') : '-',
                'phone' => $client_phone ? trim($client_phone[1] ?? '') : '-',
                'plaque' => $plaque != null ? $plaque->id : 114,
                'city' => $plaque != null ?  $plaque->city->id : 12,
                'login_internet' => $client_login ? $client_login[1] ?? '' : '-',
                'routeur' => $routeur ? 'ZTE ' . $routeur[1] : '-',
                'offre' => $offre ? (trim($offre[1]) == 'Nouvelle Offre' ?  'Nouvelle Offre' : 'Déménagement') : '-',
                'type' => 'B2B',
                'lat' => $lat ? $lat[1] : 0,
                'lng' => $lng ? $lng[1] : 0,
            ];
        } catch (Exception $e) {
            dd($e);
        }
    }


//     static public function importAuto()
//     {
//         try {
//             $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
//             set_time_limit(0);
//             $countClient = 0;
//             $cityIds = [];
//             $oClient = ClientIMAP::account('default')->connect();
//             $inbox = $oClient->getFolder('RaccoB2B');
//             $messages = $inbox->query()->unseen()->text('Installation Fibre Optique')->get();
//             if (count($messages) > 0) {
//                 foreach ($messages as $message) {
//                     $tech = null;
//                     $data = self::importsClientsAuto(str_replace('&nbsp;', ' ', strip_tags($message->getHTMLBody(true))));
//                     preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $data['address'], $code);
//                     $lat = $data['lat'];
//                     $lng = $data['lng'];

//                     if (isset($code[0])) {
//                         $item = Map::where('code', $code[0])->first();
//                         if ($item === null) {
//                             $gps = ClientsService::mapSurvey($code[0]);
//                             $lat = $gps->latitude;
//                             $lng = $gps->longitude;
//                             Map::create([
//                                 'code' => $code[0],
//                                 'lat' => $lat,
//                                 'lng' => $lng,
//                             ]);
//                         } else {
//                             $lat = $item->lat;
//                             $lng = $item->lng;
//                         }
//                     }

//                     preg_match('/\d{2}\.\d\.\d{2}/', $data['address'], $plaq_sp);
//                     if ($plaq_sp != null) {
//                         if (in_array($plaq_sp[0], $array_code)) {
//                             $tech = 91;
//                         }
//                     }

//                     $countClient++;
//                     $client = Client::where('sip', $data['sip'])
//                         ->where('offre', $data['offre'])->whereNull('deleted_at')
//                         ->first();
//                     if ($client === NULL || ($client->sip !== $data['sip'] && $client->type !== $data['type'])) {
//                         $countClient++;
//                         Client::create([
//                             'uuid' => Str::uuid(),
//                             'client_id' => $data['login_internet'] ?? '0',
//                             'type' => 'B2C',
//                             'offre' => $data['offre'] ?? '-',
//                             'name' => Str::title($data['name']),
//                             'address' => Str::title($data['address']),
//                             'lat' => $lat,
//                             'technicien_id' => $tech == null ? null : $tech,
//                             'lng' => $lng,
//                             'city_id' => $data['city'],
//                             'plaque_id' => $data['plaque'],
//                             'debit' => $data['debit'],
//                             'sip' => $data['sip'],
//                             'phone_no' => $data['phone'],
//                             'routeur_type' => $data['routeur'],
//                             'status' => $tech == null ? ClientStatusEnum::NEW : ClientStatusEnum::AFFECTED,
//                             'promoteur' => $tech == null ? 0 : 1,
//                         ]);
//                         $cityIds[] = $data['city'];
//                     }

//                     $message->move('INBOX.RaccoArchive');
//                     $message->setFlag('Seen');
//                 }
//             }
// //B2B 
//             $messagesB2B = $inbox->query()->unseen()->text("Passage à l'étape Installation")->get();
//             if (count($messagesB2B) > 0) {
//                 foreach ($messagesB2B as $ms) {
//                     $tech = null;
//                     $data = self::importB2BClient(str_replace('&nbsp;', ' ', strip_tags($ms->getHTMLBody(true))));
//                     preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $data['address'], $code);
//                     $lat = $data['lat'];
//                     $lng = $data['lng'];


//                     $item = null;
//                     if (isset($code[0])) {
//                         $item = Map::where('code', $code[0])->first();
//                     }

//                     if ($code != null) {
//                         if ($item === null) {
//                             $gps = ClientsService::mapSurvey($code[0]);
//                             $lat = $gps->latitude;
//                             $lng = $gps->longitude;
//                             Map::create([
//                                 'code' => $code[0],
//                                 'lat' => $lat,
//                                 'lng' => $lng,
//                             ]);
//                         } else {
//                             $lat = $item->lat;
//                             $lng = $item->lng;
//                         }
//                     }


//                     preg_match('/\d{2}\.\d\.\d{2}/', $data['address'], $plaq_sp);
//                     if ($plaq_sp != null) {
//                         if (in_array($plaq_sp[0], $array_code)) {
//                             $tech = 91;
//                         }
//                     }


//                     $client = Client::where('sip', $data['sip'])
//                         ->where('offre', $data['offre'])->whereNull('deleted_at')
//                         ->first();
//                     if ($client === NULL || ($client->sip !== $data['sip'])) {
//                         $countClient++;
//                         Client::create([
//                             'uuid' => Str::uuid(),
//                             'client_id' => $data['login_internet'] ?? '0',
//                             'type' => 'B2B',
//                             'offre' => $data['offre'] ?? '-',
//                             'name' => Str::title($data['name']),
//                             'address' => Str::title($data['address']),
//                             'lat' => $lat,
//                             'technicien_id' => $tech == null ? null : $tech,
//                             'lng' => $lng,
//                             'city_id' => $data['city'],
//                             'plaque_id' => $data['plaque'],
//                             'debit' => $data['debit'],
//                             'sip' => $data['sip'],
//                             'phone_no' => $data['phone'],
//                             'routeur_type' => $data['routeur'],
//                             'status' => $tech == null ? ClientStatusEnum::NEW : ClientStatusEnum::AFFECTED,
//                             'promoteur' => $tech == null ? 0 : 1,
//                         ]);
//                     }
//                     $ms->move('INBOX.RaccoArchive');
//                     $ms->setFlag('Seen');
//                 }
//             }

//             /* $techniciens = Technicien::whereHas('cities', function ($query) use ($cityIds) {
//                 $query->whereIn('city_id', $cityIds);
//             })->get();
//             $techniciensWithMultipleCities = collect();
//             foreach ($techniciens as $technicien) {
//                 if ($technicien->cities->count() > 1) {
//                     foreach ($technicien->cities as $city) {
//                         $techniciensWithMultipleCities->push($technicien->replicate()->setRelation('cities', collect([$city])));
//                     }
//                 } else {
//                     $techniciensWithMultipleCities->push($technicien);
//                 }
//             }
//             foreach ($techniciensWithMultipleCities as $technicien) {
//                 $fieldsh['include_player_ids'] = [$technicien->player_id];
//                 $notificationMsgi = 'Nouveaux clients disponibles dans votre zone.';
//                 OneSignal::sendPush($fieldsh, $notificationMsgi);
//             } */
//             Log::channel('mylog')->info($countClient . ' Clients have been imported.');
//             return $countClient;
//         } catch (Exception $e) {
//             dd($e->getMessage());
//             Log::channel('mylog')->info('Error : ' . $e->getMessage());
//             return $e->getMessage();
//         }
//     }

    static public function mapSurvey($newClient)
    {
        try {
            // Create HTTP client object
            $client = new \GuzzleHttp\Client();

            // Send HTTP GET request to the login page to get the CSRF token and cookies
            $response = $client->get('https://mapsurvey.orange.ma/login');
            $getcsrftoken = $response->getBody()->getContents();
            $headerSetCookies = $response->getHeader('Set-Cookie');

            // Process the cookies received in the response headers
            $cookieJar = new CookieJar(false);
            foreach ($headerSetCookies as $headerSetCookie) {
                $cookie = SetCookie::fromString($headerSetCookie);
                $cookie->setDomain('mapsurvey.orange.ma');
                $cookieJar->setCookie($cookie);
            }

            // Extract the CSRF token from the HTML response
            $dom = new DOMDocument();
            $dom->loadHTML($getcsrftoken, LIBXML_NOERROR);
            $xpath = new \DOMXPath($dom);
            $csrf = $xpath->query('//input[@name="_csrf_token"]')->item(0)->attributes->getNamedItem('value')->nodeValue;

            // Send HTTP POST request to the login page with the username, password, and CSRF token
            $response = $client->post(
                'https://mapsurvey.orange.ma/login',
                [
                    'form_params' => [
                        '_username' => 'rn08425',
                        '_password' => 'Orange_2019',
                        '_csrf_token' => $csrf,
                    ],
                    'cookies' => $cookieJar,
                ]
            );

            // Send HTTP GET request to get the GPS coordinates of the given address
            $response_address = $client->get(
                'https://mapsurvey.orange.ma/ftth/serach/address?input_search=' . $newClient,
                [
                    'cookies' => $cookieJar,
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                ],
            );

            // Parse the HTML response to extract the GPS coordinates
            $body = $response_address->getBody()->getContents();
            $gps = null;
            if (!empty($body)) {
                $dom = new DOMDocument();
                $dom->loadHTML($body);
                $xpath = new \DOMXPath($dom);
                $contents = $xpath->query('//li');
                foreach ($contents as $item) {
                    $gps = json_decode($item->attributes->getNamedItem('value')->nodeValue);
                }
            }
            return $gps;
        } catch (Exception $e) {
            // Handle exceptions thrown during HTTP requests or DOM manipulation
            return $e->getMessage();
        }
    }
// right one created by chahid 
    // static public function newAffecttion($data)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $count = 0;
    //         foreach ($data['selectedItems'] as $item) {
    //             $affectation = Affectation::updateOrCreate([
    //                 'client_id' => $item,
    //             ], [
    //                 'uuid' => Str::uuid(),
    //                 'client_id' => $item,
    //                 'technicien_id' => $data['technicien_affectation'],
    //                 'status' => 'En cours',
    //                 'affected_by' => Auth::user()->id,
    //             ]);
    //             Client::where('id', $affectation->client_id)->update([
    //                 'type_affectation' => 'Manuelle',
    //             ]);
    //             $count++;
    //         }
    //         DB::commit();

    //         $technicien = Technicien::find($data['technicien_affectation']);
    //         $filedsh['include_player_ids'] = [$technicien->player_id];
    //         $message = $count > 1 ? $count . ' clients vous ont été affectés.' : 'Un client vous a été affecté.';

    //         OneSignal::sendPush($filedsh, $message);
    //         Notification::create([
    //             'uuid' => Str::uuid(),
    //             'title' => 'Affectation',
    //             'data' => $message,
    //             'user_id' => $technicien->user_id,
    //         ]);

    //         return true;
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         Log::channel('mylog')->error(Auth::user()->last_name . ' ' . Auth::user()->first_name . ' Try to affect manually - ' . $th);
    //         return $th;
    //     }
    // }

// test function 
    static public function newAffecttion($data)
    {
        try {
            DB::beginTransaction();
            $count = 0;
            foreach ($data['selectedItems'] as $item) {
                $affectation = Affectation::updateOrCreate([
                    'client_id' => $item,
                ], [
                    'uuid' => Str::uuid(),
                    'client_id' => $item,
                  //'technicien_id' => $data['technicien_affectation'],
                    'soustraitant_id' => $data['soustraitant_affectation'],
                    'status' => 'Affecté',
                    'affected_by' => Auth::user()->id,
                ]);

                Log::info($affectation);
                Client::where('id', $affectation->client_id)->update([
                    'type_affectation' => 'Manuelle',
                    'status' => 'Affecté',
                ]);
                $count++;
            }
            DB::commit();

            // $technicien = Technicien::find($data['technicien_affectation']);
            // $filedsh['include_player_ids'] = [$technicien->player_id];
            // $message = $count > 1 ? $count . ' clients vous ont été affectés.' : 'Un client vous a été affecté.';

            // OneSignal::sendPush($filedsh, $message);
            // Notification::create([
            //     'uuid' => Str::uuid(),
            //     'title' => 'Affectation',
            //     'data' => $message,
            //     'user_id' => $technicien->user_id,
            // ]);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('mylog')->error(Auth::user()->last_name . ' ' . Auth::user()->first_name . ' Try to affect manually - ' . $th);
            return $th;
        }
    }

    static public function assigneTechnicien($data)
    {
        try {
            DB::beginTransaction();
    
            $affectationIds = array_map(function ($id) {
                return (int)$id;
            }, $data['selectedItems']);
    
            // Check if all affectations exist
            $existingIds = Affectation::whereIn('id', $affectationIds)->pluck('id')->toArray();
            if (count($existingIds) !== count($affectationIds)) {
                throw new \Exception("Some affectations do not exist.");
            }
    
            // Update each affectation individually and add notifications
            foreach ($affectationIds as $affectationId) {
                $affectation = Affectation::find($affectationId);
                if ($affectation) {
                    $affectation->technicien_id = $data['technicien_affectation'];
                    $affectation->status = 'En cours';
                    $affectation->save();
    
                    // Add a notification for the affectation
                    $message = count($affectationIds) > 1 
                        ? count($affectationIds) . ' clients vous ont été affectés.' 
                        : 'Un client vous a été affecté';
    
                    Notification::create([
                        'uuid' => Str::uuid(),
                        'title' => 'Affectation',
                        'data' => $message,
                        'user_id' => Technicien::find($data['technicien_affectation'])->user_id,
                        'affectation_id' => $affectationId,
                    ]);
                }
            }
    
            // Update the Client table outside the loop
            $clientIds = Affectation::whereIn('id', $affectationIds)->pluck('client_id')->toArray();
            Client::whereIn('id', $clientIds)->update([
                'technicien_id' => $data['technicien_affectation'],
            ]);
    
            DB::commit();
    
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('mylog')->error(Auth::user()->last_name . ' ' . Auth::user()->first_name . ' Try to affect manually - ' . $th);
            return $th;
        }
    }
    
    static public function edit($data, $client_id)
    {
        try {
            $client = Client::find($client_id);
            $plaque_id = $client->plaque_id;
            $city_id = $client->city_id;
            $lat = $client->lat;
            $lng = $client->lng;

            DB::beginTransaction();

            preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $data['e_address'], $code);
            if ($client->address != $data['e_address']) {
                preg_match('/CODE\s*(.{7})/', $data['e_address'], $plaque);
                $pl = Plaque::with('city')->where('code_plaque', $plaque[1])->first();
                $plaque_id = $pl ? $pl->id : 114;
                $city_id = $pl ? $pl->city->id : 12;
                if (isset($code[0])) {
                    $item = Map::where('code', $code[0])->first();
                    if ($item === null) {
                        $gps = self::mapSurvey($code[0]);
                        $lat = $gps->latitude;
                        $lng = $gps->longitude;
                        Map::create([
                            'code' => $code[0],
                            'lat' => $lat,
                            'lng' => $lng,
                        ]);
                    } else {
                        $lat = $item->lat;
                        $lng = $item->lng;
                    }
                }
            }

            $client->update([
                'client_id' => $data['e_id'] ?? '0',
                'type' => $data['e_type'],
                'offre' => $data['e_offre'],
                'name' => Str::title($data['e_name']),
                'address' => $data['e_address'],
                'lat' => $lat,
                'lng' => $lng,
                'plaque' => $plaque_id,
                'city_id' => $city_id,
                'debit' => $data['e_debit'],
                'sip' => $data['e_sip'],
                'phone_no' => $data['e_phone'],
                'routeur_type' => $data['e_routeur'],
            ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::chanel('error')->error('Function edit in ClientService.php : ' . $th->getMessage());
            return false;
        }
    }

    static public function editSav($data, $client_id)
    {
        try {
            $client = ClientSav::find($client_id);
            Log::info($data, $client_id);
            $client->update([
                'n_case' => $data['new_id_case'] ?? '0',
                'login' => $data['new_network_access'],
                'sip' => $data['new_line_number'],
                'address' => $data['new_address'],
                'client_name' => $data['new_full_name'],
                'contact' => $data['new_contact_number'],
                'comment' => $data['new_comment'],
                'service_activities' => $data['new_service_activities'],
          
            ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::channel('error')->error('Function edit in ClientService.php : ' . $th->getMessage());
            return false;
        }
    }

    static function kpisController()
    {
        return [
            'injoignable' => Blocage::where('cause', 'Injoignable/SMS')->where('resolue', 0)->count(),
            'indisponible' => Blocage::where('cause', 'Indisponible')->where('resolue', 0)->count(),
            'cancel_client' => Blocage::where('cause', 'Client  a annulé sa demande')->where('resolue', 0)->count(),
        ];
    }


    static function importB2B()
    {
        $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
        set_time_limit(0);
        $countClient = 0;
        $cityIds = [];
        $oClient = ClientIMAP::account('default')->connect();
        $inbox = $oClient->getFolder('Racco');
        $messagesB2B = $inbox->query()->unseen()->text("Passage")->get();
        if (count($messagesB2B) > 0) {
            foreach ($messagesB2B as $ms) {
                $tech = null;
                $data = self::importB2BClient(str_replace('&nbsp;', ' ', strip_tags($ms->getHTMLBody(true))));
                preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $data['address'], $code);
                $item = Map::where('code', $code[0])->first();
                if ($item === null) {
                    $gps = ClientsService::mapSurvey($code[0]);
                    $lat = $gps->latitude;
                    $lng = $gps->longitude;
                    Map::create([
                        'code' => $code[0],
                        'lat' => $lat,
                        'lng' => $lng,
                    ]);
                } else {
                    $lat = $item->lat;
                    $lng = $item->lng;
                }

                preg_match('/\d{2}\.\d\.\d{2}/', $data['address'], $plaq_sp);
                if (in_array($plaq_sp[0], $array_code)) {
                    $tech = 91;
                }
                $client = Client::where('sip', $data['sip'])
                    ->where('offre', $data['offre'])->whereNull('deleted_at')
                    ->first();
                if ($client === NULL || ($client->sip !== $data['sip'] && $client->offre !== $data['offre'])) {
                    $countClient++;
                    Client::create([
                        'uuid' => Str::uuid(),
                        'client_id' => $data['login_internet'] ?? '0',
                        'type' => 'B2B',
                        'offre' => $data['offre'] ?? '-',
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'lat' => $lat,
                        'technicien_id' => $tech == null ? null : $tech,
                        'lng' => $lng,
                        'city_id' => $data['city'],
                        'plaque_id' => $data['plaque'],
                        'debit' => $data['debit'],
                        'sip' => $data['sip'],
                        'phone_no' => $data['phone'],
                        'routeur_type' => $data['routeur'],
                        'status' => $tech == null ? ClientStatusEnum::NEW : ClientStatusEnum::AFFECTED,
                        'promoteur' => $tech == null ? 0 : 1,
                    ]);
                    $cityIds[] = $data['city'];
                }
                $ms->move('INBOX.RaccoArchive');
                $ms->setFlag('Seen');
            }
        }
    }

    static function getLatLongFromOpenCage($address) {
        $apiKey = env('OPENCAGE_API_KEY');
        $address = urlencode($address);
    
        // OpenCage Geocoding API endpoint
        $url = "https://api.opencagedata.com/geocode/v1/json?q={$address}&key={$apiKey}";
    
        // Send the request using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        // Decode the response
        $responseData = json_decode($response, true);
    
        // Check if the response contains data
        if ($httpCode == 200 && isset($responseData['results'][0])) {
            return [
                'latitude' => $responseData['results'][0]['geometry']['lat'],
                'longitude' => $responseData['results'][0]['geometry']['lng']
            ];
        } else {
            Log::error('OpenCage Geocoding API error', [
                'http_code' => $httpCode,
                'response' => $responseData,
                'address' => $address
            ]);
            return ['error' => 'No results found'];
        }
    }
}
