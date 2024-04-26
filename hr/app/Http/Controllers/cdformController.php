<?php

namespace Modules\cdform\Http\Controllers;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Models\User;
use Illuminate\Http\Response;
use Modules\cdform\DataTables\cdformDataTable;
use Modules\cdform\Entities\cdform;
use Modules\cdform\Entities\cdformSetting;
use Modules\cdform\Entities\cdformType;
use Modules\cdform\Http\Requests\StoreRequest;
use Modules\cdform\Http\Requests\UpdateRequest;

class cdformController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('cdform::app.menu.cdform');
        $this->middleware(function ($request, $next) {
            abort_403(!in_array(cdformSetting::MODULE_NAME, $this->user->modules));

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(cdformDataTable $dataTable)
    {
        $this->viewcdformPermission = user()->permission('view_cdform');

        abort_403($this->viewcdformPermission == 'none');

        $this->cdformType = cdformType::all();
        $this->employees = User::allEmployees();
        $this->totalcdforms = cdform::count();
        $this->status = array_keys(cdform::STATUSES);

        return $dataTable->render('cdform::cdform.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->addPermission = user()->permission('add_cdform');
        abort_403($this->addPermission !== 'all');

        $this->cdforms = new cdform;
        $this->cdformType = cdformType::all();

        $this->view = 'cdform::cdform.ajax.create';

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();

            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        return view('cdform::cdform.create', $this->data);

    }

    public function store(StoreRequest $request)
    {
        $cdform = new cdform;
        $this->storeUpdate($cdform, $request);

        return Reply::successWithData(__('cdform::app.storeSuccess'), ['redirectUrl' => route('cdforms.index')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->editPermission = user()->permission('edit_cdform');
        abort_403($this->editPermission !== 'all');

        $this->cdform = cdform::findOrFail($id);
        $this->cdformType = cdformType::all();

        $this->view = 'cdform::cdform.ajax.edit';

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        return view('cdform::cdform.create', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $cdform = cdform::findOrFail($id);
        $this->storeUpdate($cdform, $request);

        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => route('cdforms.index')]);
    }

    private function storeUpdate($cdform, $request)
    {
        $cdform->name = $request->name;
        $cdform->serial_number = $request->serial_number;
        $cdform->cdform_type_id = $request->cdform_type_id;
        $cdform->value = $request->value;
        $cdform->location = $request->location;

        if ($request->has('description')) {
            $cdform->description = $request->description;
        }

        if ($cdform->status != 'lent') {
            $cdform->status = $request->status;
        }

        if ($request->image_delete == 'yes') {
            Files::deleteFile($cdform->image, 'cdforms');
            $cdform->image = null;
        }

        if ($request->hasFile('image')) {
            Files::deleteFile($cdform->image, 'cdforms');
            $cdform->image = Files::uploadLocalOrS3($request->image, 'cdforms');
        }

        $cdform->save();
    }

    public function show($id)
    {
        $this->viewPermission = user()->permission('view_cdform');
        abort_403($this->viewPermission == 'none');

        $this->cdform = cdform::with(['history' => function ($query) {
            return $query->orderBy('id', 'desc');
        }, 'cdformType'])->findOrFail($id);

        $this->history = 'cdform::cdform.ajax.history';
        $this->view = 'cdform::cdform.ajax.show';

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();

            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        return view('cdform::cdform.create', $this->data);
    }

    public function destroy($id)
    {
        $deletePermission = user()->permission('delete_cdform');
        abort_403(!in_array($deletePermission, ['all', 'added']));

        cdform::destroy($id);

        return Reply::success(__('messages.deleteSuccess'));

    }

}
