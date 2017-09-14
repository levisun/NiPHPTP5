<?php
/**
 *
 */
class Tmall
{

    /**
     * 请求
     * @access public
     * @param  string  $url 请求URL
     * @return array
     */
    public function request($url)
    {
        $url = url_params($url);

        $url = 'https://detail.tmall.com/item.htm?id=' . $url['query']['id'];

        $cache = new Cache;
        // 读取缓存
        // 缓存不存在进行采集
        if ($item = $cache->get($url)) {
            return $item;
        }

        $snoopy = new Snoopy;
        $snoopy->fetch($url);
        $snoopy->results = iconv('GB2312', 'UTF-8//IGNORE', $snoopy->results);

        $json_data = $this->getJsonData($snoopy->results);

        if ($json_data === false) {
            return false;
        }
        $default_price = $json_data['detail']['defaultItemPrice'];

        $default_price = explode('-', $default_price);
        $default_price = array_pop($default_price);

        $item = array(
            'id'    => $json_data['itemDO']['itemId'],
            'title' => $json_data['itemDO']['title'],
            'default_price' => $default_price,
            'price' => $json_data['itemDO']['reservePrice'],
            'pics'  => $this->getPics($snoopy->results, $json_data['propertyPics']['default']),
            'desc'  => $this->getDesc('http:' . $json_data['api']['descUrl']),
            'attr'  => $this->getAttr($snoopy->results),
            'url'   => 'https://detail.tmall.com/item.htm?id=' . $json_data['itemDO']['itemId'],
            );

        // 设置缓存
        $cache->set($url, $item);

        return $item;
    }

    /**
     * 获得商品详情图
     * @access private
     * @param  string  $data
     * @param  array   $pics
     * @return array
     */
    public function getPics($data, $pics)
    {
        if (!empty($pics)) {
            foreach ($pics as $key => $value) {
                $pics[$key] = 'https:' . $value;
            }
            return $pics;
        }

        preg_match('/(<ul id="J_UlThumb" class="tb-thumb tm-clear">)(.*?)(<\/ul>)/si', $data, $matches);
        $result = preg_replace('/[\s]+/si', ' ', $matches[0]);

        preg_match_all('/(<img src=")(.*?)(" \/>)/si', $result, $matches);

        $result = $matches[2];

        foreach ($result as $key => $value) {
            $result[$key] = preg_replace('/(\.jpg)(.*?)(\.jpg)/si', '.jpg', $value);
            if (substr($value, 0, 6) != 'https:') {
                $result[$key] = 'https:' . $result[$key];
            }

            $result[$key] = $this->saveImg($result[$key]);
            // $result[$key] = str_replace('_60x60q90.jpg', '', $value);
        }

        return $result;
    }

    /**
     * 商品规格属性
     * @access private
     * @param  string $data
     * @return array
     */
    private function getAttr($data)
    {
        preg_match('/(<dl class="tb-prop tm-sale-prop tm-clear ">)(.*?)(<\/dl>)/si', $data, $matches);

        $result = strip_tags($matches[0]);
        $result = preg_replace('/[\s]+/si', ' ', $result);
        $result = trim($result);
        $array = explode(' ', $result);
        $name = $array[0];
        array_shift($array);
        $attr[$name] = $array;


        preg_match('/(<dl class="tb-prop tm-sale-prop tm-clear tm-img-prop ">)(.*?)(<\/dl>)/si', $data, $matches);

        $result = strip_tags($matches[0]);
        $result = preg_replace('/[\s]+/si', ' ', $result);
        $result = trim($result);
        $array = explode(' ', $result);
        $name = $array[0];
        array_shift($array);
        $attr[$name] = $array;

        return $attr;
    }

    /**
     * 商品详情
     * @access private
     * @param  string $url 请求URL
     * @return string
     */
    private function getDesc($url)
    {
        $snoopy = new Snoopy;
        $snoopy->fetch($url);

        $snoopy->results = iconv('GB2312', 'UTF-8//IGNORE', $snoopy->results);

        if (empty($snoopy->results)) {
            return $this->getDesc($url);
        }

        $snoopy->results = $this->filterEnter($snoopy->results);
        $snoopy->results = substr($snoopy->results, 10);
        $snoopy->results = substr($snoopy->results, 0, -2);

        preg_match_all('/(src=\")(.*?)(\")/si', $snoopy->results, $matches);

        // halt($snoopy->results);
        $img = '';
        $strtr = array('/' => '\/', ':' => '\:', '!' => '\!' , '.' => '\.');
        foreach ($matches[2] as $key => $value) {
            $img .= '<img src="/' . $this->saveImg($value) . '">';
            // $matches[2][$key] = '/' . strtr($value, $strtr) . '/si';
        }
        // $snoopy->results = preg_replace($matches[2], $img, $snoopy->results);
        // halt($img);
        return $img;

        return $snoopy->results;
    }

    /**
     * 获得页面json数据
     * @access private
     * @param  string  $json_data
     * @return array
     */
    private function getJsonData($json_data)
    {
        preg_match('/(TShop.Setup\()(.*?)(<\/script>)/si', $json_data, $result);

        if (empty($result)) {
            return false;
        }

        $data = $result[2];

        $data = $this->filterEnter($data, true);
        $data = substr($data, 0, -7);
        $data = json_decode($data, true);

        return $data;
    }

    /**
     * 过虑回车
     * @access private
     * @param  string  $str
     * @param  boolean $param 是否为json数据
     * @return string
     */
    private function filterEnter($str, $param = false)
    {
        $str = trim($str);
        if ($param) {
            $str = preg_replace('/[\s]+/si', '', $str);
        } else {
            $str = preg_replace('/[\s]+</si', '<', $str);
            $str = preg_replace('/>[\s]+/si', '>', $str);
        }

        return $str;
    }

    private function saveImg($img_url)
    {
        $arr = url_params($img_url);
        $arr = explode('/', $arr['path']);
        $file_name = array_pop($arr);
        $root_path = dirname(dirname(EXT_ROOT_PATH));

        $save_dir = 'images' . DIRECTORY_SEPARATOR . 'collection' . DIRECTORY_SEPARATOR . date('Ym');

        if (!File::has($root_path . DIRECTORY_SEPARATOR . $save_dir . DIRECTORY_SEPARATOR . $file_name)) {
            File::createDir($root_path . DIRECTORY_SEPARATOR . $save_dir);
            $img = file_get_contents($img_url);
            file_put_contents($root_path . DIRECTORY_SEPARATOR . $save_dir . DIRECTORY_SEPARATOR . $file_name, $img);
        }

        return str_replace(DS, '/', $save_dir . DIRECTORY_SEPARATOR . $file_name);
    }
}
