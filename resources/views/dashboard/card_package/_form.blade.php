<div class="card px-7 py-7">
    <div class="row">
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('client_id', trans('dashboard.client.name')) !!}
            <span class="requiredFields">*</span>

            {{-- edit input --}}
            @if (isset($client))
                {!! Form::text('fullname', $client->fullname, ['class' => 'form-control', 'disabled', 'dir' => 'rtl', 'data-placeholder' => trans('dashboard.client.select_client')]) !!}
                {!! Form::hidden('client_id', $client->id) !!}

            {{-- create input --}}
            @else
                {!! Form::select('client_id', ['' => ''] + $clients, null, ['class' => 'form-control select2-show-search', 'dir' => 'rtl', 'data-placeholder' => trans('dashboard.client.select_client'), 'id' => 'client_id']) !!}
                <span class="text-danger" id="client_idError" hidden></span>
            @endif
        </div>

        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('discountRate', trans('dashboard.card_package.basic_card_discount')) !!}

            <span class="requiredFields">*</span>
            <div class="input-group">

                {!! Form::number('basic_discount', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('dashboard.card_package.enter_discount'),
                        'id' => 'discountRate',
                        'onpaste' => 'return false',
                        'onCopy' => 'return false',
                        'onCut' => 'return false',
                        'onDrag' => 'return false',
                        'onDrop' => 'return false',
                        'autocomplete' => 'off',
                ]) !!}

                <div class="input-group-text border-start-0"> % </div>
            </div>
            <span class="text-danger" id="basic_discountError" hidden></span>

        </div>
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('discountRate', trans('dashboard.card_package.golden_card_discount')) !!}
            <span class="requiredFields">*</span>

            <div class="input-group">

                {!! Form::number('golden_discount', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('dashboard.card_package.enter_discount'),
                        'id' => 'discountRate',
                        'onpaste' => 'return false',
                        'onCopy' => 'return false',
                        'onCut' => 'return false',
                        'onDrag' => 'return false',
                        'onDrop' => 'return false',
                        'autocomplete' => 'off',
                ]) !!}

                <div class="input-group-text border-start-0"> % </div>
            </div>

            <span class="text-danger" id="golden_discountError" hidden></span>

        </div>
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('discountRate', trans('dashboard.card_package.platinum_card_discount')) !!}

            <span class="requiredFields">*</span>
            <div class="input-group">

                {!! Form::number('platinum_discount', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('dashboard.card_package.enter_discount'),
                        'id' => 'discountRate',
                        'onpaste' => 'return false',
                        'onCopy' => 'return false',
                        'onCut' => 'return false',
                        'onDrag' => 'return false',
                        'onDrop' => 'return false',
                        'autocomplete' => 'off',
                ]) !!}

                <div class="input-group-text border-start-0"> % </div>
            </div>
            <span class="text-danger" id="platinum_discountError" hidden></span>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-page-next-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-bs-toggle' => 'modal', 'id' => 'submitButton']) !!}
        {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}
    </div>
</div>
