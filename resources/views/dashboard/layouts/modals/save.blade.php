 <!-- Confirm Modal -->
 <div class="modal fade" id="successModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center p-0">
                <lottie-player autoplay loop mode="normal" src="{{asset('dashboardAssets/images/lottie/save.json')}}"
                    style="width: 55%; display: block; margin: 0 auto 1em">
                </lottie-player>
                <p>هل تريد إتمام عملية الحفظ؟</p>
            </div>
            <div class="modal-footer d-flex justify-content-center mt-5 p-0">
                <button type="button" class="btn btn-success mx-3" onClick='submitDetailsForm()'>موافق</button>
                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                    غير موافق
                </button>
            </div>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
    function submitDetailsForm() {

       $("#formId").submit();
    }
</script>
