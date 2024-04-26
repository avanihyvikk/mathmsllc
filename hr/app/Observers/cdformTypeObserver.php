<?php

namespace Modules\cdform\Observers;

use Modules\cdform\Entities\cdformType;

class cdformTypeObserver
{
    public function creating(cdformType $model)
    {

        if (company()) {
            $model->company_id = company()->id;
        }
    }
}
