<div class="col-12 border-bottom-grey">
    <h3 class="heading-h1 mb-3">@lang('cdform::app.history')</h3>
</div>
@forelse($cdform->history as $history)
    <div class="col-11 border-bottom-grey py-3">
        <div class="col-12 px-0 pb-3 d-flex">
            <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                @lang('cdform::app.lentTo')</p>
            <p class="mb-0 text-dark-grey f-14">
                <x-employee :user="$history->user"/>
            </p>
        </div>

        <x-cards.data-row :label="__('cdform::app.dateGiven')"
                          :value="$history->date_given->setTimezone($global->timezone)->format('d F Y H:i A') .' ('. $history->date_given->setTimezone($global->timezone)->diffForHumans(now()->setTimezone($global->timezone)) .')'"
                          html="true"/>

        <x-cards.data-row :label="__('cdform::app.returnDate')"
                          :value="!is_null($history->return_date) ? $history->return_date->setTimezone($global->timezone)->format('d F Y H:i A'). ' ('.$history->return_date->setTimezone($global->timezone)->diffForHumans(now()->setTimezone($global->timezone)) .')' : '--'"
                          html="true"/>

        <x-cards.data-row :label="__('cdform::app.dateOfReturn')"
                          :value="!is_null($history->date_of_return) ? $history->date_of_return->setTimezone($global->timezone)->format('d F Y H:i A'). ' ('.$history->date_of_return->setTimezone($global->timezone)->diffForHumans(now()->setTimezone($global->timezone)) .')' : '--'"
                          html="true"/>

        <div class="col-12 px-0 pb-3 d-flex">
            <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                @lang('cdform::app.returnedBy')</p>
            <p class="mb-0 text-dark-grey f-14">
                @if ($history->returner)
                    <x-employee :user="$history->returner"/>
                @else
                    --
                @endif
            </p>
        </div>
        <x-cards.data-row :label="__('cdform::app.notes')" :value="is_null($history->notes) ? '--' : $history->notes"
                          html="true"/>
    </div>
    <div class="col-md-1 border-bottom-grey py-3 text-right">
        <div class="dropdown ml-auto comment-action">
            <button class="btn btn-lg f-14 py-1 text-lightest text-capitalize rounded dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                 aria-labelledby="dropdownMenuLink" tabindex="0">
                @if (user()->permission('edit_cdforms_history') == 'all' || user()->permission('edit_cdforms_history') == 'added')
                    <a class="dropdown-item edit-history" href="javascript:;" data-history-id="{{ $history->id }}"
                       data-cdform-id="{{ $cdform->id }}">@lang('app.edit')</a>
                @endif

                @if (user()->permission('delete_cdforms_history') == 'all' || user()->permission('delete_cdforms_history') == 'added')
                    <a class="dropdown-item delete-history" data-history-id="{{ $history->id }}"
                       data-cdform-id="{{ $cdform->id }}" href="javascript:;">@lang('app.delete')</a>
                @endif
            </div>
        </div>
    </div>

@empty
    <div class="align-items-center d-flex flex-column text-lightest p-20 w-100">
        <i class="fa fa-comment-alt f-21 w-100"></i>

        <div class="f-15 mt-4">
            - @lang('cdform::app.noLendingHistoryFound') -
        </div>
    </div>
@endforelse
