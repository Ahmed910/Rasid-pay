      <div class="modal fade" id="notChangeModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
              
                <div class="modal-body text-center p-0">
                    <lottie-player autoplay loop mode="normal" src="{{asset('dashboardAssets/images/lottie/alert.json')}}"
                        style="width: 55%; display: block; margin: 0 auto 1em">
                    </lottie-player>
                    <p>لم يتم التعديل لكي يتم الحفظ</p>
                </div>
                <div class="modal-footer d-flex justify-content-center mt-5 p-0">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                         {{ trans('dashboard.general.yes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>



  <!-----------SCRIPT--------->
    <script>
        function submitDetailsForm() {
            $('#submit-form').prop('disabled', true);
           $("#formId").submit();
        }
    </script>
  <!-----------END SCRIPT--------->
