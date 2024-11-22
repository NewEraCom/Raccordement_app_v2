<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\ClientStatusEnum;
use App\Models\Client;
use App\Models\Map;
use App\Services\web\ClientsService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientsImport implements ToModel, WithStartRow
{
    use Importable;

    private static $numImported = 0;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if($row[2] == null) return;
        $data = ClientsService::importsClients($row[2]);
        preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $data['address'], $code);
        $lat = $data['lat'];
        $lng = $data['lng'];

        if ($lat == 'Nan' || $lng == 'Nan') {
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
        }


        Client::firstOrCreate(
            [
                'sip' => $data['sip'],
                'offre' => $data['offre'] ?? '-',
            ],
            [
                'uuid' => Str::uuid(),
                'client_id' => $data['login_internet'],
                'type' => 'B2C',
                'offre' => $data['offre'] ?? '-',
                'name' => $data['name'],
                'address' => $data['address'],
                'lat' => $lat,
                'lng' => $lng,
                'city_id' => $data['city'],
                'plaque_id' => $data['plaque'],
                'debit' => $data['debit'] == 12 ? 20 : $data['debit'],
                'sip' => $data['sip'],
                'phone_no' => $data['phone'],
                'routeur_type' => $data['routeur'],
                'status' => ClientStatusEnum::NEW,
                'created_by' => Auth::user()->id,
            ]
        );

        self::$numImported++;
    }

    public static function getNumImported()
    {
        return self::$numImported;
    }
}
