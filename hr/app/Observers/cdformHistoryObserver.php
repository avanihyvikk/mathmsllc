<?php

namespace Modules\cdform\Observers;

use Froiden\RestAPI\Exceptions\ApiException;
use Modules\cdform\Entities\cdformHistory;
use Modules\cdform\Notifications\cdformLent;
use Modules\cdform\Notifications\cdformReturn;

class cdformHistoryObserver
{
    public function creating(cdformHistory $cdformHistory)
    {
        //region Field conditions

        $cdform = $cdformHistory->cdform;

        if ($cdform->status == 'lent') {
            // New cdform history should not be created if cdform is already lent. In this case,
            // prev history entry should be updated first
            throw new ApiException('This cdform has already been lent', null, 422, 422, 2014);
        }

        if (user()) {
            $cdformHistory->lender_id = user()->id;
        }

        if (company()) {
            $cdformHistory->company_id = company()->id;
        }

        //endregion
    }

    public function created(cdformHistory $cdformHistory)
    {
        if ($cdformHistory->date_of_return === null) {
            $cdformHistory->user->notify(new cdformLent($cdformHistory->cdform, $cdformHistory));
        }
    }

    public function saved(cdformHistory $cdformHistory)
    {
        $cdform = $cdformHistory->cdform;

        $lentcdformHistory = cdformHistory::whereNull('date_of_return')
            ->where('cdform_id', $cdform->id)->first();

        if ($lentcdformHistory) {
            // This means the cdform has been lent, so, change cdform status
            $cdform->status = 'lent';
            $cdform->save();

        } elseif ($cdform->status !== 'non-functional') {
            $cdform->status = 'available';
            $cdform->save();
        }
    }

    public function updating(cdformHistory $cdformHistory)
    {
        $cdform = $cdformHistory->cdform;

        $prevcdformHistory = cdformHistory::findOrFail($cdformHistory->id);

        if ($cdformHistory->date_of_return == null &&
            $prevcdformHistory->date_of_return !== null && $cdform->status == 'lent') {
            // We are trying to create a new lent cdform history, which is incorrect
            throw new ApiException('This cdform has already been lent', null, 422, 422, 2014);
        }

        if (user() && $cdformHistory->date_of_return !== null && $prevcdformHistory->date_of_return === null) {
            $cdformHistory->returner_id = user()->id;
        }
    }

    public function updated(cdformHistory $cdformHistory)
    {
        if ($cdformHistory->date_of_return !== null) {
            $cdformHistory->user->notify(new cdformReturn($cdformHistory->cdform, $cdformHistory));
        }
    }

    public function deleted(cdformHistory $cdformHistory)
    {
        cdformHistoryObserver::saved($cdformHistory);
    }
}
