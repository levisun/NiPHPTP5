<?php
/**
 *
 * 文件操作类
 *
 * @package   NiPHPCMS
 * @category  extend\util\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: File.php v1.0.1 $
 * @link      http://www.NiPHP.com
 */
namespace util;

class File
{

    public static function removeUselessFile($dir = './')
    {
        $del = ['.gitignore', '.DS_Store', 'Thumbs.db'];
        $dirArr = self::get($dir);
        foreach ($dirArr as $key => $value) {
            if (is_dir($dir . $value['name'])) {
                self::removeUselessFile($dir . $value['name'] . '/');
            } elseif (in_array($value['name'], $del) && file_exists($dir . $value['name'])) {
                echo $dir . $value['name'];
                unlink($dir . $value['name']);
            }
        }
    }

    /**
     * 创建文件
     * @static
     * @access public
     * @param  string  $file_name  文件
     * @param  string  $data       数据
     * @param  boolean $is_cover   是否覆盖
     * @return boolean
     */
    public static function create($file_name, $data = '', $is_cover = false)
    {
        self::createDir($file_name);

        // 不是文件名
        $pathinfo = pathinfo($file_name);
        if (empty($pathinfo['extension'])) {
            return false;
        }

        if ($is_cover) {
            return !!file_put_contents($file_name, $data);
        } else {
            return !!file_put_contents($file_name, $data, FILE_APPEND);
        }
    }

    /**
     * 新建目录
     * @static
     * @access public
     * @param  string  $dir_path 目录
     * @return void
     */
    public static function createDir($dir_path)
    {
        $dir = explode(DIRECTORY_SEPARATOR, $dir_path);

        $dir_path = '';

        foreach ($dir as $key => $value) {
            // 文件名跳出
            $pathinfo = pathinfo($value);
            if (!empty($pathinfo['extension'])) {
                continue;
            }

            $dir_path .= $value . DIRECTORY_SEPARATOR;

            // 目录是否存在
            if (self::has($dir_path)) {
                continue;
            }

            // 目录为空跳出
            if ($dir_path == DIRECTORY_SEPARATOR) {
                continue;
            }

            // 新建目录
            mkdir($dir_path, 0755);
            chmod($dir_path, 0755);
        }
    }

    /**
     * 删除文件或文件夹
     * @static
     * @access public
     * @param  string $file_or_dir 文件名或目录名
     * @return boolean
     */
    public static function delete($file_or_dir)
    {
        if (is_file($file_or_dir)) {
            // 删除文件
            return unlink($file_or_dir);
        } elseif (is_dir($file_or_dir)) {
            // 获得目录中的所有文件
            if (substr($file_or_dir, -1) === DIRECTORY_SEPARATOR) {
                $file = glob($file_or_dir . '*');
            } else {
                $file = glob($file_or_dir . DIRECTORY_SEPARATOR . '*');
            }

            // 删除目录中的所有文件
            foreach ($file as $key => $value) {
                self::delete($value);
            }

            // 删除目录
            return rmdir($file_or_dir);
        }
    }

    /**
     * 文件或文件夹重命名
     * 更换目录不支持新建目录
     * @static
     * @access public
     * @param  string $old 旧名
     * @param  string $new 新名
     * @return boolean
     */
    public static function rename($old, $new)
    {
        // 旧名的文件或目录不存在
        if (!self::has($old)) {
            return false;
        }

        // 新名的文件或目录存在
        if (self::has($new)) {
            return false;
        }

        // 重命名
        return rename($old, $new);
    }

    /**
     * 获得目录下所有文件和文件夹
     * @static
     * @access public
     * @param  string $dir  目录
     * @return array
     */
    public static function get($dir)
    {
        if (self::has($dir)) {
            if (substr($dir, -1) !== DIRECTORY_SEPARATOR) {
                $dir .= DIRECTORY_SEPARATOR;
            }

            $no = [
                '.',
                '..',
                'index.html',
                '.svn',
                '.DS_Store',
                '.gitignore',
                'Thumbs.db'
            ];

            $list = [];

            $handler = opendir($dir);

            while (($file_name = readdir($handler)) !== false) {
                if (!in_array($file_name, $no)) {
                    $list[] = [
                        'name' => $file_name,
                        'size' => filesize($dir . $file_name),
                        'time' => filectime($dir . $file_name),
                    ];
                }
            }

            closedir($handler);

            return $list;
        } else {
            return false;
        }
    }

    /**
     * 检查文件或目录是否存在
     * @static
     * @access public
     * @param  string  $file_path 文件名或目录
     * @return boolean
     */
    public static function has($file_path)
    {
        $pathinfo = pathinfo($file_path);
        if (!empty($pathinfo['extension'])) {
            return is_file($file_path);
        } else {
            return is_dir($file_path);
        }
    }
}
