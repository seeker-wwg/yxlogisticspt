<?php

namespace App\Http\Controllers\Admin;
header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问
header("Access-Control-Allow-Method:POST,GET");
use App\Http\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CarController extends Controller
{
    /**
     * 用户列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->isMethod("post")) {

           return  jiami_shousuo($request);
        }
    }

    /**
     * 修改培养信息
     * @param Request $request
     * @param Car $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
         return xiugai($request);
        }
    }

    /**
     * 增加車輛信息
     * @param Request $request
     * @param Car $User
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            return zengjia($request);
        }
    }


    /**
     * 多个选择删除
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        if ($request->isMethod('post')){
         return shanchu($request);
        }
    }


    /**
     * 加司机
     * @param Request $request
     * @return array
     */
    public function add_siji(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data1 = $info[0];
            $token = $info[1];
//            return  [$data1];
            $car_id  = $data1['car_id'];
            $driver_id  = $data1['driver_id'];
            $state =Car::where('car_id',$car_id)->get(['state','driver_id']);
            if(!empty($state[0]->driver_id)){
                return  re_jiami(500,['errorinfo'=>'这辆货车已有司机'],$token);
            }
            if($state[0]->state !== '等待中'){
                return  re_jiami(500,['errorinfo'=>'这辆货车不是空闲状态无法更改'],$token);
            }else{
                $gai =  ['driver_id'=>$driver_id];
                $z = Car::where('car_id',$car_id)->update($gai);

                if ($z) {
                    $shuju = ['errorinfo'=>'增加成功'];
                    return re_jiami(200,$shuju,$token);
                } else {
                    $shuju = ['errorinfo'=>'增加失败'];
                    return re_jiami(500,$shuju,$token);
                }
            }
        }
    }

    /**
     * 取消司机
     * @param Request $request
     * @return array
     */
    public function cancel_siji(Request $request)
    {
        if ($request->isMethod('post')){
            $info = re_jiemi($request);
            $data1 = $info[0];
            $token = $info[1];
            $car_id  = $data1['car_id'];
            $state =Car::where('car_id',$car_id)->get(['state','driver_id']);
            if(empty($state[0]->driver_id)){
                return  re_jiami(500,['errorinfo'=>'这辆货车未分配司机'],$token);
            }
            if($state[0]->state !== '等待中'){
                return  re_jiami(500,['errorinfo'=>'这辆货车不是空闲状态无法更改'],$token);
            }else{
                $gai =  ['driver_id'=>null];
                $z = Car::where('car_id',$car_id)->update($gai);

                if ($z) {
                    $shuju = ['errorinfo'=>'取消成功'];
                    return re_jiami(200,$shuju,$token);
                } else {
                    $shuju = ['errorinfo'=>'取消失败'];
                    return re_jiami(500,$shuju,$token);
                }
            }


        }
    }
    /**
     * import
     * @param Request $request
     * @return array
     */
    public function import(Request $request)
    {
        if ($request->isMethod('post')){
            $datainfo = re_jiemi($request);
            $info = $datainfo[0];
            $token = $datainfo[1];
            $fileName = $info['fileName'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(TRUE);
            $spreadsheet = $reader->load($fileName); //载入excel表格

            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // 总行数
            $highestColumn = $worksheet->getHighestColumn(); // 总列数
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

            $lines = $highestRow - 2;
            if ($lines <= 0) {
                exit('Excel表格中没有数据');
            }

//            $sql = "INSERT INTO `t_student` (`name`, `chinese`, `maths`, `english`) VALUES ";

            for ($row = 3; $row <= $highestRow; ++$row) {
                $car_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); //姓名
                $car_img = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); //语文
                $plate_num = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); //数学
                $engine_num = $worksheet->getCellByColumnAndRow(4, $row)->getValue(); //外语
                $frame_num = $worksheet->getCellByColumnAndRow(5, $row)->getValue(); //外语
                $car_type = $worksheet->getCellByColumnAndRow(6, $row)->getValue(); //外语
                $driver_id = $worksheet->getCellByColumnAndRow(7, $row)->getValue(); //外语
                $license_img = $worksheet->getCellByColumnAndRow(8, $row)->getValue(); //外语
                $state = $worksheet->getCellByColumnAndRow(9, $row)->getValue(); //外语

                $info = [
                   'car_name'=> $car_name,
                   'car_img' =>$car_img,
                   'plate_num'=> $plate_num,
                    'engine_num' => $engine_num,
                    'frame_num' => $frame_num,
                    'car_type' => $car_type,
                    'driver_id' => $driver_id,
                ];
               Car::create($info);
            }
            $shuju = ['errorinfo'=>'增加成功'];
                return re_jiami(200,$shuju,$token);
        }

    }

    /**
     * import
     * @param Request $request
     * @return array
     */
    public function export(Request $request)
    {
        if ($request->isMethod('get')) {
            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();
            //1.设置表头

                //设置工作表标题名称
            $worksheet->setTitle('车辆信息表');

                    //表头
                    //设置单元格内容
            $worksheet->setCellValueByColumnAndRow(1, 1, '车辆信息表');
            $worksheet->setCellValueByColumnAndRow(1, 2, '车辆名称');
            $worksheet->setCellValueByColumnAndRow(2, 2, '车辆照片');
            $worksheet->setCellValueByColumnAndRow(3, 2, '牌照');
            $worksheet->setCellValueByColumnAndRow(4, 2, '发动机号');
            $worksheet->setCellValueByColumnAndRow(5, 2, '车架号');
            $worksheet->setCellValueByColumnAndRow(6, 2, '车辆类型');
            $worksheet->setCellValueByColumnAndRow(7, 2, '车辆所有者');
            $worksheet->setCellValueByColumnAndRow(8, 2, '证照图片');
            $worksheet->setCellValueByColumnAndRow(9, 2, '车辆状态');



            //合并单元格
            $worksheet->mergeCells('A1:I1');

            $styleArray = [
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            //设置单元格样式
            $worksheet->getStyle('A1')->applyFromArray($styleArray)->getFont()->setSize(28);

            $worksheet->getStyle('A2:I2')->applyFromArray($styleArray)->getFont()->setSize(14);

//            2.读取数据
//            $sql = "SELECT id,name,chinese,maths,english FROM `t_student`";
//            $stmt = $db->query($sql);
//            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            $len = count($rows);
            $rows = Car::get()->toArray();

            $len = count($rows);
            $j = 0;
            for ($i=0; $i < $len; $i++) {
                $j = $i + 3; //从表格第3行开始
                $worksheet->setCellValueByColumnAndRow(1, $j, $rows[$i]['car_name']);
                $worksheet->setCellValueByColumnAndRow(2, $j, $rows[$i]['car_img']);
                $worksheet->setCellValueByColumnAndRow(3, $j, $rows[$i]['plate_num']);
                $worksheet->setCellValueByColumnAndRow(4, $j, $rows[$i]['engine_num']);
                $worksheet->setCellValueByColumnAndRow(5, $j, $rows[$i]['frame_num']);
                $worksheet->setCellValueByColumnAndRow(6, $j, $rows[$i]['car_type']);
                $worksheet->setCellValueByColumnAndRow(7, $j, $rows[$i]['driver_id']);
                $worksheet->setCellValueByColumnAndRow(8, $j, $rows[$i]['license_img']);
                $worksheet->setCellValueByColumnAndRow(9, $j, $rows[$i]['state']);
            }

            $styleArrayBody = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '666666'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            $total_rows = $len + 2;
            //添加所有边框/居中
            $worksheet->getStyle('A1:I'.$total_rows)->applyFromArray($styleArrayBody);
            $worksheet->getColumnDimension('A')->setAutoSize(true);
            $worksheet->getColumnDimension('B')->setAutoSize(true);
            $worksheet->getColumnDimension('C')->setAutoSize(true);
            $worksheet->getColumnDimension('D')->setAutoSize(true);
            $worksheet->getColumnDimension('E')->setAutoSize(true);
            $worksheet->getColumnDimension('F')->setAutoSize(true);
            $worksheet->getColumnDimension('G')->setAutoSize(true);
            $worksheet->getColumnDimension('H')->setAutoSize(true);
            $worksheet->getColumnDimension('I')->setAutoSize(true);
            $filename = '车辆信息表.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    }
}
