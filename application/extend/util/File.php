<?php
/**
 *
 * 文件操作类
 *
 * @package   NiPHPCMS
 * @category  extend\util\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 */
namespace util;

class File
{

    /**
     * 创建文件
     * @static
     * @access public
     * @param  string  $file_path  文件
     * @param  string  $data       数据 默认为null不创建文件
     * @param  boolean $is_cover   是否覆盖
     * @return boolean
     */
    public static function create($file_path, $data = null, $is_cover = false)
    {
        $dir = explode('/', $file_path);
        $dirPath = '';
        foreach ($dir as $path) {
            if (false !== strpos($path, '.')) {
                continue;
            }
            $dirPath .= $path . DIRECTORY_SEPARATOR;
            if ($dirPath != DIRECTORY_SEPARATOR && !is_dir($dirPath)) {
                mkdir($dirPath, 0755);
                chmod($dirPath, 0755);
            }
        }

        if (null !== $data) {
            if($is_cover) {
                return file_put_contents($file_path, $data);
            } else {
                return file_put_contents($file_path, $data, FILE_APPEND);
            }
        }
        return true;
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
        if (is_dir($file_or_dir)) {
            if (substr($file_or_dir, -1) === DIRECTORY_SEPARATOR) {
                $file = glob($file_or_dir . '*');
            } else {
                $file = glob($file_or_dir . DIRECTORY_SEPARATOR . '*');
            }
            foreach ($file as $file) {
                self::delete($file);
            }
            return rmdir($file_or_dir);
        } elseif (file_exists($file_or_dir)) {
            unlink($file_or_dir);
            return true;
        } else {
            return false;
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
        if ((!file_exists($old) && file_exists($new)) || (!is_dir($old) && is_dir($new))) {
            return false;
        }
        return rename($old, $new);
    }

    /**
     * 获得目录下所有文件和文件夹
     * @static
     * @access public
     * @param  string $dir  目录
     * @param  string $date 日期格式 默认Y-m-d H:i:s
     * @return array
     */
    public static function get($dir, $date = 'Y-m-d H:i:s')
    {
        $no = ['.', '..', 'index.html', '.svn', '.DS_Store', '.gitignore', 'Thumbs.db'];
        $dirOrFile = array();
        if (is_dir($dir)) {
            $handler = opendir($dir);
            while (false !== ($fileName = readdir($handler))) {
                if (!in_array($fileName, $no)) {
                    $fileInfo['name'] = $fileName;
                    $fileSize = filesize($dir . $fileName);
                    if ($fileSize <= 1024) {
                        $fileInfo['size'] = $fileSize . 'B';
                    } elseif ($fileSize > 1024 && $fileSize <= 1048576) {
                        $fileInfo['size'] = number_format($fileSize / 1024, 2) . 'KB';
                    } elseif ($fileSize > 1048576 && $fileSize <= 1073741824) {
                        $fileInfo['size'] = number_format($fileSize / 1048576, 2) . 'MB';
                    } else {
                        $fileInfo['size'] = number_format($fileSize / 1073741824, 2) . 'GB';
                    }

                    $fileInfo['time'] = !empty($date) ? date($date, filemtime($dir . $fileName)) : filemtime($path . $fileName);
                    $dirOrFile[] = $fileInfo;
                }
            }
            closedir($handler);
        }
        return $dirOrFile;
    }

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
}
