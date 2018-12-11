@extends('partial.crud.create', [
    'pageTitle' => __('messages.Create payment')
])

@section('form')

    <div class="row">
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'contributor_id',
                'label' => __('messages.Employer'),
                'list' => $contributorList ?? [],
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'hour_rate',
                'label' => __('messages.Hour rate'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'amount',
                'label' => __('messages.Amount'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.select', [
                'name' => 'status_id',
                'label' => __('messages.Status'),
                'list' => $statusList ?? [],
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'hours',
                'label' => __('messages.Payed hours'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.text', [
                'name' => 'title',
                'label' => __('messages.Short comment'),
            ])
        </div>
        <div class="col-md-6">
            @include('partial.form.element.date', [
                'name' => 'payment_date',
                'label' => __('messages.Payment date'),
            ])
        </div>
        <div class="col-md-12">
            @include('partial.form.element.textarea', [
                'name' => 'description',
                'label' => __('messages.Description'),
                'options' => [
                    'rows' => 5,
                ],
            ])
        </div>
    </div>

@endsection

@push('js')
    <script>
        function calculateHours() {
            console.log('-');
            var payedHours = null;
            if ($('[name="hour_rate"]').val()) {
                payedHours = $('[name="amount"]').val() / $('[name="hour_rate"]').val();
                payedHours = payedHours.toFixed(2);
            }
            $('[name="hours"]').val(payedHours);
        }

        $('[name="contributor_id"]').on('select2:select', function (e) {
            $.get('{{ route('contributor.rate', '#contributor_id#') }}'.replace('#contributor_id#', e.params.data.id))
                .done(function(response) {
                    if (response.status && response.status.result === 'success') {
                        $('[name="hour_rate"]').val(response.data.hour_rate);
                        calculateHours();
                    }
                });
        });

        $('[name="hour_rate"]').on('input', function (e) {
            calculateHours();
        });

        $('[name="amount"]').on('input', function (e) {
            calculateHours();
        });
    </script>
@endpush
