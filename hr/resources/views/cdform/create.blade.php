@extends('layouts.app')


@section('content')

    <div class="content-wrapper">
        @include($view)
    </div>

@endsection

@push('scripts')
    <script>
        $('body').on('click', '.lend', function () {
            let id = $(this).data('cdform-id');
            let url = "{{ route('history.create', ':id') }}";
            url = url.replace(':id', id);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('body').on('click', '.returncdform', function () {
            let id = $(this).data('cdform-id');
            let historyId = $(this).data('history-id');
            let url = "{{ route('cdforms.return', [':cdform', ':history']) }}";
            url = url.replace(':cdform', id);
            url = url.replace(':history', historyId);
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });
    </script>
@endpush
