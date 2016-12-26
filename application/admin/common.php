<?php
/**
 *
 * 模块公共（函数）文件
 *
 * @package   NiPHPCMS
 * @category  admin\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */

/**
 * 自定义字段类型转换
 * @param  array $data
 * @return string
 */
function toFieldsType($data)
{
	switch ($data['field_type']) {
		case 'number':
		case 'email':
		case 'phone':
			$input = '<input type="' . $data['field_type'] . '"';
			$input .= ' name="fields[' . $data['id'] . ']"';
			$input .= ' id="fields-' . $data['id'] . '"';
			$input .= ' value="' . $data['field_data'] . '"';
			$input .= ' class="form-control">';
			break;

		case 'url':
		case 'currency':
		case 'abc':
		case 'idcards':
		case 'landline':
		case 'age':
			$input = '<input type="text"';
			$input .= ' name="fields[' . $data['id'] . ']"';
			$input .= ' id="fields-' . $data['id'] . '"';
			$input .= ' value="' . $data['field_data'] . '"';
			$input .= ' class="form-control">';
			break;

		case 'date':
			$input = '<input type="text"';
			$input .= ' name="fields[' . $data['id'] . ']"';
			$input .= ' id="fields-' . $data['id'] . '"';
			$input .= ' value="' . date('Y-m-d', $data['field_data']) . '"';
			$input .= ' class="form-control">';

			$input .= '<script type="text/javascript">
				$(function () {
					$("#fields-' . $data['id'] . '").datetimepicker(
						{format: "Y-M-D"}
						);
				});
				</script>';
			break;

		case 'text':
			$input = '<textarea name="fields[' . $data['id'] . ']"';
			$input .= ' id="fields-' . $data['id'] . '"';
			$input .= ' class="form-control">';
			$input .= $data['field_data'];
			$input .= '</textarea>';
			break;
	}

	return $input;
}

/**
 * 上传文件返回js代码
 * @param  array  $update_file 上传返回文件地址等数据
 * @return string
 */
function upload_to_javasecipt($update_file)
{
	$request = \think\Request::instance();

	$domain = $request->root(true);
	$domain_arr = explode('/', $domain);
	array_pop($domain_arr);
	$domain = implode('/', $domain_arr);

	if ($request->param('type') == 'ckeditor') {
		// 编辑器
		$ckefn = $request->param('CKEditorFuncNum');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'window.parent.CKEDITOR.tools.callFunction(';
		$javascript .= $ckefn . ',\'' . $update_file['file_name'] . '\',';
		$javascript .= '\'' . \think\Lang::get('success upload') . '\'';
		$javascript .= ');';
		$javascript .= '</script>';
	} elseif ($request->param('type') == 'album') {
		// 相册
		$id = $request->post('id');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'opener.document.getElementById("album-image-' . $id . '").value="' . $update_file['file_name'] . '";';
		$javascript .= 'opener.document.getElementById("album-thumb-' . $id . '").value="' . $update_file['file_thumb_name'] . '";';
		$javascript .= 'opener.document.getElementById("img-album-' . $id . '").style.display="";';
		$javascript .= 'opener.document.getElementById("img-album-' . $id . '").src="' . $domain . $update_file['file_thumb_name'] . '";';
		$javascript .= 'window.close();';
		$javascript .= '</script>';
	} else {
		// 普通缩略图
		$id = $request->post('id');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'opener.document.getElementById("' . $id . '").value="' . $update_file['file_thumb_name'] . '";';
		$javascript .= 'opener.document.getElementById("img-' . $id . '").style.display="";';
		$javascript .= 'opener.document.getElementById("img-' . $id . '").src="' . $domain . $update_file['file_thumb_name'] . '";';
		$javascript .= 'window.close();';
		$javascript .= '</script>';
	}
	return $javascript;
}