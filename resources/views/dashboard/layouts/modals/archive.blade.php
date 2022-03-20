<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-effect="effect-sign"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="staticBackdropLabel">أرشفة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <lottie-player autoplay loop mode="normal" src="{{asset('dashboardAssets/images/lottie/archive.json')}}"
                    style="width: 70%; display: block; margin: auto">
                </lottie-player>
                <p>هل تريد أرشفة هذا القسم؟</p>
                <div class="mt-3">
                    <textarea class="form-control" placeholder="الرجاء ذكر السبب" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">تأكيد</button>
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    إلغاء
                </button>
            </div>
        </div>
    </div>
</div>
