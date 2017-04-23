<?php
namespace App\View\Helper;

use Cake\I18n\FrozenTime;
use Cake\View\Helper;

class TimeHelper extends Helper
{
    /**
     * Function to format a date with ucwords.
     *
     * @param \Cake\I18n\FrozenTime $time The time to format.
     *
     * @return string The formatted date.
     */
    public function i18nFormat(FrozenTime $time)
    {
        return ucwords($time->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT]));
    }
}
