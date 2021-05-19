<?php
/** Auditable Logs Controller **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2120
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Dashboard\Admins;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admins\AdmikoAuditable;
use Illuminate\Http\Request;

class AdmikoAuditableLogsController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            return redirect(route("dashboard.home"));
        }
        $admiko_data['sideBarActive'] = "admiko_auditable_logs";
		$admiko_data["sideBarActiveFolder"] = "";

        $tableData = AdmikoAuditable::search($request->query("search"))->orderByDesc("id")->paginate($request->query("length")??array_key_first(config("admiko_config.length_menu_table")));
        return view("dashboard.admins.admiko_auditable_logs.index")->with(compact('admiko_data', "tableData"));
    }

    public function show($id)
    {
        $AuditableLogs = AdmikoAuditable::find($id);
        if (auth()->user()->role_id != 1 || !$AuditableLogs) {
            return redirect(route("dashboard.admiko_auditable_logs.index"));
        }

        $admiko_data['sideBarActive'] = "admiko_auditable_logs";
        $admiko_data["sideBarActiveFolder"] = "";

        $data = $AuditableLogs;
        return view("dashboard.admins.admiko_auditable_logs.view")->with(compact('admiko_data', 'data'));
    }

}
