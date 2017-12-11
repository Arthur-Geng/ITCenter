<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>资产管理</title>
	
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/default/easyui.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/asset.css"/>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.min.js"></script>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/itcenter/Public/easyUI/easyui-lang-zh_CN.js"></script>
</head>

<body class="easyui-layout">
	<div id="north" data-options="region:'north'" style="height:100px;">
		<h1 id="title">固定资产管理系统</h1>
		
	</div>
	<div id="south" data-options="region:'south'" style="height:50px;"></div>
	<div data-options="region:'west'" title="目录" style="width:240px;">
		<ul class="easyui-tree">
			<li>
				<span>固定资产管理</span>
				<ul>
					<li>
						<span>资产管理</span>
						<ul>
							<li><a style="text-decoration:none" href="<?php echo U('Allocation/index');?>">配置列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('Asset/index');?>">资产列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('User/index');?>">人员列表</a></li>
						</ul>
					</li>
					<li>
						<span>资产报表</span>
						<ul>
							<li>配置报表</li>
							<li>资产报表</li>
							<li>人员报表</li>
						</ul>
					</li>
					<li>
						<span><a style="text-decoration:none" href="<?php echo U('Log/index');?>">资产日志</a></span>
					</li>
				</ul>
				
			</li>
			<li>
				<span>系统管理</span>
				<ul>
					<li>
						<span><a style="text-decoration:none">退出</a></span>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div data-options="region:'center'" style="border:0px">
		
	<div class="easyui-panel" title="条件筛选" style="width:100%;padding:15px">
		<form id="ff" method="post">
			<table cellpadding="5">
				<tr>
					<td>资产编号：</td>
					<td>
						<input id="sID" class="easyui-combobox" type="text" name="sID"
							valueField="id" 
							textField="id" 
							url="<?php echo U('Allocation/getIdData');?>">
					</td>
					<td>类型：</td>
					<td>
						<input id="sType" class="easyui-combobox" name="sType"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>1));?>">
					</td>
					<td>品牌：</td>
					<td>
						<input id="sBrand" class="easyui-combobox" name="sBrand"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>2));?>">
					</td>
					<td>型号：</td>
					<td>
						<input id="sModel" class="easyui-textbox" type="text" name="sModel"></input>
					</td>
					<td>序列号：</td>
					<td>
						<input id="sNumber" class="easyui-textbox" type="text" name="sNumber"></input>
					</td>
					
				</tr>
				<tr>
					<td>接入网络：</td>
					<td>
						<input id="sNetWork" class="easyui-combobox" name="sNetWork"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
					<td>使用人：</td>
					<td>
						<input id="sName" class="easyui-combobox" type="text" name="sName"
						valueField="id" 
						textField="name" 
						url="<?php echo U('Allocation/getNameData');?>">
					</td>
					<td>使用部门：</td>
					<td>
						<input id="sDepartment" class="easyui-combobox" name="sDepartment"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>6));?>">
					</td>
					<td>购置日期(S)：</td>
					<td>
						<input id="sPurchaseDateS" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
					<td>购置日期(E)：</td>
					<td>
						<input id="sPurchaseDateE" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
				</tr>
				<tr>
					<td>分配日期(S)：</td>
					<td>
						<input id="sUseDateS" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
					<td>分配日期(E)：</td>
					<td>
						<input id="sUseDateE" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
					<td>资产状态：</td>
					<td>
						<input id="sState" class="easyui-combobox" name="aState"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
					<td>设备来源：</td>
					<td>
						<input id="sSource" class="easyui-combobox" name="sSource"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
					<td></td>
					<td>
						<a href="#" class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doSearch()">搜索</a>
						<a href="#" class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="clearSearch()">清空</a>
						<a href="#" class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doExport()">导出</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<table id="dg" title="配置列表" class="easyui-datagrid"
		url="<?php echo U('Allocation/getAllocatinData');?>" 
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true">
		<thead>
			<tr>
				<th data-options="field:'asset_id',width:'40'">资产编号</th>
				<th data-options="field:'type',width:'40'">类型</th>
				<th data-options="field:'brand',width:'40'">品牌</th>
				<th data-options="field:'model',width:'40'">型号</th>
				<th data-options="field:'number',width:'40'">序列号</th>
				<th data-options="field:'network',width:'40'">接入网络</th>
				<th data-options="field:'state',width:'40'">资产状态</th>
				<th data-options="field:'purchase_date',width:'40'">购置日期</th>
				<th data-options="field:'name',width:'40'">使用人</th>
				<th data-options="field:'department',width:'40'">部门</th>
				<th data-options="field:'office_phone',width:'40'">办公电话</th>
				<th data-options="field:'mobile_phone',width:'40'">移动电话</th>
				<th data-options="field:'use_date',width:'40'">分配日期</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newAllocation()">添加</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAllocation()">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyAllocation()">删除</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:640px;height:540px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<form id="fm" method="post">
			<table cellpadding="5">
				<tr>
					<td>ID号：</td>
					<td>
						<input id="aAssetID" class="easyui-textbox" type="text" name="aAssetID" style="width:200px;" data-options="required:true,missingMessage:'必填'"></input>
					</td>
					<td><a href="#" class="easyui-linkbutton" style="width:66px;height:25px;" onclick="getAssetData()">提取数据</a></td>
					<td></td>
				</tr>
				<tr>
					<td>类型：</td>
					<td>
						<input id="aType" class="easyui-combobox" name="aType" style="width:200px" disabled="disabled"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>1));?>">
					</td>
					<td>品牌：</td>
					<td>
						<input id="aBrand" class="easyui-combobox" name="aBrand" style="width:200px" disabled="disabled"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>2));?>">
					</td>
				</tr>
				<tr>
					<td>型号：</td>
					<td>
						<input id="aModel" class="easyui-textbox" type="text" name="aModel" style="width:200px" disabled="disabled">
					</td>
					
					<td>序列号：</td>
					<td>
						<input id="aNumber" class="easyui-textbox" type="text" name="aNumber" style="width:200px" disabled="disabled"></input>
					</td>
					
				</tr>
				<tr>
					<td>接入网络：</td>
					<td>
						<input id="aNetWork" class="easyui-combobox" name="aNetWork" style="width:200px" disabled="disabled"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
					<td>设备来源：</td>
					<td>
						<input id="aSource" class="easyui-combobox" name="aSource" style="width:200px" disabled="disabled"
						editable="false"  
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
				</tr>
				<tr>
					<td>资产状态：</td>
					<td>
						<input id="aState" class="easyui-combobox" name="aState" style="width:200px" disabled="disabled"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
					<td>购置日期：</td>
					<td>
						<input id="sPurchaseDate" class="easyui-datetimebox" name="sPurchaseDate" data-options="sharedCalendar:'#cc'" editable="false" style="width:200px" disabled="disabled">
					</td>
				</tr>
				<tr>
					<td>使用人：</td>
					<td>
						<input id="aName" class="easyui-combobox" type="text" name="aName" style="width:200px;"
						valueField="id" 
						textField="name" 
						data-options="required:true,missingMessage:'必填'"
						url="<?php echo U('Allocation/getNameData');?>">
					</td>
					<td><a href="#" class="easyui-linkbutton" style="width:66px;height:25px;" onclick="getUserData()">提取数据</a></td>
					<td></td>
				</tr>
				<tr>
					<td>部门：</td>
					<td>
						<input id="aDepartment" class="easyui-combobox" name="aDepartment" style="width:200px" disabled="disabled"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>6));?>">
					</td>
					<td>职务：</td>
					<td>
						<input id="aJob" class="easyui-combobox" name="aJob" style="width:200px" disabled="disabled"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>6));?>">
					</td>
				</tr>
				<tr>
					<td>办公电话：</td>
					<td>
						<input id="aOfficePhone" class="easyui-textbox" type="text" name="aOfficePhone" style="width:200px" disabled="disabled">
					</td>
					<td>移动电话：</td>
					<td>
						<input id="aMobilePhone" class="easyui-textbox" type="text" name="aMobilePhone" style="width:200px" disabled="disabled">
					</td>
				</tr>
				<tr>
					<td>分配日期</td>
					<td>
						<input id="aUseDate" class="easyui-datetimebox" name="aUseDate" data-options="sharedCalendar:'#cc'" editable="false" style="width:200px" required missingMessage="必填">
					</td>
					<td>
						<input id="aOperation" type="hidden" name="aOperation" value="">
						<input id="aUserID" type="hidden" name="aUserID"></input>
						<input id="aID" type="hidden" name="aID"></input>
					</td>
				</tr>
				<tr>
					<td>备注：</td>
					<td colspan="3">
						<input id="aRemark" class="easyui-textbox" name="aRemark" data-options="multiline:true" style="width:490px;height:100px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveAllocation()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	</div>
	
	<div id="dlg1" class="easyui-dialog" style="width:300px;height:150px;padding:30px 20px"
		closed="true" buttons="#dlg1-buttons">
		<a>表格已经生成，请点击下载！</a>
	</div>
	<div id="dlg1-buttons">
		<a href="http://localhost/itcenter/allocation.xlsx" class="easyui-linkbutton" iconCls="icon-ok">下载</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg1').dialog('close')">取消</a>
	</div>
	
	<div id="cc" class="easyui-calendar"></div>
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">    
			<font color="#15428B">努力加载中···</font>    
		</h1>    
	</div> 
	<script>
		$(function(){     
			var curr_time=new Date();     
			var strDate=curr_time.getFullYear()+"-";     
			strDate +=curr_time.getMonth()+1+"-";     
			strDate +=curr_time.getDate()+"-";     
			strDate +=" "+curr_time.getHours()+":";     
			strDate +=curr_time.getMinutes()+":";     
			strDate +=curr_time.getSeconds();     
			$("#aUseDate").datetimebox("setValue",strDate);
		});  
	</script>
	<script>
	function doSearch(){
		$('#dg').datagrid('reload',{
			sID: $('#sID').val(),
			sType: $('#sType').val(),
			sBrand: $('#sBrand').val(),
			sModel: $('#sModel').val(),
			sNumber: $('#sNumber').val(),
			sNetWork: $('#sNetWork').val(),
			sSource: $('#sSource').val(),
			sPurchaseDateS: $('#sPurchaseDateS').val(),
			sPurchaseDateE: $('#sPurchaseDateE').val(),
			sUseDateS: $('#sUseDateS').val(),
			sUseDateE: $('#sUseDateE').val(),
			sName: $('#sName').val(),
			sDepartment: $('#sDepartment').val(),
			sState: $('#sState').val()
		});
	}
	</script>
	<script>
	function clearSearch(){
		$('#ff').form('clear');
		doSearch();
	}
	</script>
	<script>
	function doExport(){
		var conditions = {
			sID: $('#sID').val(),
			sType: $('#sType').val(),
			sBrand: $('#sBrand').val(),
			sModel: $('#sModel').val(),
			sNumber: $('#sNumber').val(),
			sNetWork: $('#sNetWork').val(),
			sSource: $('#sSource').val(),
			sPurchaseDateS: $('#sPurchaseDateS').val(),
			sPurchaseDateE: $('#sPurchaseDateE').val(),
			sUseDateS: $('#sUseDateS').val(),
			sUseDateE: $('#sUseDateE').val(),
			sName: $('#sName').val(),
			sDepartment: $('#sDepartment').val(),
			sState: $('#sState').val()
		};
		
		$.post("/ITCenter/index.php/Home/Allocation/tableExport",conditions,function(result){
			if(result.success) {
				$('#dlg1').dialog('open').dialog('setTitle','下载表格');
			} else {
				$.messager.show({
					title: '错误提示',
					msg: result.errorMsg
				});
			}
		});
	}
	</script>
	<script>
	function getAssetData(){
		var aAssetID = $("#aAssetID").textbox('getValue');
		$.post("/ITCenter/index.php/Home/Allocation/getAssetData",{'id':aAssetID},function(result){
			if(result.success) {
				$('#fm').form('load',{
					aType:result.data['type'],
					aBrand:result.data['brand'],
					aModel:result.data['model'],
					aNumber:result.data['number'],
					aNetWork:result.data['network'],
					aSource:result.data['source'],
					aState:result.data['state'],
					sPurchaseDate:result.data['purchase_date']
				});
			} else {
				$.messager.show({
					title: '错误提示',
					msg: result.errorMsg
				});
			}
		});
	}
	</script>
	<script>
	function getUserData(){
		var aName = $("#aName").combobox('getText');
		$.post("/ITCenter/index.php/Home/Allocation/getUserData",{'name':aName},function(result){
			if(result.success) {
				$('#fm').form('load',{
					aUserID:result.data['id'],
					aDepartment:result.data['department'],
					aJob:result.data['job'],
					aOfficePhone:result.data['office_phone'],
					aMobilePhone:result.data['mobile_phone']
				});
			} else {
				$.messager.show({
					title: '错误提示',
					msg: result.errorMsg
				});
			}
		});
	}
	</script>

	<script>
		function newAllocation(){
			$('#fm').form('clear');
			$('#aOperation').val('add');
			$('#dlg').dialog('open').dialog('setTitle','添加资产配置');
		}
	</script>
	<script>
		function saveAllocation(){
			$.post("/ITCenter/index.php/Home/Allocation/allocationSave",$('#fm').serialize(),function(result){
				if(result.success) {
					$('#dg').datagrid('reload');
					$('#dlg').dialog('close');
					
				} else {
					$.messager.show({
						title: '错误提示',
						msg: result.errorMsg
					});
				}
			});

		}
	</script>
	
	<script>
		function destroyAllocation(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
					if (r){
						$.post('/ITCenter/index.php/Home/Allocation/allocationDestroy',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');
							} else {
								$.messager.show({
									title: '错误提示',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
		}
	</script>
	<script>		
		function editAllocation(){
			var row = $('#dg').datagrid('getSelected');
			$.post("/ITCenter/index.php/Home/Allocation/allocationEdit",row,function(result){
				if(result.success) {
					$('#aOperation').val('edit');
					$('#fm').form('load',{
						aID:result.data['id'],
					    aType:result.data['type'],
					    aBrand:result.data['brand'],
					    aModel:result.data['model'],
					    aNumber:result.data['number'],
						aNetWork:result.data['network'],
						aSource:result.data['source'],
					    aState:result.data['state'],
						sPurchaseDate:result.data['purchase_date'],
						aRemark:result.data['allocation_remark'],
					    aName:result.data['name'],
					    aDepartment:result.data['department'],
					    aJob:result.data['job'],
					    aOfficePhone:result.data['office_phone'],
						aMobilePhone:result.data['mobile_phone'],
						aUseDate:result.data['use_date'],
						aUserID:result.data['user_id'],
						aAssetID:result.data['asset_id']
					});
					$('#dlg').dialog('open').dialog('setTitle','修改资产配置');
				} else {
					$.messager.show({
						title: '错误提示',
						msg: result.errorMsg
					});
				}
			});
		}
	</script>
	<script type="text/javascript">    
		function closeLoading() {    
			$("#loadingDiv").fadeOut("normal", function () {    
				$(this).remove();    
			});    
		}    
		
		var no;    
		$.parser.onComplete = function () {    
			if (no) clearTimeout(no);    
			no = setTimeout(closeLoading, 1000);    
		}            
	</script>

	</div>
</body>
</html>