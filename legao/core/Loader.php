<?php
/**
 * LEGAO
 * The Web Service Data Center Framework for PHP
 * Design concept: SOA & CQRS
 *
 * Licensed under the Open Software License version 3.0
 *
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Wang Kuang, Wang Long
 * @copyright   Copyright (c) 2014 - 2015 , All rights reserved.
 * @license     http://opensource.org/licenses/OSL-3.0
 */
namespace Legao;

/**
 * Loader class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Loader
{
    public static $APPLICATION_PATH = false;

    /**
     * Automatic loading mechanism
     *
     * The system tries to find from the implementation 
     * agreement good path.
     *
     * @access public
     * @return void
     */
    public static function automatic($className)
    {
        $filePath = '';
        $basePath = array(BASEPATH . 'vendor');

        if (substr($className, 0, 5) == 'Legao')
        {
            $basePath  = array(SYSPATH . 'core', SYSPATH . 'components', SYSPATH . 'libraries');
            $className = str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 6));
        }
        elseif (defined('PROPATH'))
        {
            array_unshift($basePath, PROPATH . '/common/bases');
            array_unshift($basePath, PROPATH . '/common/libraries');

            if (substr($className, -5) == 'Query')
            {
                array_unshift($basePath, PROPATH . '/common/queries');
            }
            elseif (substr($className, -8) == 'Business')
            {
                array_unshift($basePath, PROPATH . '/commands/business');
            }
        }

        if ($nspos = strrpos($className, '\\'))
        {
            $filePath  = str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 0, $nspos)) . DIRECTORY_SEPARATOR;
            $className = substr($className, $nspos + 1);
        }

        $filePath .= str_replace('_', DIRECTORY_SEPARATOR, $className);

        foreach ($basePath as $path)
        {
            $full_path = $path . DIRECTORY_SEPARATOR . $filePath;

            if (file_exists("$full_path.php"))
            {
                require "$full_path.php";
                break;
            }
            elseif (is_dir($full_path))
            {
                if (file_exists($full_path .= DIRECTORY_SEPARATOR . (substr($className, (strrpos($className, '_') ?: -1) + 1)) . '.php'))
                {
                    require $full_path;
                    break;
                }
            }
        }
    }
}

/* End file */