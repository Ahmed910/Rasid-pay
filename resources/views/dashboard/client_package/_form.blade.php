<div class="card px-7 py-7">
    <div class="row">
        <div class="col-12 col-md-6 mb-5">
            {!! Form::label('client_id', trans('dashboard.client.name')) !!}
            <span class="requiredFields">*</span>

            {{-- edit input --}}
            @if (isset($client))
            {!! Form::text('fullname', $client->fullname, ['class' => 'form-control', 'disabled', 'dir' => 'rtl','onblur'=>'validateData(this)','id'=>'fullname', 'data-placeholder' => trans('dashboard.client.select_client')]) !!}
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
                {!! Form::number("discounts[$loop->index][package_discount]", isset($client) ? $client->clientPackages->pluck('pivot')->firstWhere('package_id',$package->id)->package_discount :null, [

                'class' => 'form-control',
                'placeholder' => trans('dashboard.package.enter_discount'),
                'id' => 'discountRate_'. $package->id,
                'onpaste' => 'return false',
                'onCopy' => 'return false',
                'onCut' => 'return false',
                'onDrag' => 'return false',
                'onDrop' => 'return false',
                'autocomplete' => 'off',
                'onblur'=>'validateData(this)',
                'oninput' => 'javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);',
                'min' => '0',
                'maxlength' => '5',
                ]) !!}

                <div class="input-group-text border-start-0"> % </div>
            </div>
            <span class="text-danger" id="discounts.{{ $loop->index }}.package_discountError" hidden></span>

        </div>

        @endforeach

    </div>
</div>


<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-bs-toggle' => 'modal', 'id' => 'saveButton']) !!}
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary showBack">
            <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
        </a>
    </div>
</div>

@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.scripts')
@include('dashboard.layouts.modals.back')
@include('dashboard.layouts.modals.alert')
