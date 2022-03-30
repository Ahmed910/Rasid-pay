
<!-- UnArchiveModal -->
<div class="modal fade" id="modal_un_archive">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <form method="post" action="#" class="needs-validation" id="items" novalidate>@csrf
        <div class="modal-body text-center p-0">
          <lottie-player
            autoplay
            loop
            mode="normal"
            src="{{asset('dashboardassets/images/lottie/unarchive1.json')}}"
            style="width: 55%; display: block; margin: 0 auto 1em"
          >
          </lottie-player>
          <p>@lang("dashboard.general.want_restore")</p>
          <div class="mt-3">
                  <textarea
                    name="reasonAction"
                    class="form-control"
                    placeholder="الرجاء ذكر السبب*"
                    rows="3"
                    required
                  ></textarea>

            <div class="invalid-feedback">السبب مطلوب.</div>
          </div>
        </div>
        <div class="modal-footer justify-content-center mt-5 p-0">
          <button type="submit" class="btn btn-success mx-3">
            @lang("dashboard.general.yes")
          </button>
          <button
            type="button"
            class="btn btn-outline-success"
            data-bs-dismiss="modal"
          >
            @lang("dashboard.general.no")
          </button>
        </div>
      </form>
    </div>
  </div>
</div> `
