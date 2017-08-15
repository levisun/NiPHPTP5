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

class Common extends Model
{

    protected $request = null;
    protected $domain;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();

        // 获得域名地址
        $this->domain = $this->request->domain();
        $this->domain .= substr($this->request->baseFile(), 0, -10);
    }

    protected function toReply($data)
    {
        $result = [];
        foreach ($data as $value) {
            $value = $value->toArray();

            if (!empty($value['image']) && !empty($value['url'])) {
                if (file_exists($value['image'])) {
                    $value['image'] = $this->domain . $value['image'];
                }
                $result['item'][] = [
                    'Title' => $value['title'],
                    'Description' => $value['content'],
                    'PicUrl' => $value['image'],
                    'Url' => $value['url']
                ];
            } elseif(!empty($value['url'])) {
                $result[] = '<a href="' . $value['url'] . '">' . $value['content'] . '</a>';
            } else {
                $result[] = $value['content'];
            }
        }
        return $result;
    }
}
