
  <div class="card py-7 px-7">
    <div class="row">
      <div class="col-12 col-md-6 mb-5">
        <label for="departmentName">اسم المجموعة</label>
        <input
          type="text"
          class="form-control"
          id="departmentName"
          placeholder="اسم المجموعة"
          required
        />
        <div class="invalid-feedback">اسم المجموعة مطلوب.</div>
      </div>
      <div class="col-12 col-md-6 mb-5">
        <label class="d-block" for="departmentStatus"
          >الحالة</label
        >
        <select
          class="form-control select2"
          id="departmentStatus"

        >
          <option selected disabled value="">اختر الحالة</option>
          <option>مفعلة</option>
          <option>معطلة</option>
        </select>

        <div class="invalid-feedback">الحالة مطلوبة.</div>
      </div>
      <div class="col-12 col-md-12 mb-5">
        <label for="mainDepartment">صلاحيات النظام</label>
        <select
          class="form-control select2"
          data-placeholder="اختر الصلاحيات"
          multiple="multiple"
          id="mainDepartment"
          required
        >
          <option>قسم البرمجيات</option>
          <option>قسم التصميم</option>
          <option>قسم الجودة</option>
          <option>قسم تحليل المتطلبات</option>
        </select>
        <div class="invalid-feedback">الصلاحيات مطلوبة.</div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 mb-5 text-end">
      <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#successModal"
        type="submit"
      >
        <i class="mdi mdi-content-save-outline"></i> حفظ
      </button>
      <a
        href="departments-record.html"
        class="btn btn-outline-primary"
        data-bs-toggle="modal"
        data-bs-target="#backModal"
      >
        <i class="mdi mdi-arrow-left"></i> عودة
      </a>
    </div>
  </div>
<!-- ROW CLOSED -->
