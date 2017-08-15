<?php
/**
 *
 * 帐户 - 控制器
 *
 * @package   NiPHPCMS
 * @category  admin\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Account.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\controller;

use think\Url;
use think\Lang;
use app\admin\controller\Base;
use app\admin\logic\CommonLogin as LogicCommonLogin;
use app\admin\Logic\CommonRequest as LogicCommonRequest;

class Account extends Base
{
    /**
     * 登录
     * @access public
     * @param
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            // IP锁定
            $request_log = new LogicCommonRequest;
            if ($request_log->ipRequestError()) {
                $this->error(Lang::get('error username or password'));
            }

            $result = $this->validate($_POST, 'Account.login');
            if(true === $result){
                $logic = new LogicCommonLogin;
                $result = $logic->checkLogin();
            }

            if (true === $result) {
                $this->actionLog('admin_login', '', 'login success', true);
                $this->redirect(Url::build('settings/info'));
            } else {
                $this->actionLog('admin_login', '', 'username or password', true);
                $this->error(Lang::get('error username or password'));
            }
        }

        return $this->fetch();
    }

    /**
     * 注销
     * @access public
     * @param
     * @return void
     */
    public function logout()
    {
        $this->actionLog('admin_logout');
        $logic = new LogicCommonLogin;
        $result = $logic->logout();
        if (true === $result) {
            $this->redirect(Url::build('account/login'));
        }
    }
}
