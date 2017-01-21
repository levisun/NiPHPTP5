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
     * @param  string  $filePath_  文件
     * @param  string  $data_      数据 默认为null不创建文件
     * @param  boolean $isCover_   是否覆盖
     * @return boolean
     */
    static public function create($filePath_, $data_=null, $isCover_=false)
    {
        $dir = explode('/', $filePath_);
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

        if (null !== $data_) {
            if($isCover_) {
                return file_put_contents($filePath_, $data_);
            } else {
                return file_put_contents($filePath_, $data_, FILE_APPEND);
            }
        }
        return true;
    }

    /**
     * 删除文件或文件夹
     * @static
     * @access public
     * @param  string $fileOrDir_ 文件名或目录名
     * @return boolean
     */
    static public function delete($fileOrDir_)
    {
        if (is_dir($fileOrDir_)) {
            if (substr($fileOrDir_, -1) === DIRECTORY_SEPARATOR) {
                $file = glob($fileOrDir_ . '*');
            } else {
                $file = glob($fileOrDir_ . DIRECTORY_SEPARATOR . '*');
            }
            foreach ($file as $file) {
                self::delete($file);
            }
            return rmdir($fileOrDir_);
        } elseif (file_exists($fileOrDir_)) {
            unlink($fileOrDir_);
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
     * @param  string $old_ 旧名
     * @param  string $new_ 新名
     * @return boolean
     */
    static public function rename($old_, $new_)
    {
        if ((!file_exists($old_) && file_exists($new_)) || (!is_dir($old_) && is_dir($new_))) {
            return false;
        }
        return rename($old_, $new_);
    }

    /**
     * 获得目录下所有文件和文件夹
     * @static
     * @access public
     * @param  string $dir_  目录
     * @param  string $date_ 日期格式 默认Y-m-d H:i:s
     * @return array
     */
    static public function get($dir_, $date_='Y-m-d H:i:s')
    {
        $no = ['.', '..', 'index.html', '.svn', '.DS_Store', '.gitignore', 'Thumbs.db'];
        $dirOrFile = array();
        if (is_dir($dir_)) {
            $handler = opendir($dir_);
            while (false !== ($fileName = readdir($handler))) {
                if (!in_array($fileName, $no)) {
                    $fileInfo['name'] = $fileName;
                    $fileSize = filesize($dir_ . $fileName);
                    if ($fileSize <= 1024) {
                        $fileInfo['size'] = $fileSize . 'B';
                    } elseif ($fileSize > 1024 && $fileSize <= 1048576) {
                        $fileInfo['size'] = number_format($fileSize / 1024, 2) . 'KB';
                    } elseif ($fileSize > 1048576 && $fileSize <= 1073741824) {
                        $fileInfo['size'] = number_format($fileSize / 1048576, 2) . 'MB';
                    } else {
                        $fileInfo['size'] = number_format($fileSize / 1073741824, 2) . 'GB';
                    }

                    $fileInfo['time'] = !empty($date_) ? date($date_, filemtime($dir_ . $fileName)) : filemtime($path . $fileName);
                    $dirOrFile[] = $fileInfo;
                }
            }
            closedir($handler);
        }
        return $dirOrFile;
    }

    static public function removeUselessFile($dir_='./')
    {
        $del = ['.gitignore', '.DS_Store', 'Thumbs.db'];
        $dirArr = self::get($dir_);
        foreach ($dirArr as $key => $value) {
            if (is_dir($dir_ . $value['name'])) {
                self::removeUselessFile($dir_ . $value['name'] . '/');
            } elseif (in_array($value['name'], $del) && file_exists($dir_ . $value['name'])) {
                echo $dir_ . $value['name'];
                unlink($dir_ . $value['name']);
            }
        }
    }
}