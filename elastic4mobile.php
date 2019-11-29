<?php

/**
 * Elastic skin for mobile devices plugin
 *
 * Selects the elastic skin if a mobile device is detected as client.
 *
 * @author Thomas Bruederli <thomas@roundcube.net>
 * @license GNU GPLv3+
 */
class elastic4mobile extends rcube_plugin
{
    public $noajax = true;
    //public $task = '?(?!logout).*';

    public function init()
    {
        $rcmail = rcmail::get_instance();
        $detect = new Mobile_Detect;

        if ($detect->isMobile() || $detect->isTablet()) {
          $skin = 'elastic';
          $rcmail->config->set('skin', $skin);
          $rcmail->output->set_skin($skin);
          // Reset default skin, otherwise it will be reset to default in rcmail::kill_session()
          // TODO: This could be done better
          $rcmail->default_skin = $skin;

          // disable skin switch as this wouldn't have any effect
          $dont_override = (array) $rcmail->config->get('dont_override');
          if (!in_array('skin', $dont_override)) {
            $dont_override[] = 'skin';
            $rcmail->config->set('dont_override', $dont_override, true);
          }
        }
    }
}
