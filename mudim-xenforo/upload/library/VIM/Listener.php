<?php

class VIM_Listener
{
    public static function visitor_setup(XenForo_Visitor &$visitor)
    {
        $options = XenForo_Application::getOptions();
        $default = array(
            'method' => $options->get('vim_method'),
            'speller' => $options->get('vim_speller'),
            'accentRule' => $options->get('vim_accentRule'),
        );

        if ($visitor->get('user_id') > 0) {
            $raw = $visitor->get('vietnamese_input_method');
            if (!empty($raw)) {
                $parsed = @unserialize($raw);
                if (!empty($parsed)) {
                    $parsed = array_merge($default, $parsed);
                }
            }
        }

        $visitor['vietnamese_input_method'] = empty($parsed) ? $default : $parsed;
    }

    public static function file_health_check(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes += VIM_FileSums::getHashes();
    }

    public static function load_class_XenForo_ControllerPublic_Account($class, array &$extend)
    {
        if ($class == 'XenForo_ControllerPublic_Account') {
            $extend[] = 'VIM_' . $class;
        }
    }

    public static function load_class_XenForo_DataWriter_User($class, array &$extend)
    {
        if ($class === 'XenForo_DataWriter_User') {
            $extend[] = 'VIM_XenForo_DataWriter_User';
        }
    }
}