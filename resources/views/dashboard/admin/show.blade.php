@extends('dashboard.layouts.master')

@section('content')
    <!-- Row -->
    <div class="card py-7 px-7">
      <div class="row mb-5">
        <div class="col-12 col-md-3">
          <label>اسم المستخدم:</label>
          <p class="text-muted">محمد عبدالله</p>
        </div>
        <div class="col-12 col-md-3">
          <label>رقم المستخدم:</label>
          <p class="text-muted">569974</p>
        </div>
        <div class="col-12 col-md-3">
          <label>اسم القسم:</label>
          <p class="text-muted">قسم التصميم</p>
        </div>
        <div class="col-12 col-md-3">
          <label class="d-block" for="departmentName">الحالة:</label>
          <p
            class="badge bg-danger-opacity py-2 px-4"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-html="true"
            title="من  (7 شعبان 1443) <br><br> إلى  (14 شعبان 1443) "
          >
            معطل لفترة
          </p>
        </div>

        <div class="col-12 col-md-9 permissions">
          <label class="d-block" for="departmentName"
            >الصلاحيات المختارة:</label
          >
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
            معطل لفترة
            <i
              class="mdi mdi-clipboard-list"
               data-bs-toggle="popoverRoles"
                tabindex="1"
              data-bs-placement="right"
              data-bs-html="true"
              title="<span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل البيانات</span><span class='tooltipRole'>تعديل </span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>إضافة مستخدم </span><span class='tooltipRole'>تعديل الوظائف</span><span class='tooltipRole'>تعديل الصلاحيات</span><span class='tooltipRole'>تعديل المستخدمين</span>"
            ></i
          ></span>
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
            معطل لفترة
            </span>
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
            معطل لفترة
            </span>
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
            معطل لفترة
            <i
              class="mdi mdi-clipboard-list"
               data-bs-toggle="popoverRoles"
                tabindex="1"
              data-bs-placement="right"
              data-bs-html="true"
              title="<span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل البيانات</span><span class='tooltipRole'>تعديل </span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>إضافة مستخدم </span><span class='tooltipRole'>تعديل الوظائف</span><span class='tooltipRole'>تعديل الصلاحيات</span><span class='tooltipRole'>تعديل المستخدمين</span>"
            ></i
          ></span>
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
            معطل لفترة
            </span>
        </div>
        <div class="col-12 col-md-3 d-flex align-items-end">

          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              value=""
              id="flexCheckDefault"
              checked
              disabled
            />
            <label class="form-check-label" for="flexCheckDefault">
              إرسال رمز التحقق
            </label>
          </div>
        </div>
      </div>

    </div>
     <div class="row">
        <div class="col-12 text-end">
          <a href="user-add.html"
            class="btn btn-primary"
          >
            <i class="mdi mdi-square-edit-outline"></i> تعديل
          </a>
          <a
            href="users-record.html"
            class="btn btn-outline-primary"
          >
            <i class="mdi mdi-arrow-left"></i> عودة
          </a>
        </div>
      </div>
    <!-- End Row -->
      <label>الحركة التاريخية</label>
      <div class="table-responsive p-1">
        <table
          id="historyTable"
          class="table table-bordered text-wrap shadow-sm bg-body key-buttons historyTable"
        >
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">تم بواسطة</th>
              <th class="border-bottom-0">اسم القسم</th>
              <th class="border-bottom-0">تاريخ النشاط</th>
              <th class="border-bottom-0">النشاط</th>
              <th class="border-bottom-0">السبب</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img
                      src="https://picsum.photos/seed/picsum/100"
                      width="25"
                      class="avatar brround cover-image"
                      alt="..."
                      data-toggle="popoverIMG"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">هشام أشرف</div>
                </div>
              </td>
              <td>إدارة المالية</td>
              <td>20 يناير 2022</td>
              <td class="text-center">
                <span class="badge bg-primary-opacity py-2 px-4"
                  >أرشفة</span
                >
              </td>
              <td>
                <p>
                  هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                  لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                  .
                </p>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img
                      src="https://picsum.photos/seed/picsum/100"
                      width="25"
                      class="avatar brround cover-image"
                      alt="..."
                      data-toggle="popoverIMG"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">محمد رمضان</div>
                </div>
              </td>
              <td>إدارة المحاسبة</td>
              <td>20 يناير 2022</td>
              <td class="text-center">
                <span class="badge bg-warning-opacity py-2 px-4"
                  >تعديل</span
                >
              </td>
              <td>
                <p>
                  هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                  لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                  .
                </p>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img
                      src="https://picsum.photos/seed/picsum/100"
                      width="25"
                      class="avatar brround cover-image"
                      alt="..."
                      data-toggle="popoverIMG"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">محمد تريكة</div>
                </div>
              </td>

              <td>إدارة المالية</td>
              <td>20 يناير 2022</td>
              <td class="text-center">
                <span class="badge bg-default-opacity py-2 px-4"
                  >معطل</span
                >
              </td>
              <td>
                <p>
                  هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                  لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                  .
                </p>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img
                      src="https://picsum.photos/seed/picsum/100"
                      width="25"
                      class="avatar brround cover-image"
                      alt="..."
                      data-toggle="popoverIMG"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">طه محمد</div>
                </div>
              </td>

              <td>إدارة المالية</td>
              <td>20 يناير 2022</td>
              <td class="text-center">
                <span class="badge bg-primary-opacity py-2 px-4"
                  >أرشفة</span
                >
              </td>
              <td>
                <p>
                  هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                  لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                  .
                </p>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img
                      src="https://picsum.photos/seed/picsum/100"
                      width="25"
                      class="avatar brround cover-image"
                      alt="..."
                      data-toggle="popoverIMG"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3">أحمد اسماعيل</div>
                </div>
              </td>

              <td>إدارة التصميم</td>
              <td>20 يناير 2022</td>
              <td class="text-center">
                <span class="badge bg-success-opacity py-2 px-4"
                  >مفعل</span
                >
              </td>
              <td>
                <p>
                  هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء
                  لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي
                  .
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    <!-- Row -->
@endsection
@include('dashboard.admin.show-script')
