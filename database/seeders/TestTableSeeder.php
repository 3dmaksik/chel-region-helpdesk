<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Cabinet;
use App\Models\Category;
use App\Models\User;
use App\Models\Help;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Base\Helpers\GeneratorAppNumberHelper;
use Carbon\Carbon;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cabinetFile = Storage::disk('public')->get('cabinet.json');
        $categoryFile = Storage::disk('public')->get('category.json');
        $workFile = Storage::disk('public')->get('work.json');
        $cabinets = json_decode((string) $cabinetFile, true, JSON_THROW_ON_ERROR);
        $categories = json_decode((string) $categoryFile, true, JSON_THROW_ON_ERROR);
        $works = json_decode((string) $workFile, true, JSON_THROW_ON_ERROR);
        $helpFile = Storage::disk('public')->get('help.json');
        $helps = json_decode((string) $helpFile, true, JSON_THROW_ON_ERROR);
        foreach ($cabinets as $cabinet) {
            $database = new Cabinet();
            $database->id = $cabinet['id'];
            $database->description = $cabinet['description'];
            $database->created_at = $cabinet['created_at'];
            $database->updated_at = $cabinet['updated_at'];
            DB::transaction(
                fn () => $database->save()
            );

        }
        foreach ($categories as $category) {
            $database = new Category();
            $database->id = $category['id'];
            $database->description = $category['description'];
            $database->created_at = $category['created_at'];
            $database->updated_at = $category['updated_at'];
            DB::transaction(
                fn () => $database->save()
            );

        }
        foreach ($works as $work) {
            $database = new User();
            $database->id = $work['id'];
            $flp = explode(" ", $work['description']);
            $database->cabinet_id = 1;
            $database->name = $work['id'];
            $database->email = mt_rand().time().'@1.ru';
            $database->email_verified_at = now();
            $database->password = Hash::make('password');
            if ($work['id'] ==4)
            {
                $database->name = 'nataly';
            }
            $database->firstname = $flp[1];
            $database->lastname = $flp[0];
            $database->patronymic = $flp[2];
            $database->created_at = $work['created_at'];
            $database->updated_at = $work['updated_at'];
            DB::transaction(
                fn () => $database->save()
            );
            $database->assignRole('user');
        }
        $user = User::where('name','nataly')->first();
        $user->syncRoles('superAdmin');
        foreach ($helps as $help) {
            $database = new Help();
            $database->id = $help['id'];
            $last= Help::select('app_number')->orderBy('id', 'desc')->first();
            $last ? $app_number = GeneratorAppNumberHelper::generate($last->app_number) : $app_number = GeneratorAppNumberHelper::generate();
            $database->app_number = $app_number;
            $database->category_id = $help['category_id'];
            $database->status_id = $help['status_id'];
            $database->priority_id = 1;
            $database->user_id = $help['work_id'];
            $database->executor_id = 4;
            $database->description_long = $help['description_long'];
            $database->info_final = $help['info'];
            $database->calendar_request	= $help['calendar_request'];
            $database->calendar_accept = $help['calendar_request'];
            $database->calendar_warning = Carbon::parse($help['calendar_request'])->addHours(4);
            $database->calendar_execution = Carbon::parse($help['calendar_request'])->addHours(8);
            $database->calendar_final = $help['calendar_final'];
            $database->check_write = true;
            $database->lead_at = Carbon::parse($help['calendar_final'])->diffInSeconds(Carbon::parse($help['calendar_request']));
            $database->created_at = $help['created_at'];
            $database->updated_at = $help['updated_at'];
            DB::transaction(
                fn () => $database->save()
            );
        }
    }
}
