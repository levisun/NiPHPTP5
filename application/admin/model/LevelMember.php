<?php
/**
 *
 * 会员组关系表 - 数据层
 *
 * @package   NiPHPCMS
 * @category  admin\model\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: LevelMember.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/03
 */
namespace app\admin\model;
use think\Model;
class LevelMember extends Model
{
	protected $name = 'level_member';
	protected $autoWriteTimestamp = false;
	protected $field = [
		'user_id'  => 'int',
		'level_id' => 'int',
	];
}