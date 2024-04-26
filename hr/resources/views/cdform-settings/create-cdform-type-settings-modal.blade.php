@php
    $addcdformTypePermission = user()->permission('add_cdforms_type');
@endphp

<div class="modal-header">
    <h5 class="modal-title">@lang('cdform::app.addcdformType')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<x-form id="create-cdform-type" method="POST" class="ajax-form">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <x-forms.text fieldId="name" :fieldLabel="__('app.name')" fieldName="name"
                              fieldRequired="true" :fieldPlaceholder="__('app.name')">
                </x-forms.text>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        @if ($addcdformTypePermission == 'all' || $addcdformTypePermission == 'added')
            <x-forms.button-cancel data-dismiss="modal" class="mr-3 border-0">@lang('app.close')</x-forms.button-cancel>
            <x-forms.button-primary id="save-cdform-type" icon="check">@lang('app.save')</x-forms.button-primary>
        @endif
    </div>
</x-form>


<script>

$('#save-cdform-type').click(function () {
        var url = "{{ route('cdform-type.store') }}";
        $.easyAjax({
            url: url,
            container: '#create-cdform-type',
            type: "POST",
            data: $('#create-cdform-type').serialize(),
            disableButton: true,
            blockUI: true,
            buttonSelector: "#save-cdform-type",
            success: function (response) {
                if (response.status == 'success') {
                    if (response.status == 'success') {
                        $('#cdform_type_id').html(response.data);
                        $('#cdform_type_id').selectpicker('refresh');
                        $(MODAL_LG).modal('hide');
                        window.location.reload();
                    }
                }
            }
        })
    });
</script>
