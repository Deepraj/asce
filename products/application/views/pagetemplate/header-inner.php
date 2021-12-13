<?php
$MasterCustomerId = $this->session->userdata('MasterCustomerId');
$isAdmin = $this->session->userdata('isAdmin');
$all = $this->session->userdata('all');
$notsubcribed = $this->session->userdata('notsubcribed');
if (!empty($_REQUEST ['GUID'])) {
    $this->session->set_userdata('validlogin', $_REQUEST ['GUID']);
    $sesvalue = $this->session->userdata('validlogin');
    // echo "<pre>111";print_r($sesvalue);die;
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

if (!function_exists('DateInterval')) {

    function DateInterval($dateii, $userType) {
        $msg = "";
        $datetime1 = date_create($dateii);
        $datetime2 = date_create(date('Y-m-d'));
        $interval = $datetime2->diff($datetime1)->format("%a");
        // $interval=30;
        if ($interval == 30) {
            if ($userType == 'SINGLE') {
                $msg = "Your license will expire on '" . $dateii . "'.  <a href='" . base_url() . "'>Renew now <a>.";
                return $msg;
            } else {
                $msg = "Your institutions license will expire on license '" . $dateii . "'. Please contact ASCE Customer Service at <a href='mailto:ascelibrary@asce.org'>ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.";
                return $msg;
            }
        }
    }

}

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
        <link href="http://asce.adi-mps.com/asce/vendors/font-awesome/css/font-awesome.min.css?version={ver}"
              rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style-1.css " />

        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style-1.css " />
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>css/style.css " />
        <script type="text/javascript"
        src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
        <link  href="<?php echo base_url(); ?>asce/vendors/Zebra_DatePicker/css/Zebra_DatePicker.css"
               rel="stylesheet">
        <script type="text/javascript"  src='<?php echo base_url(); ?>asce/vendors/Zebra_DatePicker/js/Zebra_DatePicker.min.js'></script>
		<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0086/6567.js" async="async"></script>
        <style>
            .ui-widget-header, .ui-state-default, ui-select {
                background: #0c5fa8;
                /* background:#fff;
                 border: 1px solid #b9cd6d;
                 color: #FFFFFF;
                 font-weight: bold; */
            }
        </style>
    </head>
    <body>

        <nav class="navbar margin0 paddingTB10 header-bg ">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-12 logo">
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

                            if (($this->session->userdata('fullname') or $Ip) && (empty($LicenceInfo == 'SINGLE')) && (!empty($carporationame))) {
                                ?>
                                Access provided by

                                <?php
                                echo $carporationame;
                            }
                            ?>

                        </div>
                    </div>



                    <div id="adminHomePage" class="" >

                        <div class="headerbtn" >

                            <div class="report" title="MANAGE REPORTS">
                                <a href="<?php echo site_url(); ?>User_reports">
                                    <div class="icon"></div>
                                    <span>USAGE REPORT</span></a>
                            </div>
                            <div class="addReport" title="MANAGE PRODUCT">
                                <a href='<?php echo site_url(); ?>MultiLicenses'>
                                    <div class="icon"></div>
                                    <span style="">LICENSES</span>
                                </a>
                            </div>

<?php
if ($this->session->userdata('LicenceInfo') == "IPBASED") {
    ?>

                                <div class="addInstitute" title="MANAGE INSTITUTION" style=" width:127px;
                                     ">
                                    <a href='<?php echo site_url(); ?>IpuserAdmin'><div
                                            class="icon2"></div>
                                        <span style="">IP RANGES</span></a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="addInstitute" title="MANAGE INSTITUTION" style=" width:127px;
                                     ">
                                    <a href='<?php echo site_url(); ?>MuserAdmin'><div
                                            class="icon1"></div>
                                        <span style="">INVITED USERS</span></a>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="addBook" title="MANAGE BOOKS">
                                <a href='<?php echo site_url(); ?>ListBooks'><div class="icon"></div><span> BOOKS</span></a>
                            </div>








<!--<div class="addInstitute" title="ADD INSTITIUE" data-toggle="modal" data-target="#addInstPannel"><div class="icon"></div><span>ADD INSTITIUE</span></div>
        <div class="addUser" title="ADD USER" data-toggle="modal" data-target="#addUserPanel"><div class="icon"></div><span>ADD USER</span></div>
<div class="addBook" title="ADD BOOKS"><a href='<?php echo site_url('book_library/addbook'); ?>'><div class="icon"></div></a><span>ADD BOOKS</span></div>
        <div class="report" title="REPORTS"><div class="icon"></div><span>REPORTS</span></div>-->

                        </div>


                    </div>

















                    <div class="col-md-3 col-xs-12 text-right navbar-right">
                        <div class="col-md-12 text-center">		
<?php
if (empty($GUID) && !empty($Ip)) {
    ?>

                                <span class="myaccount "><a href="https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?ASCEURL=<?php echo base_url(); ?>product" class="color-secondary"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> LOGIN</a></span>
                                <span class="bookshelf bookshelf-heading"><a href='<?php echo base_url(); ?>product' class="color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span> 
    <?php
} elseif (empty($GUID) && empty($Ip)) {
    ?>
                                <span class="myaccount "><a href="https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?ASCEURL=<?php echo base_url(); ?>product" class="color-secondary"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> LOGIN</a></span>
                                <span class="bookshelf bookshelf-heading"><a href='<?php echo base_url(); ?>product' class="color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span>  
                                <?php
                            } else {
                                ?>
                                <div class="" style="float: right;">			  	
                                    <span class="myaccount dropdown   " ><a data-toggle="dropdown" href="javascript:;" class=" color-secondary dropdown-toggle" style="float: right;"><img src="<?php echo base_url(); ?>img/myaccount.png" /><br> My Account</a>
                                        <ul class="dropdown-menu dropdown-menu-right menuIcon"  style="padding:10px;width:504px; border: 2px solid #52B9DA; margin-top: 34px; margin-right: -34px;">
                                            <div class="panel-heading " style="    font-size: 22px;
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
                                                    <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                        LOGOUT</a>							
                                                <?php
                                            }
                                            ?>


    <?php
    //if (($LicenceInfo == 'SINGLE') && (!empty($email)) && (empty($Ip))) {
    if (($LicenceInfo == 'SINGLE') && (!empty($email))) {
        ?>
                                                    <div class="logout_btn pull-right"
                                                         style="margin-right: 10px;">
                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
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
                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                            LOGOUT</a>
                                                    </div>

                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                //echo $LicenceInfo; die;
                                                if ((empty($Ip)) && (!empty($email)) && ($LicenceInfo == 'IPBASED')) {
                                                    ?>
                                                    <p style="color: #000;  width: 100%;">
                                                        <span class="glyphicon "
                                                              aria-hidden="true"></span><a
                                                              href="<?php echo site_url(); ?>Dashboard/show_dashboard" >ADMIN</a>
                                                    </p>

                                                    <div class="logout_btn pull-right"
                                                         style="margin-right: 10px; margin-top: -30px; ">
                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
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
                                                if ((!empty($Ip)) && (!empty($email)) && (empty($LicenceInfo == 'SINGLE')) && (empty($isAdmin == 'subuser'))) {

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
    if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'MULTI')) && (!empty($isAdmin == 'subuser')) && (empty($notsubcribed == 'notsubcribed'))) {
        //  echo strtoupper($this->session->userdata('LabelipName'));
        ?>

                                                    <div class="logout_btn pull-right"
                                                         style="margin-right: 10px; margin-top: -30px;">
                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                            LOGOUT</a>
                                                    </div>

                                                <?php } ?>

                                                <?php
                                                if ((!empty($Ip)) && (!empty($email)) && (!empty($LicenceInfo == 'MULTI') or ! empty($LicenceInfo == 'IPBASED') or ! empty($LicenceInfo == 'SINGLE') ) && (!empty($isAdmin == 'subuser')) && (!empty($notsubcribed == 'notsubcribed'))) {
                                                    //  echo strtoupper($this->session->userdata('LabelipName'));
                                                    ?>

                                                    <div class="logout_btn pull-right"
                                                         style="margin-right: 10px; margin-top: -30px;">
                                                        <a href="<?php echo site_url(); ?>/LoginHandling/unset_session_data" class="btn btn-primary btn-sm">
                                                            LOGOUT</a>
                                                    </div>

    <?php } ?>




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

                                        </ul>

                                    </span>

                                    <span class="bookshelf bookshelf-heading"  style="
                                          float: left;
                                          margin-right: 16px;
                                          "><a href='<?php echo base_url(); ?>product' class=" color-secondary"><img src="<?php echo base_url(); ?>img/bookicon.png" /><br>Bookshelf</a></span> 




                                            <?php } ?>	

                            </div>

                            <div class="col-md-12 welcomeMsg color-white" style="
                                 margin-left: 6px;
                                 ">



<?php
if ($all) {
    //print_r($this->session->userdata);
    $isAdmin = $this->session->userdata('isAdmin');
    $fullname = $this->session->userdata('fullname');
    $LabelName = $this->session->userdata('LabelName');
    $LicenceInfo = $this->session->userdata('LicenceInfo');
    if ($isAdmin == "admin") {
        $name = $fullname;
    } elseif ($LicenceInfo == "SINGLE") {
        $name = $fullname;
    } else {
        $name = $LabelName;
    }


    echo"<span class='welcomeText' style='
    float: right; color:white;
'>Welcome &nbsp;" . $name . "</span>";
}
?>

                                </a></div>
                        </div>
                    </div>
                </div>
        </nav>


        <div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" id="popup-custom">

                    <div class="modal-header" id="mod-header">

                        <h4 class="modal-title" id="myModalLabel" style="color: white;">ASCE</h4>
                    </div>
                    <div class="modal-body">
                        <script>
                            function show_confirms(id) {
                                // alert(id);
                                // window.location='<?php echo site_url(); ?>/'+'MuserAdmin/deleteSubUser/'+id;
                                $('#myModals').modal('show');
                                //$("#okbtn").attr("data-dismiss",id);
                            }

                        </script>Usage Reports are not currently available. 
                    </div>
                    <div class="modal-footer" id="mod-footer">

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>

                    </div>

                </div>
            </div>
        </div>

        <style>
            .close_btn:before {
                height: 23px;
                width: 23px;
                background-image: url(http://asce.adi-mps.com/asce/themes/default/images/ASCE_Icons_lightblue.png);
                background-position: -124px -24px;
                display: inline-block;
                content: "";
                cursor: pointer;
            }


        </style>
