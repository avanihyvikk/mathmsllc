<?php

namespace Modules\cdform\Listeners;

use Modules\cdform\Entities\cdformSetting;

class CompanyCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $company = $event->company;
        cdformSetting::addModuleSetting($company);
    }
}
