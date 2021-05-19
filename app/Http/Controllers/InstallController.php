<?php
/** Installation for backend login. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2120
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Dashboard\AdmikoHelperTrait;
use App\Models\Dashboard\Admins\Admins;
use App\Models\Dashboard\Admins\AdminRoles;
use Illuminate\Support\Facades\DB;
use File;

class InstallController extends Controller
{
    use AdmikoHelperTrait;

    public function index()
    {
        Artisan::call('key:generate');
        return redirect('install');
    }

    public function install()
    {
        return view('install');
    }

    public function db_save(Request $request)
    {
        $this->validator($request);
        if (config('database.default') == 'mysql') {
            //todo: setup connections for other database types!!!!!!
            config(['database.connections.mysql.host' => $request->db_host]);
            config(['database.connections.mysql.database' => $request->db_table]);
            config(['database.connections.mysql.username' => $request->db_user]);
            config(['database.connections.mysql.password' => $request->db_password]);
        } else {
            return redirect()->back()->withInput()->with('error', 'Unsupported database type!');
        }
        try {
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {
                $data = [
                    'APP_URL'     => URL::to('/'),
                    'DB_HOST'     => $request->db_host,
                    'DB_DATABASE' => $request->db_table,
                    'DB_USERNAME' => $request->db_user,
                    'DB_PASSWORD' => $request->db_password,
                ];
                $defaults = [env("APP_URL"), env("DB_HOST"), env("DB_DATABASE"), env("DB_USERNAME"), env("DB_PASSWORD")];
                $path = base_path('.env');
                $content = file_get_contents($path);
                $i = 0;
                foreach ($data as $key => $value) {
                    $content = str_replace($key . '=' . $defaults[$i], $key . '=' . $value, $content);
                    $i++;
                }
                File::put(base_path() . '/.env', $content);
                $tableData[] = array("table" => "admins", "timeStamp" => 1, "tableFields" => array("name" => "string", "email" => "stringUnique", "password" => "string", "image" => "binary", "theme" => "string100", "role_id" => "integer", "remember_token" => "string100", "reset_token" => "string100"));
                $tableData[] = array("table" => "admins_roles", "timeStamp" => 1, "tableFields" => array("title" => "string"));
                $tableData[] = array("table" => "admins_roles_permission", "timeStamp" => 0, "tableFields" => array("role_id" => "integer", "permission" => "string", "tableForeignKeys" => array("role_id" => "admins_roles")));
                $tableData[] = array("table" => "admiko_auditable_logs", "timeStamp" => 1, "tableFields" => array("action" => "string", "row_id" => "bigIntegerNullable", "model" => "string", "user_id" => "bigIntegerNullable", "info" => "text", "url" => "text", "ip" => "string"));

                //        Schema::create('admiko_auditable_logs', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->text('action');
//            $table->unsignedBigInteger('table_id')->nullable();
//            $table->string('model')->nullable();
//            $table->unsignedBigInteger('user_id')->nullable();
//            $table->text('info')->nullable();
//            $table->string('ip', 45)->nullable();
//            $table->timestamps();
//        });

                $this->setupDatabase($tableData);
                $data['name'] = $request->name??$request->email;
                $data['email'] = $request->email;
                $data['password'] = $request->password;
                $data['theme'] = 'admiko';
                $avatar = file_get_contents(base_path('public/assets/admiko/images/').'avatar.jpg');
                $base64 = base64_encode($avatar);
                $data['image'] = 'data:image/jpeg;base64,'.$base64;
                $data['role_id'] = 1;
                Admins::create($data);
                AdminRoles::create(['id' => 1, 'title' => 'Developer']);
                AdminRoles::create(['id' => 2, 'title' => 'User']);
                File::delete(base_path('routes') . '/web.php');
                File::move(base_path('routes') . '/web_original.php', base_path('routes') . '/web.php');
                File::delete(base_path('resources/views') . '/install.blade.php');
                File::delete(base_path('app/Http/Controllers') . '/InstallController.php');
                File::delete(base_path('resources/lang/en') . '/install.php');
                return redirect('dashboard');
            } else {
                return redirect()->back()->withInput()->with('error', trans('install.db_error'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', trans('install.db_error'));
        }
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|min:5|max:100',
            'password' => 'required|string|min:6|max:100',
            'db_host'  => 'required|string|min:1|max:100',
            'db_table' => 'required|string|min:1|max:100',
            'db_user'  => 'required|string|min:1|max:100',
        ];
        $request->validate($rules);
    }
}
