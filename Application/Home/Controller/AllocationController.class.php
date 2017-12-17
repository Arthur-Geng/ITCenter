<?php
namespace Home\Controller;
use Think\Controller;
class AllocationController extends CommonController {
	public function index(){
        $this->redirect('Asset/allocation');
    }
	
	public function getAllocatinData(){
		$option = D('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$allocation = D('AllocationView');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$condition = array();
		if($_POST['sID']){
			$condition['asset_id'] = $_POST['sID'];
		}
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sBrand']){
			$condition['name'] = $_POST['sBrand'];
		}
		if($_POST['sModel']){
			$condition['name'] = $_POST['sModel'];
		}
		if($_POST['sNumber']){
			$condition['name'] = $_POST['sNumber'];
		}
		if($_POST['sNetWork']){
			$condition['name'] = $_POST['sNetWork'];
		}
		if($_POST['sSource']){
			$condition['name'] = $_POST['sSource'];
			
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sUseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',$_POST['sUseDateE']));
			}else{
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sName']){
			$condition['name'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		
		$allocationList = $allocation->where($condition)->order('allocation_create_date desc')->page($page.','.$rows)->select();
		$allocationArray = array();
		foreach($allocationList as $index=>$data){
			$data['type'] = $optionArray[$data['type']]['option_name'];
			$data['brand'] = $optionArray[$data['brand']]['option_name'];
			$data['network'] = $optionArray[$data['network']]['option_name'];
			$data['source'] = $optionArray[$data['source']]['option_name'];
			$data['state'] = $optionArray[$data['state']]['option_name'];
			$data['department'] = $optionArray[$data['department']]['option_name'];
			$data['job'] = $optionArray[$data['job']]['option_name'];
			array_push($allocationArray,$data); 
		}
		
		$allocationArray = json_encode($allocationArray);
		$allocationArray = json_decode($allocationArray);
		$this->ajaxReturn($allocationArray);
    }
	
	public function getOptionData($type){
		$option = M("option");
		$condition['type'] = $type;
		$optionList = $option->where($condition)->field('id,option_name')->select();
		$this->ajaxReturn($optionList);
	}
	
	public function getIdData(){
		$asset = M("asset");
		$idList = $asset->field('id')->select();
		$this->ajaxReturn($idList);
	}
	
	public function getNameData(){
		$user = M("user");
		$nameList = $user->field('id,name')->select();
		$this->ajaxReturn($nameList);
	}
	
	public function getAssetData(){
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		$assetData = $asset->where($condition)->find();
		if($assetData){
			$result = json_encode(array('success'=>true,'data'=>$assetData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function getUserData(){
		$user = M("User");
		$condition['name'] = $_POST['name'];
		$userData = $user->where($condition)->find();
		if($userData){
			$result = json_encode(array('success'=>true,'data'=>$userData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function allocationEdit(){
		$allocation = D("AllocationView");
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		if($allocationData){
			$result = json_encode(array('success'=>true,'data'=>$allocationData));
		}else{
			$result = json_encode(array('errorMsg'=>'数据不存在！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function allocationDestroy(){
		/*记录日志*/
		$allocation = D('AllocationView');
		$condition['id'] = $_POST['id'];
		$allocationData = $allocation->where($condition)->find();
		$logData['user_name'] = $allocationData['name'];
		$logData['asset_id'] = $allocationData['asset_id'];
		$log = M("log");
		$data['type'] = 1;
		$data['text'] = '删除【（' . $logData['user_name'] . '）占用资产（编号：' . $logData['asset_id'] . '）】';
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log->add($data);
		/*记录日志*/
		
		$allocation = M("allocation");
		$condition['id'] = $_POST['id'];
		$allocation->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function allocationSave(){
		$allocation = M("allocation");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		
		
			
		if($_POST['aOperation']=='add'){	
			$condition1['asset_id'] = $_POST['aAssetID'];
			$isAllocation = $allocation->where($condition1)->find();
			if($isAllocation){
				$result = json_encode(array('errorMsg'=>'该设备已被分配，请检查后输入！'));
			}else{
				/*记录日志*/
				$user = M("user");
				$condition['id'] = $_POST['aUserID'];
				$userData = $user->where($condition)->find();
				$logData['user_name'] = $userData['name'];
				$logData['asset_id'] = $_POST['aAssetID'];
				
				$log = M("log");
				$data['type'] = 1;
				$data['text'] = '添加【（' . $logData['user_name'] . '）占用资产（编号：' . $logData['asset_id'] . '）】';
				$data['create_date'] = date("Y-m-d H:i:s",time());
				$log->add($data);
				/*记录日志*/
				
				$allocationData['asset_id'] = $_POST['aAssetID'];
				$allocationData['user_id'] = $_POST['aUserID'];
				$allocationData['use_date'] = $_POST['aUseDate'];
				$allocationData['remark'] = $_POST['aRemark'];
				$allocationData['create_date'] = date("Y-m-d H:i:s",time()); 
				$allocation->add($allocationData);
				
				$result = json_encode(array('success'=>true,'data'=>$allocationData));
			}
		}elseif($_POST['aOperation']=='edit'){
			/*记录日志*/
			$allocation = D('AllocationView');
			$condition['id'] = $_POST['aID'];
			$allocationData = $allocation->where($condition)->find();
			$logData['user_name1'] = $allocationData['name'];
			$logData['asset_id1'] = $allocationData['asset_id'];
			$user = M("user");
			$condition['id'] = $_POST['aUserID'];
			$userData = $user->where($condition)->find();
			$logData['user_name2'] = $userData['name'];
			$logData['asset_id2'] = $_POST['aAssetID'];
			
			$log = M("log");
			$data['type'] = 1;
			$data['text'] = '修改【（' . $logData['user_name1'] . '）占用资产（编号：' . $logData['asset_id1'] . '）】为【（' . $logData['user_name2'] . '）占用资产（编号：' . $logData['asset_id2'] . '）】';
			$data['create_date'] = date("Y-m-d H:i:s",time());
			$log->add($data);
			/*记录日志*/

			$allocation = M('Allocation');
			$allocationData['id'] = $_POST['aID'];
			$allocationData['asset_id'] = $_POST['aAssetID'];
			$allocationData['user_id'] = $_POST['aUserID'];
			$allocationData['use_date'] = $_POST['aUseDate'];
			$allocationData['remark'] = $_POST['aRemark'];
			$allocationData['create_date'] = date("Y-m-d H:i:s",time());
			$allocation->save($allocationData);

			$result = json_encode(array('success'=>true));
		}else{
			$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function tableExport(){
		$option = D('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$allocation = D('AllocationView');

		$condition = array();
		if($_POST['sID']){
			$condition['asset_id'] = $_POST['sID'];
		}
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sBrand']){
			$condition['name'] = $_POST['sBrand'];
		}
		if($_POST['sModel']){
			$condition['name'] = $_POST['sModel'];
		}
		if($_POST['sNumber']){
			$condition['name'] = $_POST['sNumber'];
		}
		if($_POST['sNetWork']){
			$condition['name'] = $_POST['sNetWork'];
		}
		if($_POST['sSource']){
			$condition['name'] = $_POST['sSource'];
			
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sUseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',$_POST['sUseDateE']));
			}else{
				$condition['use_date'] = array(array('gt',$_POST['sUseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		if($_POST['sName']){
			$condition['name'] = $_POST['sName'];
		}
		if($_POST['sDepartment']){
			$condition['department'] = $_POST['sDepartment'];
		}
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		
		$allocationList = $allocation->where($condition)->order('allocation_create_date desc')->select();
		
		import("Org.Util.PHPExcel");
		
		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '资产编号')
					->setCellValue('B1', '类型')
					->setCellValue('C1', '品牌')
					->setCellValue('D1', '型号')
					->setCellValue('E1', '序列号')
					->setCellValue('F1', '接入网络')
					->setCellValue('G1', '设备来源')
					->setCellValue('H1', '资产状态')
					->setCellValue('I1', '购置日期')
					->setCellValue('J1', '资产备注')
					->setCellValue('K1', '使用人')
					->setCellValue('L1', '部门')
					->setCellValue('M1', '职务')
					->setCellValue('N1', '办公电话')
					->setCellValue('O1', '移动电话')
					->setCellValue('P1', '分配日期')
					->setCellValue('Q1', '分配备注');
		
		$index = 2;
		foreach($allocationList as $key=>$data){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$index, $data['asset_id'])
					->setCellValue('B'.$index, $optionArray[$data['type']]['option_name'])
					->setCellValue('C'.$index, $optionArray[$data['brand']]['option_name'])
					->setCellValue('D'.$index, $data['model'])
					->setCellValue('E'.$index, $data['number'])
					->setCellValue('F'.$index, $optionArray[$data['network']]['option_name'])
					->setCellValue('G'.$index, $optionArray[$data['source']]['option_name'])
					->setCellValue('H'.$index, $optionArray[$data['state']]['option_name'])
					->setCellValue('I'.$index, $data['purchase_date'])
					->setCellValue('J'.$index, $data['asset_remark'])
					->setCellValue('K'.$index, $data['name'])
					->setCellValue('L'.$index, $optionArray[$data['department']]['option_name'])
					->setCellValue('M'.$index, $optionArray[$data['job']]['option_name'])
					->setCellValue('N'.$index, $data['office_phone'])
					->setCellValue('O'.$index, $data['mobile_phone'])
					->setCellValue('P'.$index, $data['use_date'])
					->setCellValue('Q'.$index, $data['allocation_remark']);
			$index++;
		}

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('配置列表');

		import("Org.Util.PHPExcel.IOFactory");
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save('allocation.xlsx');
		
		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
	
	public function tableImport(){
 		if (!empty($_FILES['allocationExcel']['name'])){
			$tmp_file = $_FILES['allocationExcel']['tmp_name'];
			$file_types = explode ( ".", $_FILES['allocationExcel']['name'] );
			$file_type = $file_types[count ($file_types)-1];
			/*判别是不是.xlsx文件，判别是不是excel文件*/
			if (strtolower($file_type )!= "xlsx"){
				exit('error_fileType');
			}
			
			$savePath = './Public/Upfile/';
			$str = date('Ymdhis');
			$file_name = $str.".".$file_type;
			if (!copy( $tmp_file, $savePath . $file_name )){
				exit('error_fileUpload');
			}
			import("Org.Util.PHPExcel");
			import("Org.Util.PHPExcel.IOFactory");
			$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($savePath.$file_name);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			import("Org.Util.PHPExcel.Cell");
			$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
			$excelData = array();
			
			$option = M('option');
			$optionList = $option->select();
			$optionArray = array();
			foreach($optionList as $k=>$v){
				$optionArray[$v['option_name']] = $v;
			}
			
			for ($row = 2; $row <= $highestRow; $row++) {
				for ($col = 0; $col < $highestColumnIndex; $col++) {
					$value = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					if($col==1 || $col==2 || $col==5 || $col==6 || $col==7 || $col==11 || $col==12){
						$excelData[$row][$col] = $optionArray[$value]['id'];
					}else{
						$excelData[$row][$col] = $value;
					}
				} 
			}
			
			$dataNum = 0;
			foreach($excelData as $k => $v ){
				$condition1['asset_id'] = $v[0];
				$allocationData = M("allocation")->where($condition1)->find();
				if($allocationData){
					continue;
				}
				
				$condition2['id'] = $v[0];
				$assetData = M("asset")->where($condition2)->find();
				if(!$assetData){
					$data2['id'] = $v[0];
					$data2['type'] = $v[1];
					$data2['brand'] = $v[2];
					$data2['model'] = $v[3];
					$data2['number'] = $v[4];
					$data2['network'] = $v[5];
					$data2['source'] = $v[6];
					$data2['purchase_date'] = $v[8];
					$data2['remark'] = $v[9];
					$data2['state'] = $v[7];
					$data2['create_date'] = date("Y-m-d H:i:s",time()); 
					M("asset")->add($data2);
				}
				 
				$condition3['name'] = $v[10];
				$userData = M("user")->where($condition3)->find();
				if(!$userData){
					$data3['name'] = $v[10];
					$data3['department'] = $v[11];
					$data3['job'] = $v[12];
					$data3['office_phone'] = $v[13];
					$data3['mobile_phone'] = $v[14];
					$data3['create_date'] = date("Y-m-d H:i:s",time()); 
					$userId = M("user")->add($data3);
				}else{
					$userId = $userData['id'];
				}

				$data1['asset_id'] = $v[0];
				$data1['user_id'] = $userId;
				$data1['use_date'] = $v[15];
				$data1['remark'] = $v[16];
				$data1['create_date'] = date("Y-m-d H:i:s",time()); 
				M("allocation")->add($data1);
				
				$dataNum++;
			}
			$this->ajaxReturn($dataNum);
		}else{
			exit('error_fileEmpty');
		}
	}
}