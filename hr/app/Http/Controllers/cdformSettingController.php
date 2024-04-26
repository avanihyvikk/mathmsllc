<?php

namespace Modules\cdform\Http\Controllers;

use App\Helper\Reply;
use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use Modules\cdform\Entities\cdformType;
use Modules\cdform\Entities\cdformSetting;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\AccountBaseController;

class cdformSettingController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('cdform::app.menu.cdform');
        $this->middleware(function ($request, $next) {
            abort_403(! in_array(cdformSetting::MODULE_NAME, $this->user->modules));

            return $next($request);
        });
        $this->activeSettingMenu = 'cdform_settings';
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->projectCategory = ProjectCategory::all();
        $this->cdformTypes = cdformType::all();
        $this->view = 'cdform::cdform-settings.type';

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();

            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle, 'activeTab' => $this->activeTab]);
        }

        return view('cdform::cdform-settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cdform::cdform-settings.create-cdform-type-settings-modal', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->cdformType = cdformType::findOrfail($id);
        return view('cdform::cdform-settings.edit-cdform-type-settings-modal', $this->data);
    }
}
