 <!-- Back Modal -->
 <div class="modal fade" id="backModal">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-0">
             <div class="modal-body text-center p-0">
                 <lottie-player autoplay loop mode="normal" src="{{ asset('dashboardAssets/images/lottie/back.json') }}"
                     style="width: 55%; display: block; margin: 0 auto 1em">
                 </lottie-player>
                 <p>{{ trans('dashboard.general.want_back_without_saving') }}</p>
             </div>
             <div class="modal-footer d-flex justify-content-center mt-5 p-0">
                 <button type="button" class="btn btn-warning mx-3"
                     onclick="history.back()">{{ trans('dashboard.general.yes') }}</button>
                 <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                     {{ trans('dashboard.general.no') }} </button>
             </div>
         </div>
     </div>
 </div>
 <!-- END Back Modal -->
