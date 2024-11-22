<?php

namespace App\Imports;

use App\Mail\TechnicienMailNewAccount;
use App\Models\City;
use App\Models\Soustraitant;
use App\Models\Technicien;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;

class TechnicienImport implements ToModel, WithStartRow
{
    use Importable;

    private static $numImported = 0;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if (!User::where('email',  strtolower($row[2]))->exists()) {
            DB::beginTransaction();
            try {
                $user = User::create(
                    [
                        'uuid' => Str::uuid(),
                        'first_name' => ucfirst(strtolower(trim($row[0]))),
                        'last_name' => ucfirst(strtolower(trim($row[1]))),
                        'email' => strtolower($row[2]),
                        'phone_no' => '0' . $row[5],
                        'password' => bcrypt(ucfirst(strtolower($row[1])) . '123'),
                    ]
                );

                $user->assignRole('technicien');

                $technicien = Technicien::create([
                    'user_id' => $user->id,
                    'planification_count' => 3,
                    'soustraitant_id' => Soustraitant::where('name', $row[3])->first()->id,
                ]);

                $cities = explode('/', $row[4]);

                foreach ($cities as $city) {
                    City::where('name', ucfirst(strtolower($city)))->first()->techniciens()->attach($technicien->id);
                }

                DB::commit();

                self::$numImported++;
            } catch (\Throwable $th) {
                //Mail::to($user->email)->send(new TechnicienMailNewAccount($user, ucfirst(strtolower($row[1])) . '123'));
                DB::rollback();
                Log::channel('error')->error('Function Model in TechnicienImport.php : ' . $th->getMessage() . ' - For The user ' . $row[2]);
            }
        }
    }

    static function getNumImported()
    {
        return self::$numImported;
    }
}
