<?php
/** Helper for API page import. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2120
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Dashboard\Admins\AdmikoPageImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Dashboard\AdmikoHelperTrait;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdmikoPageImportController extends Controller
{
    use AdmikoHelperTrait;

    public function index()
    {
        if (auth()->user()->role_id != 1) {
            return redirect(route("dashboard.home"));
        }
        $dataApi = Http::get('https://admiko.com/account/project/api', [
            'key' => config("admiko_version.project_key"),
            'ver' => config("admiko_version.version")
        ])->object();
        $errors = '';
        $admikoUpdateInfo = '';
        $tableData = '';
        if (isset($dataApi->error) && $dataApi->error != '') {
            $errors = $dataApi->error;
        } else {
            if (Session::has('error')) {
                $errors = Session::get('error');
            }
            $tableData = $dataApi->pagesList;
            if($dataApi->admikoUpdateInfo){
                $admikoUpdateInfo = base64_decode($dataApi->admikoUpdateInfo);
            }
        }
        $admiko_data['sideBarActive'] = "admikoImport";
        $admiko_data['sideBarActiveFolder'] = "";
        return view("dashboard.admins.admiko_page_import.index")->with(compact('admiko_data', "tableData", "admikoUpdateInfo", "errors"));
    }

    public function import(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            return redirect(route("dashboard.home"));
        }
        if(isset($request->backup_folder) && !empty($request->backup_folder)) {
            $backup_folder = $request->backup_folder;
        } else {
            $backup_folder = Carbon::now()->format("Y-m-d_H.i.s");
        }
        if ($request->admikoUpdate == 1) {
            $dataApi = Http::get('https://admiko.com/account/project/api', [
                'key'  => config("admiko_version.project_key"),
                'admikoUpdate' => 1,
                'ver' => config("admiko_version.version")
            ])->object();
            if (isset($dataApi->error) && $dataApi->error != '') {
                return redirect(route("dashboard.admiko_page_import"))->with('error', $dataApi->error);
            }
            if(count($dataApi->files) > 0){
                foreach ($dataApi->files as $files) {
                    $file = base64_decode($files->file);
                    $code = base64_decode($files->code);
                    $this->backupAndSave($file,$code,$backup_folder);
                }
            }
            if(count($dataApi->database) > 0){
                $this->setupDatabase($dataApi->database);
            }
        } elseif ($request->admikoUpdateGlobalFiles == 1) {
            $dataApi = Http::get('https://admiko.com/account/project/api', [
                'key'  => config("admiko_version.project_key"),
                'admikoUpdateGlobalFiles' => 1,
                'ver' => config("admiko_version.version")
            ])->object();
            if (isset($dataApi->error) && $dataApi->error != '') {
                return redirect(route("dashboard.admiko_page_import"))->with('error', $dataApi->error);
            }
            if(count($dataApi->files) > 0){
                foreach ($dataApi->files as $files) {
                    $file = base64_decode($files->path) . base64_decode($files->file);
                    $code = base64_decode($files->code);
                    $this->backupAndSave($file,$code,$backup_folder);
                }
            }
            if(count($dataApi->database) > 0){
                $this->setupDatabase($dataApi->database);
            }
        } else {
            foreach ($request->idImport as $id) {
                $dataApi = Http::get('https://admiko.com/account/project/api', [
                    'key'  => config("admiko_version.project_key"),
                    'page' => $id,
                    'ver' => config("admiko_version.version")
                ])->object();
                if (isset($dataApi->error) && $dataApi->error != '') {
                    return redirect(route("dashboard.admiko_page_import"))->with('error', $dataApi->error);
                }
                if(count($dataApi->files) > 0){
                    foreach ($dataApi->files as $files) {
                        $file = base64_decode($files->path) . base64_decode($files->file);
                        $code = base64_decode($files->code);
                        $this->backupAndSave($file,$code,$backup_folder);
                    }
                }
                if(count($dataApi->database) > 0){
                    $this->setupDatabase($dataApi->database);
                }
            }
            return response()->json(['status'=>'done','backup_folder'=>$backup_folder]);
        }

        return back();
    }
    public function backupAndSave($file,$code,$backup_folder) {
        if (config('filesystems.disks.admiko_api_import')) {
            if (Storage::disk('admiko_api_import')->exists($file)) {
                if(Storage::disk('admiko_api_import')->exists(config("admiko_config.backup_location").'/' . $backup_folder .'/'.$file)){
                    //Storage::disk('admiko_api_import')->delete(config("admiko_config.backup_location").'/' . $backup_folder .'/'.$file);
                    /**We don't want to lose any file**/
                    $file_new_name = $this->createUniqueName($file,$backup_folder,1);
                    Storage::disk('admiko_api_import')->move($file, config("admiko_config.backup_location").'/' . $backup_folder .'/'.$file_new_name);
                } else {
                    Storage::disk('admiko_api_import')->move($file, config("admiko_config.backup_location") . '/' . $backup_folder . '/' . $file);
                }
            }
            Storage::disk('admiko_api_import')->put($file, $code);
        } else {
            return redirect(route("dashboard.admiko_page_import"))->with('error', trans('global.admiko_api_import_missing'));
        }
    }
    public function createUniqueName($file,$backup_folder,$counter) {
        if(Storage::disk('admiko_api_import')->exists(config("admiko_config.backup_location").'/' . $backup_folder .'/'.$file.$counter)){
            $counter = $counter + 1;
            return $this->createUniqueName($file,$backup_folder,$counter);
        }
        return $file.$counter;
    }
}
