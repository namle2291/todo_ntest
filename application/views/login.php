<style>
    body {
        background: #9CECFB;
        background: -webkit-linear-gradient(to bottom, #0052D4, #65C7F7, #9CECFB);
        background: linear-gradient(to bottom, #0052D4, #65C7F7, #9CECFB);
        height: 100vh;
        font-family: Roboto;
    }

    .zalo-button {
        display: inline-block;
        width: 50px;
        height: 50px;
        background-color: #0068ff;
        text-align: center;
        border-radius: 50%;
        text-decoration: none;
        overflow: hidden;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .zalo-button img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .zalo-button:hover {
        background-color: #0057d9;
    }

    .login-box {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .login-box-left {
        min-width: 640px;
        height: 450px;
        padding: 60px;
        background: linear-gradient(135deg, rgba(141, 211, 236, 0.9) 0%, rgba(111, 192, 221, 0.98) 22%, rgba(111, 192, 221, 0.96) 33%, rgba(38, 129, 212, 0.9) 100%);
        box-shadow: -3px 19px 28px -8px rgba(0, 87, 167, 1);
    }

    .login-box-right {
        min-width: 550px;
        padding: 40px;
        background: #0057a7;
        box-shadow: -14px 14px 13px -8px rgba(0, 87, 167, 1);
        height: 526px;
    }

    .login-box-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }


    .form-box-submit {
        margin-top: 50px;
    }

    .form-box-control {
        border-bottom: 1px solid #fff;
        height: 40px;
        margin-bottom: 20px;
        position: relative;
    }

    .form-control-icon {
        position: absolute;
        left: 5px;
        top: 50%;
        transform: translateY(-50%);
        color: #fff;
    }

    .form-control-icon-show-password {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        color: #fff;
        cursor: pointer;
    }

    .form-control-input {
        width: 100%;
        height: 100%;
        border: none;
        background: none;
        outline: none;
        padding: 0 36px;
        color: white;
    }

    .form-control-input::placeholder {
        color: white;
    }

    .form-box-submit-button {
        width: 100%;
        height: 40px;
        text-align: center;
        color: #fff;
        background-color: #0c83e2;
        cursor: pointer;
        border: none;
        outline: none;
        color: #fff;
    }

    .form-login-actions {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .form-login-actions a {
        height: 40px;
    }
</style>


<div class="container">

    <div class="login-box">
        <div class="login-box-right">
            <div class="login-box-logo">
                <img width="50" src="<?= base_url("assets/images/logoDNCvien.png") ?>" alt="">
                <h5 class="m-0" style="color: #F9EA47; text-stroke: 2px #fff;">PHẦN MỀM QUẢN LÝ GIAO VIỆC HIỆU QUẢ</h5>
            </div>
            <form action="<?= base_url('auth/login') ?>" method="post" class="form-box-submit" autocomplete="off">
                <div class="form-box-control">
                    <span class="form-control-icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control-input" name="username" placeholder="Tên đăng nhập">
                </div>
                <div class="form-box-control">
                    <span class="form-control-icon">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </span>
                    <input type="password" class="form-control-input" name="password" placeholder="Mật khẩu">
                    <span class="form-control-icon-show-password">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
                <button class="form-box-submit-button">
                    Đăng nhập
                </button>
                <div class="form-login-actions">
                    <a href="<?php echo $login_url; ?>" class="btn btn-danger rounded-0 btn-user btn-block w-50">
                        <i class="fa fa-google"></i> Đăng nhập Google
                    </a>
                    <a href="<?= base_url('schedule') ?>" class="btn btn-success rounded-0 text-light w-50">
                        <i class="fa fa-search" aria-hidden="true"></i> Tra cứu lịch giảng dạy
                    </a>
                </div>
                <div class="mt-2">
                    <?php
                    $errors = $this->session->flashdata('errors');
                    if (!empty($errors)) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                echo '<div class="text-danger bg-light mt-1 px-2 text-truncate" style="font-size: 14px;">' . $error . '</div>';
                            }
                        } else {
                            echo '<div class="text-danger bg-light mt-1 px-2 text-truncate" style="font-size: 14px;">' . $errors . '</div>';
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Zalo Button -->
<div class="zalo">
    <a href="https://zalo.me/g/aheekk676" class="zalo-button zalo-button-fixed" target="_blank">
        <img src="<?= base_url() ?>/assets/images/LogoZalo.svg" alt="Zalo Icon" width="20" height="20">
    </a>
</div>

<script>
    $(document).ready(function() {
        let isShowPass = false;

        $("body").on("click", ".form-control-icon-show-password", function() {

            if (isShowPass) {
                $(this).children().attr("class", "fa fa-eye");
                $(".form-control-input[name='password']").attr("type", "password");
                isShowPass = false;
            } else {
                $(this).children().attr("class", "fa fa-eye-slash");
                $(".form-control-input[name='password']").attr("type", "text");
                isShowPass = true;
            }

        })
    })
</script>