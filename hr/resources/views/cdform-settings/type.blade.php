@php
    $deletecdformTypePermission = user()->permission('delete_cdforms_type');
    $editcdformTypePermission = user()->permission('edit_cdforms_type');
@endphp

<div class="p-4 col-lg-12 col-md-12 ntfcn-tab-content-left w-100">

    <div class="table-responsive">
        <x-table class="table-bordered">
            <x-slot name="thead">
                <th>#</th>
                <th width="35%">@lang('cdform::app.typeName')</th>
                <th class="text-right">@lang('app.action')</th>
            </x-slot>

            @forelse($cdformTypes as $key => $type)
                <tr id="row-{{ $type->id }}">
                    <td>
                        {{ $key + 1 }}
                    </td>
                    <td> {{ $type->name }} </td>
                    <td class="text-right">
                        <div class="task_view">
                            @if ($editcdformTypePermission == 'all' || $editcdformTypePermission == 'added')
                                <a href="javascript:;" data-type-id="{{ $type->id }}"
                                   class="editcdformType task_view_more d-flex align-items-center justify-content-center">
                                    <i class="mr-1 fa fa-edit icons"></i> @lang('app.edit')
                                </a>
                            @endif
                        </div>
                        <div class="mt-1 ml-1 task_view mt-lg-0 mt-md-0">
                            @if ($deletecdformTypePermission == 'all' || $deletecdformTypePermission == 'added')
                                <a href="javascript:;" data-type-id="{{ $type->id }}"
                                   class="delete-cdform-type task_view_more d-flex align-items-center justify-content-center">
                                    <i class="mr-1 fa fa-trash icons"></i> @lang('app.delete')
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <x-cards.no-record icon="map-marker-alt" :message="__('messages.noRecordFound')"/>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

</div>

<script>

    $('#addcdformType').click(function () {
        var url = "{{ route('cdform-setting.create') }}";
        console.log(url);
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });

    $('.editcdformType').click(function () {

        var id = $(this).data('type-id');

        var url = "{{ route('cdform-setting.edit', ':id') }}";
        url = url.replace(':id', id);

        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });

    $('body').on('click', '.delete-cdform-type', function () {

        var id = $(this).data('type-id');

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

                var url = "{{ route('cdform-type.destroy', ':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            $('#category-' + id).fadeOut();
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });

</script>
