 <div class="container">
    <div class="row">
        <form class="form-signin mg-btm" method="post" action="admin_lkje5sjwjpzkhdl42mscpi.php">
			<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
        <h3 class="heading-desc">
        Are you a Meilleurescpi.com ?</h3>
        <div class="main">  
            <label>Email</label>    
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="email" class="form-control" name="login" placeholder="mail@gmail.com" autofocus="">
            </div>
            <label>Mot de passe &nbsp;&nbsp;</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
    
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    &nbsp;
                </div>
                <div class="col-xs-6 col-md-6 pull-right">
                    <button type="submit" class="btn btn-large btn-success pull-right">SIGN IN</button>
                </div>
            </div>
        </div>
        
        <span class="clearfix"></span>

        <div class="login-footer">
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <div class="left-section">
                        
                    </div>
                </div>
                <div class="col-xs-6 col-md-6 pull-right">
                </div>
            </div>
        </div>
      </form>
    </div>
</div>
<div class="img-right-bottom">
    <img src="<?=$this->getPath()?>img/logo-meilleurescpi.png" alt="logo MeilleureSCPI.com" height="85" width="192">
</div>
