<?php

namespace App\Imports;

use App\Enums\ClientStatusEnum;
use App\Models\Client;
use App\Models\Map;
use App\Models\Pipe;
use App\Models\Plaque;
use App\Services\web\ClientsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PipeImport implements ToModel, WithStartRow
{

    use Importable;

    private static $numImported = 0;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        DB::beginTransaction();
        $id = null;
        $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
        $tech = null;
        try {
            $data = ClientsService::importsPipe($row);
            $item = null;
            $id = '0' . $row[5];
            $lat = null;
            $lng = null;

            $item = Map::where('code', $data['code'])->first();
            if ($item === null) {
                $gps = ClientsService::mapSurvey($data['code']);
                $lat = $gps->latitude;
                $lng = $gps->longitude;
                Map::create([
                    'code' => $data['code'],
                    'lat' => $lat,
                    'lng' => $lng,
                ]);
            } else {
                $lat = $item->lat;
                $lng = $item->lng;
            }

            preg_match('/\d{2}\.\d\.\d{2}/', $row[1], $plaq_sp);
            if ($plaq_sp != null) {
                if (in_array($plaq_sp[0], $array_code)) {
                    $tech = 91;
                }
            }

            $client = Client::where([['sip', $row[5]], ['offre',$row[14] == 'DEM' ? 'Déménagement' : $row[14]]])
                ->first();
            if ($client === NULL || ($client->sip !== '0' . $row[5])) {
                Client::firstOrCreate(
                    [
                        'sip' => '0' . $row[5],
                        'offre' => $row[14] == 'DEM' ? 'Déménagement' : $row[14],
                    ],
                    [
                        'uuid' => Str::uuid(),
                        'client_id' => $row[6] ?? '-',
                        'type' => 'B2C',
                        'offre' => $row[14] == 'DEM' ? 'Déménagement' : $row[14],
                        'name' => Str::title($data['name']) ?? '-',
                        'address' => mb_convert_encoding($row[1], 'ISO-8859-1', 'UTF-8') ?? '-',
                        'lat' => $lat,
                        'lng' => $lng,
                        'technicien_id' => $tech == null ? null : $tech,
                        'city_id' => $data['city'],
                        'plaque_id' => $data['plaque'],
                        'debit' => $data['debit'] == 12 ? 20 : $data['debit'],
                        'sip' => '0' . $row[5],
                        'phone_no' => '0' . $row[11] ?? '-',
                        'routeur_type' => $data['routeur'],
                        'status' => $tech == null ? ClientStatusEnum::NEW : ClientStatusEnum::AFFECTED,
                        'type_affectation' => 'PIPE',
                        'created_by' => Auth::user()->id,
                        'promoteur' => $tech == null ? 0 : 1,
                    ]
                );
            }
            DB::commit();
            self::$numImported++;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $id);
        }
    }

    public static function getNumImported()
    {
        return self::$numImported;
    }
}
