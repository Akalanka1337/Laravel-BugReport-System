<?php
/** Helper trait for auditable logs. **/

/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2120
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */

namespace App\Http\Controllers\Traits\Dashboard;

use App\Models\Dashboard\Admins\AdmikoAuditable;
use Illuminate\Database\Eloquent\Model;

trait AdmikoAuditableTrait
{
    public static function bootAdmikoAuditableTrait()
    {
        static::created(function (Model $model) {
            self::admikoSaveAuditable('created', $model);
        });

        static::updated(function (Model $model) {
            self::admikoSaveAuditable('updated', $model);
        });

        static::deleted(function (Model $model) {
            self::admikoSaveAuditable('deleted', $model);
            if (!method_exists($model, 'runSoftDelete')) {
                self::admikoSoftDeleteCascadeLog(get_class($model), [$model->id]);
            }
        });
    }

    protected static function admikoSaveAuditable($action, $model)
    {

        AdmikoAuditable::create([
            'action'   => $action,
            'row_id' => $model->id ?? null,
            'model'    => get_class($model) ?? null,
            'user_id'  => auth()->id() ?? null,
            'info'     => $model ?? null,
            'url'     => url()->current() ?? null,
            'ip'       => request()->ip() ?? null,
        ]);
    }

    protected static function admikoSoftDeleteCascadeLog($modelPath, $deleteId)
    {
        if (property_exists(app($modelPath), 'admikoCascadeDelete')) {
            $cascade = $modelPath::$admikoCascadeDelete;
            foreach ($cascade as $key_id => $modelArray) {
                foreach ($modelArray as $model) {
                    $getModel = app($modelPath . '\\' . $model);
                    if (property_exists($getModel, 'admikoCascadeDelete')) {
                        $deleteIdArray = $getModel::whereIn($key_id, $deleteId)->pluck('id');
                        if (count($deleteIdArray) > 0) {
                            self::admikoSoftDeleteCascadeLog($modelPath . '\\' . $model, $deleteIdArray);
                        }
                    }
                    $deleteIdArray = $getModel::whereIn($key_id, $deleteId)->get();
                    foreach($deleteIdArray as $singleId){
                        self::admikoSaveAuditable('deleted', $getModel::find($singleId->id));
                    }
                }
            }
        }
    }
}
