<div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <span class="svg svg-user-login"></span>
                    <span>ثبت نام / ورود</span>
                    <span><button type="button" data-dismiss="modal" class="close">&times;</button></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <!--  User Auth Tab -->
                    <div id="login-modal-auth-tab" class="auth-tab tab-pane active in divider-parent">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 login-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                                    <i class="svg-icons lock-icon"></i>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>عضو سایت هستید؟
                                    برای ثبت سفارش خود وارد شوید</p>
                                <button type="button" data-toggle="tab" data-target="#login-modal-login-tab" class="btn btn-custom blue next-in">
                                    ورود به حساب کاربری
                                    <span class="next-span"><i class="icon-chevron-left"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-divider hidden-sm hidden-xs"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 register-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                            <span class="circle-border">
                                <i class="svg-icons user-icon"></i>
                            </span>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>تازه وارد هستید؟
                                    برای ثبت سفارش خود ثبت‌نام کنید</p>
                                <button type="button" data-toggle="tab" data-target="#login-modal-register-tab" class="btn btn-custom green next-in">
                                    ساخت حساب کاربری
                                    <span class="next-span"><i class="icon-chevron-left"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  Login Tab -->
                    <div id="login-modal-login-tab" class="auth-tab login-tab tab-pane fade">
                        <div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 col-lg-push-2 col-md-push-2 col-sm-push-1 login-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                                    <i class="svg-icons lock-icon"></i>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>عضو سایت هستید؟
                                    برای ثبت سفارش خود وارد شوید</p>
                                <form>
                                    <p id="login-error" class="errorMessage"></p>
                                    <div class="form-group">
                                        <input type="text" class="form-control ltr text-right" placeholder="پست الکترونیک">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="کلمه عبور">
                                    </div>

                                    <button type="submit" class="btn btn-custom blue next-in pull-left" id="login-submit-btn">
                                        ورود به حساب کاربری
                                        <span class="next-span"><i class="icon-chevron-left"></i></span>
                                    </button>
                                </form>
                                <a href="#" class="gray-link pull-left text-left" data-toggle="tab" data-target="#login-modal-forget-password-tab">رمز عبور خود را فراموش کرده ام!</a>
                            </div>
                        </div>
                    </div>
                    <!--  Forget Tab -->
                    <div id="login-modal-forget-password-tab" class="auth-tab login-tab tab-pane fade">
                        <div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 col-lg-push-2 col-md-push-2 col-sm-push-1 login-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                                    <i class="svg-icons mail-icon"></i>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>رمز عبور خود را فراموش کرده اید؟
                                    لطفاً پست الکترونیکی خود را وارد کنید.</p>
                                <form onsubmit="return false;" id="login-modal-forgot-form" action="/users/login/forgetPassword" method="post">    <p id="login-modal-forgot-error" class="errorMessage"></p>
                                    <div class="form-group error">
                                        <input class="ltr text-right form-control" placeholder="پست الکترونیک" name="UsersForgetPassword[email]" id="UsersForgetPassword_email" type="text">        <div class="errorMessage" id="UsersForgetPassword_email_em_" style="">ایمیل نمی تواند خالی باشد.</div>    </div>
                                    <button type="submit" class="btn btn-custom blue next-in pull-left">
                                        بازیابی رمز عبور
                                        <span class="next-span"><i class="icon-chevron-left"></i></span>
                                    </button>
                                </form>    <a href="#" class="gray-link pull-left text-underline text-left" data-toggle="tab" data-target="#login-modal-login-tab" aria-expanded="true">بازگشت</a>
                            </div>
                        </div>
                    </div>
                    <!--  Register Tab -->
                    <div id="login-modal-register-tab" class="auth-tab register-tab tab-pane fade">
                        <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 col-lg-push-1 col-md-push-1 register-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
        <span class="circle-border">
            <i class="svg-icons user-icon"></i>
        </span>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>تازه وارد هستید؟
                                    برای ثبت سفارش خود ثبت‌نام کنید</p>
                                <div class="register-form">
                                    <form onsubmit="return false;" id="login-modal-users-register-modal-form" action="/users/account/register" method="post">        <div id="login-modal-register-error" class="errorMessage"></div>
                                        <div id="login-modal-register-success" class="successMessage"></div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 error">
                                            <input class="form-control" placeholder="نام و نام خانوادگی" name="Users[name_family]" id="Users_name_family" maxlength="100" type="text">
                                            <div class="errorMessage" id="Users_name_family_em_" style="display:none">نام و نام خانوادگی نمی تواند</div>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 success">
                                            <input class="form-control" placeholder="نام شرکت" name="Users[co_name]" id="Users_co_name" maxlength="100" type="text">            <div class="errorMessage" id="Users_co_name_em_" style="display:none"></div>        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" placeholder="تلفن همراه" name="Users[mobile]" id="Users_mobile" type="tel">            <div class="errorMessage" id="Users_mobile_em_" style="display:none"></div>        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control ltr text-right" placeholder="پست الکترونیک" name="Users[email]" id="Users_email" type="email">            <div class="errorMessage" id="Users_email_em_" style="display:none"></div>        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" placeholder="تلفن ثابت" name="Users[phone]" id="Users_phone" type="tel">            <div class="errorMessage" id="Users_phone_em_" style="display:none"></div>        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control select-picker">
                                                <option value="1">اینترنت</option>
                                                <option value="2">دوستان</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" placeholder="رمز عبور" name="Users[password]" id="Users_password" type="password">            <div class="errorMessage" id="Users_password_em_" style="display:none"></div>        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" placeholder="تکرار رمز عبور" name="Users[repeat_password]" id="Users_repeat_password" type="password">                    </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control" placeholder="کد امنیتی" name="Users[verifyCode]" id="Users_verifyCode" type="text">            <div class="errorMessage" id="Users_verifyCode_em_" style="display:none"></div>        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-nowrap captcha">
                                            <img id="yw1" src="/users/account/captcha?v=5a2272a625d91" alt=""><a id="yw1_button" href="/users/account/captcha?refresh=1">کد جدید ایجاد کنید</a>        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button type="submit" class="btn btn-custom green next-in pull-left">
                                                ساخت حساب کاربری
                                                <span class="next-span"><i class="icon-chevron-left"></i></span>
                                            </button>
                                            <a href="#" class="gray-link pull-right text-underline text-right" data-toggle="tab" data-target="#login-modal-login-tab" aria-expanded="true">ورود به حساب کاربری</a>        </div>
                                    </form>    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>