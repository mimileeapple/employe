<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tripsign extends Model
{
    protected $table ='tripsign';
    //protected $fillable =['orderid','empid','name','title','data','name','createmp'];
    protected $fillable =['orderid','empid','name','supervisorid','managerid',
'financeid','supervisorname','managername','financename','supervisorsign',
'managersign','financesign','supervisormail','managermail','financemail',
'signsts','ordersts','createmp','updateemp'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'orderid';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';

public function updateBatch($multipleData = [])
{
    try {
        if (empty($multipleData)) {
            throw new \Exception("數據不能爲空");
        }
        $tableName = tripsign . phpDB::getTablePrefix(); // 表名
        $firstRow  = current($multipleData);

        $updateColumn = array_keys($firstRow);
        // 默認以id爲條件更新，如果沒有ID則以第一個字段爲條件
        $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
        unset($updateColumn[0]);
        // 拼接sql語句
        $updateSql = "UPDATE " . $tableName . " SET ";
        $sets      = [];
        $bindings  = [];
        foreach ($updateColumn as $uColumn) {
            $setSql = "`" . $uColumn . "` = CASE ";
            foreach ($multipleData as $data) {
                $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                $bindings[] = $data[$referenceColumn];
                $bindings[] = $data[$uColumn];
            }
            $setSql .= "ELSE `" . $uColumn . "` END ";
            $sets[] = $setSql;
        }
        $updateSql .= implode(', ', $sets);
        $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
        $bindings  = array_merge($bindings, $whereIn);
        $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
        $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
        // 傳入預處理sql語句和對應綁定數據
        return DB::update($updateSql, $bindings);
    } catch (\Exception $e) {
        return false;
    }
}
}
