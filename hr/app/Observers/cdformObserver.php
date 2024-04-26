<?php

namespace Modules\cdform\Observers;

use Froiden\RestAPI\Exceptions\ApiException;
use Modules\cdform\Entities\cdform;

class cdformObserver
{
    public function saving(cdform $cdform)
    {
        if (! isRunningInConsoleOrSeeding() && user()) {
            $cdform->last_updated_by = user()->id;
        }
    }

    public function creating(cdform $cdform)
    {
        if (! isRunningInConsoleOrSeeding() && user()) {
            $cdform->added_by = user()->id;
        }

        //region Field conditions

        if ($cdform->status === 'lent') {
            // New cdform cannot have lent status
            $cdform->status = 'available';
        }

        if (company()) {
            $cdform->company_id = company()->id;
        }

        //endregion
    }

    public function updating(cdform $cdform)
    {
        //region Field conditions

        $prevcdform = cdform::findOrFail($cdform->id);

        if ($prevcdform->status == 'lent' && $cdform->status == 'non_functional') {
            // Cannot set status to non_function from lent. First, cdform should be returned
            //phpcs:ignore
            throw new ApiException('cdform should be returned before setting status to non functional', null, 422, 422, 2016);
        }

        //endregion
    }
}
