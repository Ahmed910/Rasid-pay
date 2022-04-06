<div class="modal fade" id="modal_archive" data-bs-backdrop="static" data-bs-effect="effect-sign"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <form method="post" action="#?_method=DELETE" id="item" class="needs-validation archieveForm" novalidate>
                @csrf
                @method('delete')
                <div class="modal-body text-center p-0">
                    <lottie-player autoplay loop mode="normal"
                        src="{{ asset('dashboardAssets/images/lottie/archive.json') }}"
                        style="width: 55%; display: block; margin: 0 auto 1em">
                    </lottie-player>
                    <p>{{ trans('dashboard.general.want_to_archive') }}</p>
                    <div class="mt-3">
                        <textarea class="form-control" placeholder="{{ trans('dashboard.general.reason_needed') }}" rows="3"
                            name="reasonAction"  id="reasonAction"></textarea>
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="text-danger" id="alertReasonAction"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center mt-5 p-0">
                    <button type="submit" class="btn btn-secondary mx-3">
                        {{ trans('dashboard.general.yes') }} </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard.general.no') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>


