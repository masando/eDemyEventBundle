<?php

namespace eDemy\EventBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class eDemyEventBundle extends Bundle
{
    public static function getBundleName($type = null)
    {
        if ($type == null) {

            return 'eDemyEventBundle';
        } else {
            if ($type == 'Simple') {

                return 'Event';
            } else {
                if ($type == 'simple') {

                    return 'event';
                }
            }
        }
    }

    public static function eDemyBundle() {

        return true;
    }

}
