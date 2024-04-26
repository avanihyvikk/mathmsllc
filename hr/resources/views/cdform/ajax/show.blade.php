<div id="payroll-detail-section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card bg-white border-0 b-shadow-4">
                <div class="card-header bg-white border-bottom-grey text-capitalize justify-content-between p-20">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="heading-h1 mb-3">@lang('cdform::app.cdformInfo')</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <div class="dropdown">
                                <button
                                    class="btn btn-lg f-14 px-2 py-1 text-dark-grey text-capitalize rounded dropdown-toggle"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                     aria-labelledby="dropdownMenuLink" tabindex="0">
                                    @if (user()->permission('edit_cdform') == 'all' || user()->permission('edit_cdform') == 'added')
                                        <a class="dropdown-item openRightModal"
                                           href="{{ route('cdforms.edit', $cdform->id) }}">@lang('app.edit')</a>
                                    @endif
                                    @if ($cdform->status == 'available')
                                        <a href="javascript:;" data-cdform-id="{{ $cdform->id }}"
                                           class="dropdown-item lend">
                                            {{ trans('cdform::app.lend') }}</a>
                                    @endif

                                    @if ($cdform->status == 'lent')
                                        <a href="javascript:;" data-cdform-id="{{ $cdform->id }}"
                                           data-history-id="{{ $cdform->history->count() > 0 ? $cdform->history[0]->id : '' }}"
                                           class="dropdown-item returncdform">
                                            {{ trans('cdform::app.return') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <x-cards.data-row :label="__('cdform::app.cdformName')" :value="ucfirst($cdform->name)"
                                              html="true"/>
                            <x-cards.data-row :label="__('cdform::app.cdformType')"
                                              :value="ucwords($cdform->cdformType->name)" html="true"/>
                            @php
                                $class = \Modules\cdform\Entities\cdform::STATUSES;
                                $status = '<i class="fa fa-circle mr-1 '.$class[$cdform->status].' f-10"></i>'.__('cdform::app.'.$cdform->status);
                            @endphp

                            <x-cards.data-row :label="__('cdform::app.status')" :value="$status"
                                              html="true"/>
                            <x-cards.data-row :label="__('cdform::app.serialNumber')" :value="$cdform->serial_number"
                                              html="true"/>
                            <x-cards.data-row :label="__('cdform::app.value')" :value="$cdform->value" html="true"/>
                            <x-cards.data-row :label="__('cdform::app.location')" :value="$cdform->location"
                                              html="true"/>
                        </div>
                        <div class="col-2">
                            @if ($cdform->image_url)
                                <a target="_blank" href="{{ $cdform->image_url }}" class="text-darkest-grey">
                                    <img src="{{ $cdform->image_url }}"/>
                                </a>
                            @endif
                        </div>

                    </div>
                    <div class="row mt-4" id="history">
                        @include($history)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.edit-history', function () {
        var historyId = $(this).data('history-id');
        var cdformId = $(this).data('cdform-id');
        var url = "{{ route('history.edit', [':cdformId', ':historyId']) }}";
        url = url.replace(':historyId', historyId);
        url = url.replace(':cdformId', cdformId);
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });
    $('body').on('click', '.delete-history', function () {
        var historyId = $(this).data('history-id');
        var cdformId = $(this).data('cdform-id');
        Swal.fire({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.recoverRecord')",
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "@lang('messages.confirmDelete')",
            cancelButtonText: "@lang('app.cancel')",
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('history.destroy', [':cdformId', ':historyId']) }}";
                url = url.replace(':historyId', historyId);
                url = url.replace(':cdformId', cdformId);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            $('#history').html(response.view);
                        }
                    }
                });
            }
        });
    });
</script>
