    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="login-container col-12 col-sm-12 col-md-6 offset-md-3">
                <h4 class="text-center text-white">LOGIN</h4>

                <form action="<?php echo base_url().'login/auth'?>" method="post" id="form-login">
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color: #fff"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" >
                        </div>
                        <span id="username-error" class="text-danger d-none">*username must not empty</span>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color: #fff"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                        </div>
                        <span id="password-error" class="text-danger d-none">*password must not empty</span>
                    </div>

                    <button class="btn btn-info form-control" id="btn-submit-login">LOGIN</button>

                <?php 
                    if($this->session->flashdata('msg')!=''){
                ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $this->session->flashdata('msg');?>
                    </div>
                <?php
                    }
                ?>
                </form>
            </div>
        </main>
    </body>

    <script type="text/javascript">
        $('#btn-submit-login').click(function(event) {
            event.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();

            if(username==''){
                $('#username-error').removeClass('d-none');
                $('#username-error').addClass('d-block');
            }
            else{
                $('#username-error').removeClass('d-block');
                $('#username-error').addClass('d-none');
            }

            if(password==''){
                $('#password-error').removeClass('d-none');
                $('#password-error').addClass('d-block');
            }
            else{
                $('#password-error').removeClass('d-block');
                $('#password-error').addClass('d-none');
            }

            if(username!='' && password!=''){
                $('#form-login').submit();
            }
        });
    </script>
</html>