<?php

namespace App\Exports;
use App\Model\d_material;
use App\Model\product;
use App\Model\product_head;//抬頭的兩個
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
class materialExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

       return d_material::all();
    }


    /*設定標題列*/
    public function headings(): array
    {
        //第一列為先放一個空白的資料，後面會取代掉
        $a = product::all();
        $b = product_head::all();
        $a = $a[0];
        $b = $b[0];

        return [
            ['[G]组别'],
            ['组别代码', '组别名称'],
            [$b->g_code, $b->g_codename],
            ['[P]产品'],
            ['BOM代码', '代码', '物料名称', '规格型号', '单位'
                , '数量', '成品率', '版本号', '使用状态', '类型',
                '工艺路线', '审核状态', '备注', '是否特性配置来源', '跳层'],
            [$a->bomcode, $a->b_code, $a->b_materialname, $a->b_space, $a->b_unit,
                $a->b_num, $a->finished, $a->version, $a->usests, $a->usetype,
                $a->craft, $a->reviewsts, $a->remark, $a->isconfigsource, $a->layerjump],
            ['[D]材料'],
            ['代码', '物料名称', '规格型号', '单位', '数量', '损耗率', '位置号', '坯料尺寸', '坯料数', '工位', '工序号', '工序', '是否倒冲', '配置属性', '提前期偏置', '计划百分比', '生效日期', '失效日期', '发料仓位',
                '发料仓库', '子项类型', '备注', '备注1', '备注2', '备注3', '是否有特性'],


        ];
    }

}
