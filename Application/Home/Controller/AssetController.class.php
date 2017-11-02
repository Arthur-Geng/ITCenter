<?php
namespace Home\Controller;
use Think\Controller;
class AssetController extends Controller {
	public function getAssetData(){

		$option = M('option');
		$optionList = $option->select();
		$optionArray = array();
		foreach($optionList as $index=>$data){
			$optionArray[$data['id']] = $data;
		}

		$asset = M('Asset');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$condition = array();
		if($_POST['sID']){
			$condition['id'] = $_POST['sID'];
		}
		if($_POST['sType']){
			$condition['type'] = $_POST['sType'];
		}
		if($_POST['sBrand']){
			$condition['brand'] = $_POST['sBrand'];
		}
		if($_POST['sModel']){
			$condition['model'] = $_POST['sModel'];
		}
		if($_POST['sNumber']){
			$condition['number'] = $_POST['sNumber'];
		}
		if($_POST['sNetWork']){
			$condition['network'] = $_POST['sNetWork'];
		}
		if($_POST['sSource']){
			$condition['source'] = $_POST['sSource'];
		}
		if($_POST['sState']){
			$condition['state'] = $_POST['sState'];
		}
		if($_POST['sPurchaseDateS']){
			if($_POST['sPurchaseDateE']){
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',$_POST['sPurchaseDateE']));
			}else{
				$condition['purchase_date'] = array(array('gt',$_POST['sPurchaseDateS']),array('lt',date("Y-m-d H:i:s",time())));
			}
		}
		
		$assetList = $asset->where($condition)->order('create_date desc')->page($page.','.$rows)->select();
		$assetArray = array();
		foreach($assetList as $index=>$data){
			$data['type'] = $optionArray[$data['type']]['option_name'];
			$data['brand'] = $optionArray[$data['brand']]['option_name'];
			$data['network'] = $optionArray[$data['network']]['option_name'];
			$data['state'] = $optionArray[$data['state']]['option_name'];
			$data['source'] = $optionArray[$data['source']]['option_name'];
			array_push($assetArray,$data); 
		}
		$assetCount = $asset->where($condition)->count();
		$assetArray = array('total'=>$assetCount,'rows'=>$assetArray);
		$assetArray = json_encode($assetArray);
		$assetArray = json_decode($assetArray);
		$this->ajaxReturn($assetArray);
    }
	
	public function getOptionData($type){
		$option = M("option");
		$condition['type'] = $type;
		$optionList = $option->where($condition)->field('id,option_name')->select();
		$this->ajaxReturn($optionList);
	}
	
	public function assetSave(){
		$asset = M("asset");
		$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		if($_POST['aOperation']=='add'){
			if($_POST['aID']){
				/*记录日志*/
				$logData['asset_id'] = $_POST['aID'];
				$log = M("log");
				$data['type'] = 2;
				$data['text'] = '添加【资产（编号：' . $logData['asset_id'] . '）】';
				$data['create_date'] = date("Y-m-d H:i:s",time());
				$log->add($data);
				/*记录日志*/
			
				$condition['id'] = $_POST['aID'];
				$assetData = $asset->where($condition)->find();
				if($assetData){
					$result = json_encode(array('errorMsg'=>'此ID已经存在，请检查后输入！'));
				}else{
					$assetData['id'] = $_POST['aID'];
					$assetData['type'] = $_POST['aType'];
					$assetData['brand'] = $_POST['aBrand'];
					$assetData['model'] = $_POST['aModel'];
					$assetData['number'] = $_POST['aNumber'];
					$assetData['network'] = $_POST['aNetWork'];
					$assetData['source'] = $_POST['aSource'];
					$assetData['state'] = $_POST['aState'];
					$assetData['purchase_date'] = $_POST['aPurchaseDate'];
					$assetData['remark'] = $_POST['aRemark'];
					$assetData['create_date'] = date("Y-m-d H:i:s",time()); 
					$asset->add($assetData);
					$result = json_encode(array('success'=>true));
				}
			}else{
				$result = json_encode(array('errorMsg'=>'ID号不能为空，请检查后输入！'));
			}
		}elseif($_POST['aOperation']=='edit'){
			/*记录日志*/
			$option = M('option');
			$optionList = $option->select();
			$optionArray = array();
			foreach($optionList as $index=>$optionData){
				$optionArray[$optionData['id']] = $optionData;
			}
			
			$condition['id'] = $_POST['aID'];
			$logData = $asset->where($condition)->find();
			
			$logData['asset_id'] = $_POST['aID'];
			$logData['type'] = $optionArray[$logData['type']]['option_name'];
			$logData['brand'] = $optionArray[$logData['brand']]['option_name'];
			$logData['model'] = $_POST['aModel'];
			$logData['number'] = $_POST['aNumber'];
			$logData['network'] = $optionArray[$logData['network']]['option_name'];
			$logData['source'] = $optionArray[$logData['source']]['option_name'];
			$logData['state'] = $optionArray[$logData['state']]['option_name'];	
			$logData['purchase_date'] = $_POST['aPurchaseDate'];
			
			$log = M("log");
			$data['type'] = 2;
			$data['text'] = '修改【资产（编号：' . $logData['asset_id'] . '）】为【类型：' . $logData['type'] . '；品牌：' . $logData['brand'] . '；型号：' . $logData['model'] . '；序列号：' . $logData['number'] . '；接入网络：' . $logData['network'] . '；设备来源：' . $logData['source'] . '；设备状态：' . $logData['state'] . '；购置时间：' . $logData['purchase_date'] . '】';
			$data['create_date'] = date("Y-m-d H:i:s",time());
			$log->add($data);
			/*记录日志*/
			
			$assetData['id'] = $_POST['aID'];
			$assetData['type'] = $_POST['aType'];
			$assetData['brand'] = $_POST['aBrand'];
			$assetData['model'] = $_POST['aModel'];
			$assetData['number'] = $_POST['aNumber'];
			$assetData['network'] = $_POST['aNetWork'];
			$assetData['source'] = $_POST['aSource'];
			$assetData['state'] = $_POST['aState'];
			$assetData['purchase_date'] = $_POST['aPurchaseDate'];
			$assetData['remark'] = $_POST['aRemark'];
			$assetData['create_date'] = date("Y-m-d H:i:s",time()); 
			$asset->save($assetData);
			$result = json_encode(array('success'=>true));
		}else{
			$result = json_encode(array('errorMsg'=>'数据存在问题，请检查后输入！'));
		}
		$result = json_decode($result);
		$this->ajaxReturn($result);
    }
	
	public function assetEdit(){
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
	
	public function assetDestroy(){
		/*记录日志*/
		$logData['asset_id'] = $_POST['id'];
		$log = M("log");
		$data['type'] = 2;
		$data['text'] = '删除【资产（编号：' . $logData['asset_id'] . '）】';
		$data['create_date'] = date("Y-m-d H:i:s",time());
		$log->add($data);
		/*记录日志*/
		
		$asset = M("Asset");
		$condition['id'] = $_POST['id'];
		
		$asset->where($condition)->delete();

		$result = json_encode(array('success'=>true));
		$result = json_decode($result);
		$this->ajaxReturn($result);
	}
}