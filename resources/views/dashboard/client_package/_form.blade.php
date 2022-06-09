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
        @foreach ($packages as $package)
            <div class="col-12 col-md-6 mb-5">
            {!! Form::label('discountRate_'. $package->id, trans('dashboard.package.package_title',['name' => $package->name])) !!}

            <span class="requiredFields">*</span>
            <div class="input-group">
                <input type="hidden" name="discounts[{{ $loop->index }}][package_id]" value="{{ $package->id }}">
                {!! Form::number("discounts[$loop->index][package_discount]", null, [
                        'class' => 'form-control',
                        'placeholder' => trans('dashboard.package.enter_discount'),
                        'id' => 'discountRate_'. $package->id,
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

        @endforeach
        
    </div>
</div>


<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-bs-toggle' => 'modal', 'id' => 'submitButton']) !!}
        {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}
    </div>
</div>
