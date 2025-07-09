 <div class="col-md-12 fv-row">
     <label class="required fs-6 fw-semibold mb-2">1. Judul</label>
     <textarea data-kt-autosize="true" id="judul" class="form-control" cols="10" rows="5"></textarea>
     <div class="text-muted mt-1">Sistem akan menganalisis menggunakan Cosine Similarity dan SVM</div>
 </div>

 {{-- <div class="col-md-6 mt-3">
     <button type="button" class="btn btn-primary" id="checkTitleBtn" onclick="checkTitle(event)">
         <span id="checkBtnText">Cek Ketersediaan Judul</span>
     </button>
 </div> --}}

 <div class="mt-3">
     <button type="button" id="checkTitleBtn" class="btn btn-primary" onclick="checkTitle(event)">
         <span id="checkBtnText">Analisis Judul</span>
     </button>
 </div>
 <div id="titleCheckResult" class="mt-3" style="display: none;">
     <!-- Hasil pengecekan akan muncul di sini -->
 </div>
