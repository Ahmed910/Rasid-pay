<div class="app-header header sticky">
  <div class="container-fluid main-container">
    <div class="d-flex">
      <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
      <!-- sidebar-toggle-->
      <a class="logo-horizontal" href="index.html">
        <img src="{{ asset('dashboardAssets/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo" />
        <img src="{{ asset('dashboardAssets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo" />
      </a>
      <!-- LOGO -->

      <div class="d-flex order-lg-2 ms-auto header-right-icons">
        <!-- SEARCH -->
        <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false"
            aria-label="Toggle navigation">
          <span class="navbar-toggler-icon fe fe-more-vertical"></span>
        </button>
        <div class="navbar navbar-collapse responsive-navbar p-0">
          <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            <div class="d-flex order-lg-2">
              <!-- Notifications -->
              <div class="dropdown d-flex notifications">
                <a class="nav-link icon" data-bs-toggle="dropdown"><i class="fe fe-bell"></i><span class="pulse"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <div class="drop-heading border-bottom">
                    <div class="d-flex">
                      <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">
                        الإشعارات
                      </h6>
                    </div>
                  </div>
                  <div class="notifications-menu">
                    <a class="dropdown-item d-flex" href="notify-list.html">
                      <div class="mt-1">
                        <h5 class="notification-label mb-1">
                          رسالة جديدة من محمد رمضان
                        </h5>
                        <span class="notification-subtext">منذ 3 أيام</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="notify-list.html">
                      <!-- <div
                    class="me-3 notifyimg bg-secondary brround box-shadow-secondary"
                  >
                    <i class="mdi mdi-check-circle-outline"></i>
                  </div> -->
                      <div class="mt-1">
                        <h5 class="notification-label mb-1">
                          تم قبول طلبك بنجاح
                        </h5>
                        <span class="notification-subtext">منذ 2 ساعة</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="notify-list.html">
                      <!-- <div
                    class="me-3 notifyimg bg-success-opacity brround box-shadow-success"
                  >
                    <i class="fe fe-shopping-cart"></i>
                  </div> -->
                      <div class="mt-1">
                        <h5 class="notification-label mb-1">
                          تم إضافة صلاحيات جديدة لك
                        </h5>
                        <span class="notification-subtext">منذ 30 ثانية</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="notify-list.html">
                      <!-- <div
                    class="me-3 notifyimg bg-pink brround box-shadow-pink"
                  >
                    <i class="fe fe-user-plus"></i>
                  </div> -->
                      <div class="mt-1">
                        <h5 class="notification-label mb-1">
                          تم إدراج قسم جديد
                        </h5>
                        <span class="notification-subtext">منذ 1 يوم</span>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-divider m-0"></div>
                  <a href="notify-list.html" class="dropdown-item text-center p-3 text-muted">مشاهدة
                    كل
                    الإشعارات</a>
                </div>
              </div>
              <!-- MESSAGE-BOX -->
              <div class="dropdown d-flex message">
                <a class="nav-link icon text-center" data-bs-toggle="dropdown">
                  <i class="mdi mdi-email-outline"></i><span class="pulse-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <div class="drop-heading border-bottom">
                    <div class="d-flex">
                      <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">
                        لديك 5 رسائل جديدة
                      </h6>
                    </div>
                  </div>
                  <div class="message-menu">
                    <a class="dropdown-item d-flex" href="chat.html">
                      <span class="avatar avatar-md brround me-3 align-self-center cover-image" data-bs-image-src="https://picsum.photos/200"></span>
                      <div class="w-80">
                        <div class="d-flex">
                          <h5 class="mb-1">محمد رمضان</h5>
                          <small class="text-muted ms-auto text-end">
                            6:45 صباحاً
                          </small>
                        </div>
                        <span>افتح الاسلاك</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="chat.html">
                      <span class="avatar avatar-md brround me-3 align-self-center cover-image" data-bs-image-src="https://picsum.photos/200"></span>
                      <div class="w-80">
                        <div class="d-flex">
                          <h5 class="mb-1">محمد تريكة</h5>
                          <small class="text-muted ms-auto text-end">
                            10:35 صباحاً
                          </small>
                        </div>
                        <span>عندنا اجتماع الساعة 3</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="chat.html">
                      <span class="avatar avatar-md brround me-3 align-self-center cover-image" data-bs-image-src="https://picsum.photos/200"></span>
                      <div class="w-80">
                        <div class="d-flex">
                          <h5 class="mb-1">احمد اسماعيل</h5>
                          <small class="text-muted ms-auto text-end">
                            2:17 مساءاً
                          </small>
                        </div>
                        <span>ارفع اخر تعديلات</span>
                      </div>
                    </a>
                    <a class="dropdown-item d-flex" href="chat.html">
                      <span class="avatar avatar-md brround me-3 align-self-center cover-image" data-bs-image-src="https://picsum.photos/200"></span>
                      <div class="w-80">
                        <div class="d-flex">
                          <h5 class="mb-1">طه محمد</h5>
                          <small class="text-muted ms-auto text-end">
                            7:55 مساءاً
                          </small>
                        </div>
                        <span>فتحي عاوز يجي تيم الفرونت</span>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-divider m-0"></div>
                  <a href="javascript:void(0)" class="dropdown-item text-center p-3 text-muted">مشاهدة
                    كل
                    الرسائل</a>
                </div>
              </div>
              <!-- SIDE-MENU -->
              <div class="dropdown d-flex profile-1">
                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                  <div class="d-flex align-items-center profile">
                    <div class="flex-shrink-0">
                      <img src="https://picsum.photos/200" alt="profile-user" class="avatar profile-user brround cover-image" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p>هشام أشرف</p>
                      <span>front-end developer</span>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <div class="drop-heading">
                    <div class="text-center">
                      <h5 class="text-dark mb-0 fs-14 fw-semibold">
                        هشام أشرف
                      </h5>
                      <small class="text-muted">Front-End Developer</small>
                    </div>
                  </div>
                  <div class="dropdown-divider m-0"></div>
                  <a class="dropdown-item" href="profile.html">
                    <i class="mdi mdi-account-outline"></i> الملف الشخصي
                  </a>
                  <a class="dropdown-item" href="email-inbox.html">
                    <i class="mdi mdi-email-outline"></i> الرسائل
                    <span class="badge bg-danger-opacity float-end">5</span>
                  </a>
                  <a class="dropdown-item" href="lockscreen.html">
                    <i class="mdi mdi-cog-outline"></i> الإعدادات
                  </a>
                  @auth
                  {!! Form::open(['route' => 'dashboard.logout' , 'method' => 'POST' , 'id' => 'logout_form']) !!}

                  <a class="dropdown-item" onclick="document.getElementById('logout_form').submit();">
                    <i class="mdi mdi-logout-variant"></i>
                    تسجيل خروج
                  </a>
                  {!! Form::close() !!}
                  @endauth
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
