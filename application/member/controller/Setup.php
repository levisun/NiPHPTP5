<?php
/**
 *
 * 设置 - 控制器
 *
 * @package   NiPHPCMS
 * @category  member\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Setup.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\member\controller;

use think\Url;
use think\Lang;
use app\member\controller\Base;
use app\member\Logic\Setup as MemberSetup;

class Setup extends Base
{

    public function bases()
    {
        $member = new MemberSetup();

        // AJAX获得地区
        if ($this->request->isAjax()) {
            $id = $this->request->post('id/f');
            $data = $member->getRegion($id);

            $option = '';
            foreach ($data as $key => $value) {
                $option .= '<option class="op" value="' . $value['id'] . '">';
                $option .= $value['name'];
                $option .= '</option>';
            }
            return $option;
        }

        $this->assign('user_data', $member->getUserInfo());
        $this->assign('region', $member->getRegion(1));

        return $this->fetch();
    }
}
