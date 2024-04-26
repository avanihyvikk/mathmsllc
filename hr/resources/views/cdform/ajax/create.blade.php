@php
    $addcdformTypePermission = user()->permission('add_cdforms_type');
@endphp

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-cdform-form">
            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('cdform::app.createTitle')</h4>
                <div class="row p-20">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('cdform::app.cdformName')" fieldName="name"
                                              fieldRequired="true" :fieldPlaceholder="__('cdform::modules.cdforms.name')">
                                </x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.label class="my-3" fieldId="cdform_type_id"
                                               :fieldLabel="__('cdform::app.cdformType')" fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="cdform_type_id" id="cdform_type_id"
                                            data-live-search="true">
                                        <option value="">--</option>
                                        @foreach ($cdformType as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($addcdformTypePermission == 'all' || $addcdformTypePermission == 'added')
                                        <x-slot name="append">
                                            <button id="cdform-type-setting" type="button"
                                                    class="btn btn-outline-secondary border-grey">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="serial_number" :fieldLabel="__('cdform::app.serialNumber')"
                                              fieldName="serial_number" fieldRequired="true"
                                              :fieldPlaceholder="__('cdform::app.serialNumber')">
                                </x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="value" :fieldLabel="__('cdform::app.value')" fieldName="value"
                                              :fieldPlaceholder="__('cdform::app.value')">
                                </x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <x-forms.text fieldId="location" :fieldLabel="__('cdform::app.location')"
                                              fieldName="location" :fieldPlaceholder="__('cdform::app.location')">
                                </x-forms.text>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-forms.label class="my-3" fieldId="status" :fieldLabel="__('cdform::app.status')">
                                    </x-forms.label>
                                    <div class="d-flex">

                                        @foreach(array_diff(array_keys(\Modules\cdform\Entities\cdform::STATUSES),['lent']) as $status)
                                            <x-forms.radio :fieldId="'status-'.$status"
                                                           :fieldValue="$status"
                                                           :checked="$status === 'available'"
                                                           :fieldLabel="__('cdform::app.'.$status)"
                                                           fieldName="status"/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                            <x-forms.file allowedFileExtensions="png jpg jpeg svg" class="mr-0 mr-lg-2 mr-md-2 cropper"
                                          :fieldLabel="__('cdform::app.cdformPicture')" fieldName="image" fieldId="image"
                                          fieldHeight="119" :popover="__('messages.fileFormat.ImageFile')" />
                    </div>
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('cdform::app.description')"
                                              fieldName="description" fieldId="description"
                                              :fieldPlaceholder="__('placeholders.invoices.description')">
                            </x-forms.textarea>
                        </div>
                    </div>

                </div>

                <div class="w-100 border-top-grey d-flex justify-content-start px-4 py-3">
                    <x-forms.button-primary class="mr-3" id="save-cdform" icon="check">@lang('app.save')
                    </x-forms.button-primary>

                    <x-forms.button-cancel :link="route('cdforms.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </div>
            </div>
        </x-form>

    </div>
</div>

<script>
    $(document).ready(function () {

        $('#save-cdform').click(function () {
            const url = "{{ route('cdforms.store') }}";

            $.easyAjax({
                url: url,
                container: '#save-cdform-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-cdform",
                file: true,
                data: $('#save-cdform-form').serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        if ($(MODAL_XL).hasClass('show')) {
                            $(MODAL_XL).modal('hide');
                            window.location.reload();
                        } else {
                            window.location.href = response.redirectUrl;
                        }
                    }
                }
            });
        });

        $('#cdform-type-setting').click(function () {
            const url = "{{ route('cdform-type.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        init(RIGHT_MODAL);
    });
</script>
