<?php


namespace common\utils;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


/**
 * Class ExcelUtil
 * @package common\utils
 *
 * @author 木易程序猿 <380373940@qq.com> 2019/7/25
 */
class ExcelUtil
{
    /**
     * 导出Execl
     * @param $title
     * @param $rows
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportExcel($title, $rows, $map)
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet()->setTitle($title);//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = false;
        $row_index = 2;
        foreach ($rows as $row) {
            $col_index = 1;
            foreach ($map as $key => $titleValue) {
                $col_letter = $this->getLetter($col_index);
                if (!$header) {
                    $objActSheet->setCellValue("{$col_letter}1", "{$titleValue}");
                }
                if (isset($row[$key])) {
                    $value = $row[$key];
                    if ($value !== false) {
                        $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $value === null ? "" : "{$value}", DataType::TYPE_STRING);
                        $col_index++;
                    }
                }
            }
            $row_index++;
            $header = true;
        }
        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);
    }

    /**
     * 导出Execl
     * @param $title
     * @param $rows
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportExcelFormat($title, $rows, $map)
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet()->setTitle($title);//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = false;
        $row_index = 2;
        foreach ($rows as $row) {
            $col_index = 1;
            foreach ($map as $key => $config) {
                $col_letter = $this->getLetter($col_index);
                if (!$header) {
                    $objActSheet->setCellValue("{$col_letter}1", "{$config["title"]}");
                }
                if (isset($row[$key])) {
                    $value = $row[$key];
                    if ($value !== false) {
                        $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}",
                            $value === null ? "" : "{$value}",
                            $config["type"] ?? DataType::TYPE_STRING);
                        $col_index++;
                    }
                }
            }
            $row_index++;
            $header = true;
        }
        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);
    }

    /**
     * 订单导出Execl(合并单元格)
     * @param $title
     * @param $rows
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportOrderListExcel($title, $rows, $map)
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet();;//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = false;
        $row_index = 2;
        foreach ($rows as $row) {
            $col_index = 1;
            $count = 0;
            foreach ($row as $key => $value) {

                if ($key == 'orderRepairCount') {
                    $count = $value;
                }

                if (key_exists($key, $map)) {
                    if ($key != 'orderRepairCount') {
                        //if (!in_array($key,[ 'orderRepairCount','repairState','sn','refundCreation','refundGoldfish','refundMoney'])){
                        $col_letter = $this->getLetter($col_index);
                        if (!$header) {
                            $objActSheet->setCellValue("{$col_letter}1", "{$map[$key]}");

                        }
                        if ($value !== false) {
                            if ($key != 'orderRepairCount') {
                                $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $value === null ? "" : "{$value}", DataType::TYPE_STRING);
                            }
                        }
                        $col_index++;
                        if ($count > 1 && !in_array($key, ['orderRepairCount', 'repairState', 'sn', 'refundCreation', 'refundGoldfish', 'refundMoney'])) {
                            for ($i = 1; $i < $count; $i++) {
                                $row_index_in = $row_index + 1;
                                $objActSheet->mergeCells("{$col_letter}{$row_index}" . ':' . "{$col_letter}{$row_index_in}");
                            }
                        }
                    }


                } else if ($key == 'orderRepair') {
                    if ($value['orderRepairCount'] > 0) {
                        foreach ($value['orderRepair'] as $orderRepairValue) {
                            $col_sub_index = $col_index;
                            foreach ($orderRepairValue as $keys => $v) {
                                if (key_exists($keys, $map)) {
                                    $col_letter_more = $this->getLetter($col_sub_index);
                                    $objActSheet->setCellValueExplicit("{$col_letter_more}{$row_index}", $v === null ? "" : "{$v}", DataType::TYPE_STRING);
                                    $col_sub_index++;
                                }
                            }
                            $row_index++;
                        }
                        $row_index--;
                    }
                }


            }
            $row_index++;
            $header = true;
        }

        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);
    }

    /**
     * 导出Execl多个sheet
     * @param $title
     * @param $sheets
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportMutilSheetExcel($title, $sheets, $map)
    {
        $spreadsheet = new Spreadsheet();
        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = false;
        $mobile = null;
        foreach ($sheets as $sheettitle => $rows) {
            $row_index = 2;
            $objActSheet = $spreadsheet->createSheet();
            $objActSheet->setTitle($sheettitle . '');
            foreach ($rows['list'] as $row) {
                $col_index = 1;
                foreach ($row as $key => $value) {
                    if (key_exists($key, $map)) {
                        $col_letter = $this->getLetter($col_index);
                        if (!$header) {
                            $objActSheet->setCellValue("{$col_letter}1", "{$map[$key]}");
                        }
                        $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $value === null ? "" : "{$value}", DataType::TYPE_STRING);
                        $col_index++;
                    }

                }
                $row_index++;
            }
            $objActSheet->getPageSetup()->setHorizontalCentered(true);
            $objActSheet->getPageSetup()->setVerticalCentered(false);
        }
        $sheetIndex = $spreadsheet->getIndex($spreadsheet->getSheetByName('Worksheet'));
        $spreadsheet->removeSheetByIndex($sheetIndex);

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);
    }

    /**
     * 导出分组导出Execl
     * @param $title
     * @param $groups
     * @param $groupKey
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportGroupExcel($title, $groups, $groupKey, $map)
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet()->setTitle($title);//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = true;
        $row_index = 2;
        foreach ($groups as $groupName => $rows) {
            // 设置合并部分
            if (key_exists($groupKey, $map)) {
                $col_index = 1;
                $col_letter = $this->getLetter($col_index);
                if ($header) {
                    $objActSheet->setCellValue("{$col_letter}1", "{$map[$groupKey]}");
                }
                $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $groupName, DataType::TYPE_STRING);
                $count = count($rows);
                if ($count > 1) {
                    $row_index_end = $row_index + $count - 1;
                    $objActSheet->mergeCells("{$col_letter}{$row_index}" . ':' . "{$col_letter}{$row_index_end}");
                }
            }

            foreach ($rows as $row) {
                $col_index = 2;
                foreach ($map as $key => $title) {
                    $col_letter = $this->getLetter($col_index);
                    if ($header) {
                        $objActSheet->setCellValue("{$col_letter}1", "{$title}");
                    }
                    if (isset($row[$key])) {
                        $value = $row[$key];
                        if ($value !== false) {
                            $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $value === null ? "" : "{$value}", DataType::TYPE_STRING);
                            $col_index++;
                        }
                    }
                    if($key=='paymentTotal'){
                        $row_index_end = $row_index + $count - 1;
                        $objActSheet->mergeCells("{$col_letter}{$row_index}" . ':' . "{$col_letter}{$row_index_end}");

                    }
                }
                $row_index++;
                $header = false;
            }
        }
        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);

        // ob_end_clean();
        //ob_start();

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);

    }

    /**
     * 导出分组导出Execl
     * @param $title
     * @param $groups
     * @param $groupKey
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportGroupExcelFormat($title, $groups, $groupKey, $map)
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet()->setTitle($title);//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = true;
        $row_index = 2;
        foreach ($groups as $groupName => $rows) {
            // 设置合并部分
            if (key_exists($groupKey, $map)) {
                $col_index = 1;
                $col_letter = $this->getLetter($col_index);
                if ($header) {
                    $objActSheet->setCellValue("{$col_letter}1", "{$map[$groupKey]["title"]}");
                }
                $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $groupName,
                    DataType::TYPE_STRING);
                $count = count($rows);
                if ($count > 1) {
                    $row_index_end = $row_index + $count - 1;
                    $objActSheet->mergeCells("{$col_letter}{$row_index}" . ':' . "{$col_letter}{$row_index_end}");
                }
            }
            foreach ($rows as $row) {
                $col_index = 2;
                foreach ($map as $key => $config) {
                    $col_letter = $this->getLetter($col_index);
                    if ($header) {
                        $objActSheet->setCellValue("{$col_letter}1", "{$config["title"]}");
                    }
                    if (isset($row[$key])) {
                        $value = $row[$key];
                        if ($value !== false) {
                            $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}",
                                $value === null ? "" : "{$value}", $config["dataType"] ?? DataType::TYPE_STRING);
                            $col_index++;
                        }
                    }
                }
                $row_index++;
                $header = false;
            }
        }
        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);

        // ob_end_clean();
        //ob_start();

        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);

    }

    /**
     * 设置Execl响应
     * @param $title
     * @param $spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    protected function asExecl($title, $spreadsheet)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        header('Pragma:public');
        header('Expires:0');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header('Content-Transfer-Encoding:binary');
        $date = date("YmdHis");
        header("Content-Disposition:attachment;filename=\"{$title}-{$date}.xls\"");
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');
        //ob_end_flush();
        exit;
    }

    /**
     * 根据数字获取字母
     * @param $i
     * @return mixed|string
     *
     */
    protected function getLetter($i)
    {
        $letters = ["A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N",
            "O", "P", "Q", "R", "S", "T",
            "U", "V", "W", "X", "Y", "Z",];
        if ($i <= 26) {
            return $letters[$i - 1];
        } else {
            $num = intval(($i - 1) / 26);
            $letter = $letters[$num - 1];
            $i -= $num * 26;
            return $letter . $letters[$i - 1];
        }
    }

    /**
     * 订单导出Execl(合并单元格)
     * @param $title
     * @param $rows
     * @param $map
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     */
    function exportNeedCellExcel($title, $rows, $map, $countKey = 'skuRepairCount', $cellKey = 'skuRepairDetail', $cellArr = [])
    {
        $spreadsheet = new Spreadsheet();
        //设置属性 - 标题
        $spreadsheet->getProperties()
            ->setTitle($title)
            ->setSubject($title);
        $objActSheet = $spreadsheet->getActiveSheet();;//获取活动工作表对象

        /**
         * 设置每个列的值一列为A  一行为1 则 第一行第一列为A1
         * 以此类推,如果列不固定就用内置函数把数字转换成字母; $col是列 $row是行 $value是值.
         */
        // 表头
        $header = false;
        $row_index = 2;
        foreach ($rows as $row) {
            $col_index = 1;
            $count = 0;
            foreach ($row as $key => $value) {

                if ($key == $countKey) {
                    $count = $value;
                }

                if (key_exists($key, $map)) {
                    if ($key != $countKey) {
                        //if (!in_array($key,[ 'orderRepairCount','repairState','sn','refundCreation','refundGoldfish','refundMoney'])){
                        $col_letter = $this->getLetter($col_index);
                        if (!$header) {
                            $objActSheet->setCellValue("{$col_letter}1", "{$map[$key]}");

                        }
                        if ($value !== false) {
                            if ($key != 'orderRepairCount') {
                                $objActSheet->setCellValueExplicit("{$col_letter}{$row_index}", $value === null ? "" : "{$value}", DataType::TYPE_STRING);
                            }
                        }
                        $col_index++;
                        if ($count > 1 && !in_array($key, $cellArr)) {
                            for ($i = 1; $i < $count; $i++) {
                                $row_index_in = $row_index + 1;
                                $objActSheet->mergeCells("{$col_letter}{$row_index}" . ':' . "{$col_letter}{$row_index_in}");
                            }
                        }
                    }


                } else if ($key == $cellKey) {
                    if ($value[$countKey] > 0) {
                        foreach ($value[$cellKey] as $orderRepairValue) {
                            $col_sub_index = $col_index;
                            foreach ($orderRepairValue as $keys => $v) {
                                if (key_exists($keys, $map)) {
                                    $col_letter_more = $this->getLetter($col_sub_index);
                                    $objActSheet->setCellValueExplicit("{$col_letter_more}{$row_index}", $v === null ? "" : "{$v}", DataType::TYPE_STRING);
                                    $col_sub_index++;
                                }
                            }
                            $row_index++;
                        }
                        $row_index--;
                    }
                }


            }
            $row_index++;
            $header = true;
        }

        $objActSheet->getPageSetup()->setHorizontalCentered(true)->setVerticalCentered(false);
        // 设置Execl响应
        $this->asExecl($title, $spreadsheet);
    }


}