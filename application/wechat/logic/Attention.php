<?php
/**
 *
 * 关注回复 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Attention.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\logic;

use think\Model;
use think\Lang;
use think\Request;
use app\wechat\logic\Common;
use app\admin\model\Reply as WechatReply;

class Attention extends Common
{

    public function reply()
    {
        $map = [
            'type' => 2,
            'lang' => Lang::detect()
        ];

        $model = new WechatReply;

        $result =
        $model->field(true)
        ->where($map)
        ->select();

        $data = [];
        foreach ($result as $value) {
            $value = $value->toArray();

            if (!empty($value['image']) && !empty($value['url'])) {
                if (file_exists($value['image'])) {
                    $value['image'] = $this->domain . $value['image'];
                }
                $data['item'][] = [
                    'Title' => $value['title'],
                    'Description' => $value['content'],
                    'PicUrl' => $value['image'],
                    'Url' => $value['url']
                ];
            } elseif(!empty($value['url'])) {
                $data[] = '<a href="' . $value['url'] . '">' . $value['content'] . '</a>';
            } else {
                $data[] = $value['content'];
            }
        }
        return $data;
    }
}
