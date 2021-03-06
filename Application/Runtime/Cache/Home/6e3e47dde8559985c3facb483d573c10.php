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
	<script type="text/javascript" src="/itcenter/Public/common.js"></script>
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
						<span><a style="text-decoration:none" href="<?php echo U('Log/index');?>">操作日志</a></span>
					</li>
				</ul>
				
			</li>
			<li>
				<span>系统管理</span>
				<ul>
					<li>
						<span><a style="text-decoration:none" href="<?php echo U('Index/logout');?>">退出</a></span>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div data-options="region:'center'" style="border:0px">
		
	<script type="text/javascript" src="/itcenter/Public/asset.js"></script>
	<div class="easyui-panel" title="条件筛选" style="width:100%;padding:15px">
		<form id="sForm" method="post">
			<table cellpadding="5">
				<tr>
					<td>资产编号：</td>
					<td>
						<input id="sID" class="easyui-combobox" type="text" name="sID"
							valueField="id" 
							textField="id" 
							url="<?php echo U('Asset/getAssetIdList');?>">
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
					<td>序列号：</td>
					<td>
						<input id="sNumber" class="easyui-textbox" type="text" name="sNumber"></input>
					</td>
					<td>接入网络：</td>
					<td>
						<input id="sNetWork" class="easyui-combobox" name="sNetWork"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
					
				</tr>
				<tr>
					<td>设备来源：</td>
					<td>
						<input id="sSource" class="easyui-combobox" name="sSource"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
					<td>资产状态：</td>
					<td>
						<input id="sState" class="easyui-combobox" name="sState"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
					<td>购置日期(S)：</td>
					<td>
						<input id="sPurchaseDateS" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#calendar'">
					</td>
					<td>购置日期(E)：</td>
					<td>
						<input id="sPurchaseDateE" class="easyui-datetimebox" editable="false" data-options="sharedCalendar:'#calendar'">
					</td>
					<td></td>
					<td>
						<div>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doSearch()">搜索</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="clearSearch()">清空</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doImport()">导入</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doExport()">导出</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<table id="cDatagrid" title="资产列表" class="easyui-datagrid"
		url="<?php echo U('Asset/getAssetListData');?>" 
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true"
		pageSize="20"
		pagination="true">
		<thead>
			<tr>
				<th data-options="field:'id',width:'80',sortable:'true'">资产编号</th>
				<th data-options="field:'type',width:'80'">类型</th>
				<th data-options="field:'brand',width:'80'">品牌</th>
				<th data-options="field:'model',width:'80'">型号</th>
				<th data-options="field:'number',width:'80'">序列号</th>
				<th data-options="field:'network',width:'80'">接入网络</th>
				<th data-options="field:'source',width:'80'">设备来源</th>
				<th data-options="field:'state',width:'80'">资产状态</th>
				<th data-options="field:'purchase_date',width:'80',sortable:'true'">购置日期</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newAsset()">添加</a>
		<a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAsset()">修改</a>
		<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyAsset()">删除</a>
	</div>
	
	<!-- 添加对话框 -->
	<div id="dialog1" class="easyui-dialog" style="width:640px;height:390px;padding:10px 20px" closed="true" buttons="#dialog1-buttons">
		<form id="aForm" method="post">
			<table cellpadding="5">
				<tr>
					<td>ID号：</td>
					<td>
						<input id="aID" class="easyui-textbox" type="text" name="aID" style="width:200px;" data-options="required:true,missingMessage:'必填'"></input>
					</td>
					<td>类型：</td>
					<td>
						<input id="aType" class="easyui-combobox" name="aType" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>1));?>"
						data-options="required:true,missingMessage:'必填'">
					</td>
				
				</tr>
				<tr>
					<td>品牌：</td>
					<td>
						<input id="aBrand" class="easyui-combobox" name="aBrand" style="width:200px"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>2));?>">
					</td>
					<td>型号：</td>
					<td>
						<input id="aModel" class="easyui-textbox" type="text" name="aModel" style="width:200px"></input>
					</td>
					
				</tr>
				<tr>
					<td>序列号：</td>
					<td>
						<input id="aNumber" class="easyui-textbox" type="text" name="aNumber" style="width:200px"></input>
					</td>
					<td>接入网络：</td>
					<td>
						<input id="aNetWork" class="easyui-combobox" name="aNetWork" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
				</tr>
				<tr>
					<td>设备来源：</td>
					<td>
						<input id="aSource" class="easyui-combobox" name="aSource" style="width:200px"
						editable="false"  
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
					<td>资产状态：</td>
					<td>
						<input id="aState" class="easyui-combobox" name="aState" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
				</tr>
				<tr>
					<td>购置日期：</td>
					<td>
						<input id="aPurchaseDate" class="easyui-datetimebox" name="aPurchaseDate" style="width:200px"  editable="false" data-options="sharedCalendar:'#calendar',required:true,missingMessage:'必填'">
					</td>
					<td>
						<input id="aOperation" type="hidden" name="aOperation" value="">
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
	<div id="dialog1-buttons">
		<a class="easyui-linkbutton" iconCls="icon-ok" onclick="saveAsset()">保存</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog1').dialog('close')">取消</a>
	</div>
	
	<!-- 导出对话框 -->
	<div id="dialog2" class="easyui-dialog" style="width:300px;height:150px;padding:30px 20px" closed="true" buttons="#dialog2-buttons">
		<a>表格已经生成，请点击下载！</a>
	</div>
	<div id="dialog2-buttons">
		<a id="downLoadButton" class="easyui-linkbutton" iconCls="icon-ok">下载</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog2').dialog('close')">取消</a>
	</div>
	
	<!-- 导入对话框 -->
	<div id="dialog3" class="easyui-dialog" style="width:315px;height:148px;padding:25px 60px" closed="true" buttons="#dialog3-buttons">
		<form id="iForm" method="post"  enctype="multipart/form-data">
			<input id="assetExcel" class="easyui-filebox" name="assetExcel" data-options="buttonText:'浏览',prompt:'请选择xlsx文件'"/>
		</form>
	</div>
	<div id="dialog3-buttons">
		<a class="easyui-linkbutton" iconCls="icon-ok" onclick="tableImport()">导入</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog3').dialog('close')">取消</a>
	</div>
	
	<div id="calendar" class="easyui-calendar"></div>
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">努力加载中···</h1>    
	</div>

	</div>
</body>
</html>