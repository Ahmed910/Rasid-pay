<!-- DeleteModal Modal -->
<div class="modal fade" id="modal_force_delete">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <form method="post" action="#" class="needs-validation" id="item" novalidate>@csrf @method('delete')
        <div class="modal-body text-center p-0">
          <lottie-player
            autoplay
            loop
            mode="normal"
            src="{{ asset('dashboardAssets/images/lottie/delete.json') }}""
          style="width: 55%; display: block; margin: 0 auto 1em"
          >
          </lottie-player>
          <p>@lang("dashboard.general.want_force_delete")</p>
        </div>
        <div class="mt-3">
                        <textarea class="form-control" placeholder="{{trans("dashboard.general.reason_needed")}}" rows="3" name="reasonAction"
                                  required></textarea>

          <div class="invalid-feedback">{{ trans('dashboard.general.reason_required') }} .</div>
        </div>
        <div class="modal-footer justify-content-center mt-5 p-0">
          <button type="submit" class="btn btn-danger mx-3">
            @lang("dashboard.general.yes")
          </button>
          <button
            type="button"
            class="btn btn-outline-danger"
            data-bs-dismiss="modal"
          >
            @lang("dashboard.general.no")          </button>
        </div>
      </form>
    </div>
  </div>
</div>
