<?php





$MasterCustomerId = $this->session->userdata('MasterCustomerId');
$isAdmin = $this->session->userdata('isAdmin');
$all = $this->session->userdata('all');
$validsubscription=$this->session->userdata('validsubscription');
$notsubcribed = $this->session->userdata('notsubcribed');

if (!empty($_REQUEST ['GUID'])) {
    $this->session->set_userdata('validlogin', $_REQUEST ['GUID']);
    $sesvalue = $this->session->userdata('validlogin');
//     echo "<pre>111";print_r($sesvalue);die;
    $GUID = $sesvalue;
} else {
    $sesvalue = $this->session->userdata('validlogin');

    if (!empty($sesvalue)) {
        $GUID = $sesvalue;
    } else {
        $GUID = "";
    }
}
$Ip = $this->session->userdata('ip');
$LicenceInfo = $this->session->userdata('LicenceInfo');
// $this->DateInterval($LicenceInfo);
$email = $this->session->userdata('email');

// $lvar = "http://" . $_SERVER ['HTTP_HOST'];
?>
<!-- saved from url=(0057)http://asce.adi-mps.com/asce_service/index.php/auth/login -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ASCE 7 Online</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans"
              rel="stylesheet">
        <script type="text/javascript"
        src="<?php echo base_url(); ?>js/jquery-1.11.3.min.js?version={ver}"></script>
        <script type="text/javascript"
        src="<?php echo base_url(); ?>js/bootstrap.min.js?version={ver}"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/main.js "></script>
        <script type="text/javascript"
        src="<?php echo base_url(); ?>js/jquery.form.js "></script>
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css?version={ver}"
              rel="stylesheet">

        <link
            href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
            rel="stylesheet">
        <link href="<?php echo base_url(); ?>asce/vendors/font-awesome/css/font-awesome.min.css?version={ver}"
              rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style-1.css " />

        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style1.css " />
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style.css " />
        <script type="text/javascript"
		
        src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
		<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0086/6567.js" async="async"></script>
        <style>
            .ui-widget-header, .ui-state-default, ui-select {
                background: #0c5fa8;
                /* background:#fff;
                 border: 1px solid #b9cd6d;
                 color: #FFFFFF;
                 font-weight: bold; */
            }
            .sess{
                color: white;
            }
        </style>
        <!-- Google Tag Manager --> 
        <noscript>
    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-5BHNG6L"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push(
                    {'gtm.start': new Date().getTime(), event: 'gtm.js'}
            );
            var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                    '//www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5BHNG6L');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <nav class="navbar margin0 paddingTB10 header-bg ">
        <div class="container">

            <div class="sess">
                <?php
                $currentIP = $this->input->ip_address(); // Will Get Current IP of user
                $currentIP = trim($currentIP);
                $sessid = session_id();
                //echo "IP==>"  .$currentIP."&nbsp;&nbsp;SessionID==>".$sessid=session_id(); 
                ?>
            </div>
            <div class="row">

                <div class="col-md-6 col-xs-12 logo">
                    <a class="" href="<?php echo base_url(); ?>product"><img src="<?php echo base_url(); ?>img/logo.png" /></a>
                    <div class="col-md-12 nopadding color-secondary">
<?php
$carporationame = $this->session->userdata('carporationame');
//print_r($_SESSION);
if (($this->session->userdata('fullname') or $Ip) && (empty($LicenceInfo == 'SINGLE')) && empty($carporationame)) {
    ?>
                            Access provided by

                            <?php
                            $value1 = trim($this->session->userdata('fullname'));
                            $value2 = trim($this->session->userdata('LabelipName'));
                            // echo !empty($value1)?$value1:$value2;
                            // echo $value2; 
                            if (empty($value1)) {
                                echo $value2;
                            } else {
                                echo $value1;
                            }
                        }

                        //  echo $LicenceInfo; 

                        if (($this->session->userdata('fullname') or $Ip) && (!empty($LicenceInfo == 'SINGLE')) && (!empty($carporationame))) {
                            ?>	
                            <?php
                            if ($Ip) {
                                ?>

                                Access provided by 
                                <?php
                            }
                            ?>

                            <?php
                            $value1 = $this->session->userdata('fullname');
                            $value2 = $this->session->userdata('LabelipName');
                            echo!empty($value1) ? $value2 : $value1;
                        }

                        if (($this->session->userdata('fullname') or $Ip) && (!empty($LicenceInfo == 'SINGLE')) && (empty($carporationame))) {
                            ?>	
                            <?php
                            if ($Ip) {
                                ?>

                                Access provided by 
                                <?php
                            }
                            ?>

                            <?php
                            $value1 = $this->session->userdata('fullname');
                            $value2 = $this->session->userdata('LabelipName');
                            echo!empty($value1) ? $value2 : $value1;
                        }

                        if (($this->session->userdata('fullname') or $Ip) && (empty($LicenceInfo == 'SINGLE')) && (!empty($carporationame))) {
                            ?>
                            Access provided by

                            <?php
                            echo $carporationame;
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 text-right navbar-right">
                    <div class="col-md-12 text-center">		
<?php
if (empty($GUID) && !empty($Ip)) {
    ?>

                            <span class="myaccount "><a href="https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?ASCEURL=<?php echo base_url(); ?>product" class="color-secondary"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> LOGIN</a></span>
                            <?php  if ( $validsubscription=='Y') { ?>
                                <span class="bookshelf bookshelf-heading"><a href='<?php echo base_url(); ?>product' class="color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span>
                            <?php }?>
                            <span class="bookshelf"><a href='<?php echo base_url(); ?>store' class="color-secondary"><img src="<?php echo base_url(); ?>img/store.png" /><br>Store</a></span>
                             
                            <?php
                        } elseif (empty($GUID) && empty($Ip)) {
                            ?>
                            <span class="myaccount "><a href="https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?ASCEURL=<?php echo base_url(); ?>product" class="color-secondary"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> LOGIN</a></span>
                            <!-- <span class="bookshelf "><a href='<?php echo base_url(); ?>product' class="color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span>   -->

                            <span class="bookshelf"><a href='<?php echo base_url(); ?>store' class="color-secondary"><img src="<?php echo base_url(); ?>img/store.png" /><br>Store</a></span>  

                            <?php
                        } else {
                            ?>
                            <div class="">			  	
                                <span class="myaccount dropdown   " ><a data-toggle="dropdown" href="#myaccount" class=" color-secondary dropdown-toggle"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> My Account</a>
                                    <ul id="toggelb" class="dropdown-menu dropdown-menu-right menuIcon"  style="padding:10px;width:504px; border: 2px solid #52B9DA; margin-top: 34px; margin-right: -35px;">
                                        <div id="toggelb" class="panel-heading " style="    font-size: 22px;
                                             background: transparent;
                                             padding-bottom: 10px;
                                             font-family: sans-serif ;
                                             font-weight: 500;"><span class="fa close_btn pull-right" title="CLOSE"></span>MY ACCOUNT</div>
                                        <span class="glyphicon glyphicon-user" style="font-size: 20px;padding-right: 10px;"
                                              aria-hidden="true"></span>


                                        <strong>Logged in as:</strong> <?php
                            if ($this->session->userdata('LabelName') or $Ip) {
                                $value1 = $this->session->userdata('LabelName');
                                $value2 = $this->session->userdata('LabelipName');
                                echo!empty($value1) ? $value1 : $value2;
                                //echo  $this->session->userdata('LabelipName');
                            }
                            ?>							


                                        <p><br> <a
                                                href='
                                                https://asce770prodebiz.personifycloud.com/PersonifyEbusiness/My-Account.aspx'>Manage My Account</a>&nbsp;</p>


    <?php
    //if (($LicenceInfo == 'MULTI') && (!empty($email)) && $isAdmin == 'admin' && (empty($Ip))) {
    if (($LicenceInfo == 'MULTI') && (!empty($email)) && $isAdmin == 'admin' ) {
        ?>

                                            <p> 
                                                <a href="<?php echo site_url(); ?>Dashboard/show_dashboard" >ADMIN</a></p>			
                                            <div class="logout_btn pull-right"
                                                 style="margin-right: 10px; margin-top: -30px; ">
                                                <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                    LOGOUT</a>							
                                            <?php
                                        }
                                        ?>


    <?php
    //if (($LicenceInfo == 'SINGLE') && (!empty($email)) && (empty($Ip))) {
    if(($LicenceInfo == 'SINGLE') && (!empty($email))) {
        ?>
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                            <?php
                                        }
                                        ?>	

    <?php
    if (($LicenceInfo == 'MULTI') && (empty($email)) && (empty($Ip))) {
        ?>
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px;margin-top: -30px; ">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                                <?php
                                            }
                                            ?>	

                                            <?php
                                            if (($LicenceInfo == 'MULTI') && (!empty($email)) && $isAdmin == 'subuser' && (empty($Ip))) {
                                                ?>						  						     
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px;margin-top: -30px; ">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                                <?php
                                            }
                                            ?>


                                            <?php
                                            //echo $LicenceInfo; die;
                                            if ((empty($Ip)) && (!empty($email)) && ($LicenceInfo == 'IPBASED') && $isAdmin == 'admin') {
                                                ?>
                                                <p style="color: #000;  width: 100%;">
                                                    <span class="glyphicon "
                                                          aria-hidden="true"></span><a
                                                          href="<?php echo site_url(); ?>/Dashboard/show_dashboard" >ADMIN</a>
                                                </p>

                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px; ">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                                <?php
                                            }
                                            ?>

    <?php
    //echo $LicenceInfo; die;
    if ((empty($Ip)) && (!empty($email)) && ($LicenceInfo == 'IPBASED') && $isAdmin == 'subuser') {
        ?>


                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px; ">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/sessiondestroy" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                                <?php
                                            }
                                            ?>




    <?php
    //echo $LicenceInfo; die;
    if (empty($LicenceInfo == 'IPBASED' or $LicenceInfo == 'SINGLE' or $LicenceInfo == 'MULTI')) {
        ?>
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px; ">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>
                                                <?php
                                            }
                                            ?>


                                            <?php
                                            if (empty($Ip)) {
                                                $this->session->unset_userdata('LabelipName');
                                                //echo"dsdsd";
                                                ?>

    <?php } ?>







    <?php
    if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'IPBASED')) && (!empty($isAdmin == 'admin')) && (empty($notsubcribed == 'notsubcribed'))) {
        //  echo strtoupper($this->session->userdata('LabelipName'));
        ?>
                                                <p style="color: #000;  width: 100%;">
                                                    <span class="glyphicon "
                                                          aria-hidden="true"></span> <a
                                                          href="<?php echo site_url(); ?>Dashboard/show_dashboard" >ADMIN</a>
                                                </p>
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

                                            <?php } ?>



                                            <?php
                                            if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'IPBASED')) && (!empty($isAdmin == 'subuser')) && (empty($notsubcribed == 'notsubcribed'))) {
                                                //  echo strtoupper($this->session->userdata('LabelipName'));
                                                ?>
                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

    <?php } ?>







                                            <?php
                                            if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'MULTI')) && (!empty($isAdmin == 'subuser')) && (empty($notsubcribed == 'notsubcribed'))) {
                                                //  echo strtoupper($this->session->userdata('LabelipName'));
                                                ?>

                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>

    <?php } ?>

                                            <!---	<?php
    if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'MULTI') or ! empty($LicenceInfo == 'IPBASED') or ! empty($LicenceInfo == 'SINGLE') ) && (!empty($isAdmin == 'subuser')) && (!empty($notsubcribed == 'notsubcribed'))) {
        //  echo strtoupper($this->session->userdata('LabelipName'));
        ?>
                                                
                                                                                 <div class="logout_btn pull-right"
                                                                        style="margin-right: 10px; margin-top: -30px;">
                                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                                                 LOGOUT</a>
                                                                </div>
                                                                
    <?php } ?>--->




    <?php
    if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'SINGLE')) && (empty($notsubcribed == 'notsubcribed'))) {

        //  echo strtoupper($this->session->userdata('LabelipName')); 
        ?>

                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>
    <?php } ?>	



    <?php
    if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'SINGLE')) && (!empty($notsubcribed == 'notsubcribed'))) {

        //  echo strtoupper($this->session->userdata('LabelipName')); 
        ?>

                                                <div class="logout_btn pull-right"
                                                     style="margin-right: 10px; margin-top: -30px;">
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>
                                                </div>
    <?php } ?>								

                                    </ul>

                                </span>

                                <?php

    if ( $validsubscription=='Y') { ?>
                                <span class="bookshelf bookshelf-heading"><a href='<?php echo base_url(); ?>product' class=" color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span> 
                            <?php } ?>
                                <span class="bookshelf"><a href='<?php echo base_url(); ?>store' class="color-secondary"><img src="<?php echo base_url(); ?>img/store.png" /><br>Store</a></span>
                            </div>				

                                        <?php } ?>	

                    </div>
                    
                    <div class="col-md-12 welcomeMsg color-white">

<?php
if ($all) {
    //print_r($this->session->userdata); die;
    $isAdmin = trim($this->session->userdata('isAdmin'));
    $fullname = trim($this->session->userdata('fullname'));
    $LabelName = trim($this->session->userdata('LabelName'));
    if(!empty($this->session->userdata('LicenceInfo'))){
    $LicenceInfo = trim($this->session->userdata('LicenceInfo'));
    }
    if (($isAdmin == "admin") && !empty($fullname)) {
        $name = $fullname;
    } elseif ($LicenceInfo == "SINGLE") {
        if ($fullname == "") {
            $name = $LabelName;
        } else {
            $name = $fullname;
        }
    } else if ($isAdmin == "admin" && empty($fullname)) {
        //echo"fgdg"; die;
        $name = $LabelName;
    } else {
        //echo "1"; die;
        $name = $LabelName;
    }


    echo"<span class='welcomeText'>Welcome &nbsp;</span>" . $name;
}
?>

                        </a></div>
                </div>
            </div>
        </div> 
    </nav>
  
    <style>
        .close_btn:before {
            height: 23px;
            width: 23px;
            background-image: url(http://asce.mpstechnologies.com/asce/themes/default/images/ASCE_Icons_lightblue.png);
            background-position: -124px -24px;
            display: inline-block;
            content: "";
            cursor: pointer;
        }
    </style>
   
   
    
    
    <script>
        window.addEventListener("beforeunload", function (e) {
            $.ajax({
                type: "POST",
                url: "http://localhost:8080/asce-project/products/index.php/product/test",
                //data:{classname:e},
                async: false
            });
            return;
        });


        $(document).ready(function () {
            $(".myaccount a").click(function () {
                $("#toggelb").toggle();
            });
        });
    </script>



