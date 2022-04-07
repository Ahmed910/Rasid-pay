     <!-- Confirm Modal -->
      <div class="modal fade" id="successModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-0">
                    <lottie-player autoplay loop mode="normal" src="{{asset('dashboardAssets/images/lottie/save.json')}}"
                        style="width: 55%; display: block; margin: 0 auto 1em">
                    </lottie-player>
                    <p>{{ trans('dashboard.general.want_saving') }}</p>
                </div>
                <div class="modal-footer d-flex justify-content-center mt-5 p-0">
                    <button type="button" id="submit-form" class="btn btn-primary mx-3" onclick='submitDetailsForm()'>{{ trans('dashboard.general.yes') }}</button>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                         {{ trans('dashboard.general.no') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Confirm Modal -->


  <!-----------SCRIPT--------->
    <script language="javascript" type="text/javascript">
        function submitDetailsForm() {
            $('#submit-form').prop('disabled', true);
           $("#formId").submit();
        }
    </script>
  <!-----------END SCRIPT--------->
