<?php
/**
 *
 * 公众 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\logic;
use think\Model;
use think\Request;
use app\admin\model\Reply as WechatReply;
class Common extends Model
{

    protected $request = null;
    protected $domain;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        // 获得域名地址
        $domain = $this->request->root(true);
        $this->domain = strtr($domain, ['/index.php' => '']);
    }
}