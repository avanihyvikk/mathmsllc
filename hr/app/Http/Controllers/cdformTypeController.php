<?php

namespace Modules\cdform\Http\Controllers;

use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Http\Response;
use Modules\cdform\Entities\cdformSetting;
use Modules\cdform\Entities\cdformType;
use Modules\cdform\Http\Requests\cdformType\StoreRequest;

class cdformTypeController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('cdform::app.menu.cdform');
        $this->middleware(function ($request, $next) {
            abort_403(! in_array(cdformSetting::MODULE_NAME, $this->user->modules));

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->cdformTypes = cdformType::all();

        return view('cdform::cdform-type.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $cdformType = cdformType::create($request->all());

        $cdformTypes = cdformType::allcdformTypes();
        $options = '<option value="">--</option>';

        foreach ($cdformTypes as $item) {
            $selected = '';

            if ($item->id == $cdformType->id) {
                $selected = 'selected';
            }

            $options .= '<option '.$selected.' value="'.$item->id.'"> '.$item->name.' </option>';
        }

        return Reply::successWithData(__('cdform::app.typeStoreSuccess'), ['data' => $options]);
    }

    public function update(StoreRequest $request, $id)
    {
        cdformType::where('id', $id)->update(['name' => $request->name]);

        $cdformTypes = cdformType::allcdformTypes();
        $options = '<option value="">--</option>';

        foreach ($cdformTypes as $item) {
            $selected = '';

            if ($item->id == $id) {
                $selected = 'selected';
            }

            $options .= '<option '.$selected.' value="'.$item->id.'"> '.$item->name.' </option>';
        }

        return Reply::successWithData(__('cdform::app.typeUpdateSuccess'), ['data' => $options]);
    }

    public function destroy($id)
    {
        cdformType::destroy($id);
        $cdformTypes = cdformType::allcdformTypes();

        $options = '<option value="">--</option>';

        foreach ($cdformTypes as $item) {
            $options .= '<option value="'.$item->id.'"> '.$item->name.' </option>';
        }

        return Reply::successWithData(__('cdform::app.typeDeleteSuccess'), ['data' => $options]);
    }
}
