<?php
/**
 *
 * 自动|关键词回复 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  wechat\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: AutoKey.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\wechat\logic;
use think\Model;
use think\Lang;
use think\Request;
use app\wechat\logic\Common;
use app\admin\model\Reply as WechatReply;
class AutoKey extends Common
{

    public function reply($key)
    {
        $data = $this->getKey($key);
        if (empty($data)) {
            $data = $this->getAuto();
        }
        return $data;
    }


    /**
     * 关键词回复
     * @access public
     * @param
     * @return array
     */
    public function getKey($key)
    {
        $map = [
            'type' => 0,
            'keyword' => ['LIKE', '%' . $key . '%'],
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

    /**
     * 自动回复内容信息
     * @access public
     * @param
     * @return array
     */
    public function getAuto()
    {
        $map = [
            'type' => 1,
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