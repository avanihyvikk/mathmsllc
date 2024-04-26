<?php

namespace Modules\cdform\Http\Controllers;

use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Models\User;
use Carbon\Carbon as Carbon;
use Modules\cdform\Entities\cdform;
use Modules\cdform\Entities\cdformHistory;
use Modules\cdform\Entities\cdformSetting;
use Modules\cdform\Http\Requests\LendRequest;
use Modules\cdform\Http\Requests\ReturnRequest;

class cdformHistoryController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            abort_403(! in_array(cdformSetting::MODULE_NAME, $this->user->modules));

            return $next($request);
        });
    }

    public function create($id)
    {
        $this->cdform = cdform::findOrFail($id);
        $this->employees = User::allEmployees();

        return view('cdform::cdform.ajax.lend', $this->data);
    }

    public function store(LendRequest $request, $id)
    {
        $cdform = cdform::findOrFail($id);

        $cdformHistory = new cdformHistory;
        $cdformHistory->cdform_id = $id;
        $cdformHistory->user_id = $request->employee_id;
        $cdformHistory->lender_id = user()->id;
        //phpcs:ignore
        $cdformHistory->date_given = Carbon::createFromFormat($this->company->date_format, $request->date_given)->format('Y-m-d H:i:s');

        if ($request->has('return_date') && $request->return_date != '') {
            //phpcs:ignore
            $cdformHistory->return_date = Carbon::createFromFormat($this->company->date_format, $request->return_date)->format('Y-m-d H:i:s');
        }

        if ($request->has('notes')) {
            $cdformHistory->notes = $request->notes;
        }

        $cdformHistory->save();

        $cdform->status = 'lent';
        $cdform->save();

        return Reply::success(__('cdform::app.lendcdformMessage'));
    }

    //phpcs:ignore
    public function edit($cdformId, $historyId)
    {
        $this->history = cdformHistory::findOrFail($historyId);
        $this->employees = User::allEmployees();

        return view('cdform::cdform.ajax.history-edit', $this->data);
    }

    //phpcs:ignore
    public function returncdform($cdformId, $historyId)
    {
        $this->history = cdformHistory::findOrFail($historyId);

        return view('cdform::cdform.ajax.return', $this->data);
    }

    /**
     * @return array
     */
    public function update(ReturnRequest $request, $cdformId, $id)
    {
        $cdform = cdform::findOrFail($cdformId);
        $cdformHistory = cdformHistory::findOrFail($id);

        $cdformHistory->cdform_id = $cdform->id;

        if ($request->has('employee_id')) {
            $cdformHistory->user_id = $request->employee_id;
        }

        if ($request->has('date_given')) {
            //phpcs:ignore
            $cdformHistory->date_given = Carbon::createFromFormat(company()->date_format, $request->date_given)->format('Y-m-d H:i:s');
        }

        if ($request->has('return_date') && $request->return_date != '') {
            //phpcs:ignore
            $cdformHistory->return_date = Carbon::createFromFormat(company()->date_format, $request->return_date)->format('Y-m-d H:i:s');
        }

        if ($request->has('date_of_return') && $request->date_of_return != '') {
            //phpcs:ignore
            $cdformHistory->date_of_return = Carbon::createFromFormat(company()->date_format, $request->date_of_return)->format('Y-m-d H:i:s');

            $cdform->status = 'available';
            $cdform->save();
        }

        if ($request->has('notes')) {
            $cdformHistory->notes = $request->notes;
        }

        $cdformHistory->save();

        if ($request->show_page) {
            $this->cdform = cdform::with(['history' => function ($query) {
                return $query->orderBy('id', 'desc');
            }, 'cdformType'])->findOrFail($cdformId);

            $view = view('cdform::cdform.ajax.history', $this->data)->render();

            return Reply::successWithData(__('cdform::app.historyUpdateSuccess'), ['view' => $view]);
        }

        return Reply::success(__('cdform::app.historyUpdateSuccess'));
    }

    public function destroy($cdformId, $id)
    {
        cdformHistory::destroy($id);

        $this->cdform = cdform::with(['history' => function ($query) {
            return $query->orderBy('id', 'desc');
        }, 'cdformType'])->findOrFail($cdformId);

        $view = view('cdform::cdform.ajax.history', $this->data)->render();

        return Reply::successWithData(__('cdform::app.historyDeleteSuccess'), ['view' => $view]);
    }
}
