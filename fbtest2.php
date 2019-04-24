<?php
/**
 * Created by Sha Hussain.
 * User: GCCOE_01
 * Date: 26-08-2017
 * Time: 02:52 PM
 */
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fb Test page</title><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<br>

<div class="container">
    <div class='row'>
        <h1 class="text-center">Transaction</h1>
        <hr class="featurette-divider"></hr>
    </div>
    <div class='row'>
        <form  role="form" method="post" action="api/mst_api.php">
            <div class='col-md-2'></div>
            <div class='col-md-8'>
                <div class='form-row'>
                    <div class='col-xs-6 form-group required'>
                        <label class='control-label'>UniqueId <span class="text-danger">*</span></label>
                        <input class='form-control' type='text' name="UniqueId" value='' disabled>
                    </div>
                   <div class='col-xs-6 form-group required'>
                    <label class='control-label'>AppType <span class="text-danger">*</span></label>
                    <select  class='form-control' name="AppType">
                        <option value="ME">Merchant ID</option>
                        <option value="ST">Store ID</option>
                        <option value="TM">Terminal ID</option>
                    </select>
                </div>
                </div>
                <div class='form-row'>
                     <div class='col-xs-6 form-group required'>
                    <label class='control-label'>Action <span class="text-danger">*</span></label>
                    <select  class='form-control'name="Action">
                        <option value="1">Add </option>
                        <option value="2">Modify</option>
                        <option value="3">Block</option>
                    </select>
					</div>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>SuperInst Name</label>
                        <input class='form-control' type='text' name="superinstname" value="mmm inst">
                    </div>
                </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>SuperInst</label>
                        <input class='form-control' type='number' name="superinst" value='11'>
                    </div>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>InstName</label>
                        <input class='form-control' type='text' name="instname" value='ff new inst'>
                    </div>
					</div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>InstID</label>
                        <input class='form-control' type='number' name="instid" value='22'>
                    </div>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>SuperMercName</label>
                        <input class='form-control' type='text' name="supermercname" value='merch test'>
                    </div>
                    </div>
                <div class='form-row'>
                    <div class='col-xs-6 form-group required'>
                        <label class='control-label'>SuperMerc <span class="text-danger"></span></label>
                        <input class='form-control' type='number' name="supermerc" value='33'>
                    </div>
                    <div class='col-xs-6 form-group'>
                        <label class='control-label'>SponorbankName</label>
                        <input class='form-control' type='text' name="sponsorname" value="SBI">
                    </div>
                </div>
				<div class='form-row'>
                    <div class='col-xs-6 form-group required'>
                        <label class='control-label'>SponsorbankID <span class="text-danger"></span></label>
                        <input class='form-control' type='text' name="sponsorbankid" value='44'>
                    </div>
                    
                </div>
            </div>
            <div class='col-md-2'></div>
    </div>
    <h4 class="text-center">Merchant</h4>
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MerchantName</label>
                    <input class='form-control' type='text' name="merchantname">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Merchant</label>
                    <input class='form-control' type='number' name="merchantid" required>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_STATUS</label>
                    <input class='form-control' type='number' name="mso_status" value="1">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_STATUS_DATE</label>
                    <input class='form-control' type='text' value='2017-01-01' name="mso_status_date">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_MERCHANT_ID</label>
                    <input class='form-control' type='text' name="mso_merchant_id">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_REGION</label>
                    <input class='form-control' type='text' name="mso_region" value="M-region">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TYPE</label>
                    <input class='form-control' type='text' name="mso_type" value="sales">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_BUSINESS_NATURE</label>
                    <input class='form-control' type='text' name="mso_business_nature" value="commercial">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_MCC</label>
                    <input class='form-control' type='text' name="mso_mcc" value="mcc">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MDS_SCHG_FLAT</label>
                    <input class='form-control' type='text' name="mds_schg_flat" value="1">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MDS_SCHG_PERCENT</label>
                    <input class='form-control' type='text' name="mds_schg_percent" value="percent">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TCC</label>
                    <input class='form-control' type='text' name="mso_tcc" value="t">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_RES_ADDRESS</label>
                    <input class='form-control' type='text' name="mso_res_address" value="yyyy area">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_RES_CTY</label>
                    <input class='form-control' type='text' name="mso_res_cty" value="CHN">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_RES_STATE</label>
                    <input class='form-control' type='text' name="mso_res_state" value="TN">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_RES_PIN</label>
                    <input class='form-control' type='text' name="mso_res_pin" value="5522">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_CONT_NAME </label>
                    <input class='form-control' type='text' name="mso_cont_name" value="RRR">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_CONT_MOBILE  </label>
                    <input class='form-control' type='text' name="mso_cont_mobile" value="966663300">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_CONT_ALT_MOBILE</label>
                    <input class='form-control' type='text' name="mso_cont_alt_mobile" value="966663322">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_CONT_TELEPHONE</label>
                    <input class='form-control' type='text' name="mso_cont_telephone" value="966663323">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_CONT_EMAIL</label>
                    <input class='form-control' type='text' name="mso_cont_email" value="email2@email.com">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_MAX_DAILY_FLOOR_LIMIT  </label>
                    <input class='form-control' type='number' name="mso_max_daily_floor_limit" value="1000">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_MAX_WEEKLY_FLOOR_LIMIT </label>
                    <input class='form-control' type='number' name="mso_max_weekly_floor_limit" value="1000">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_MAX_MONTHLY_FLOOR_LIMIT  </label>
                    <input class='form-control' type='number' name="mso_max_monthly_floor_limit" value="1000">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_VELOCITY_CHECK_MINUTES </label>
                    <input class='form-control' type='number' name="mso_velocity_check_minutes" value="1000">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_VELOCITY_CHECK_TXN_COUNT  </label>
                    <input class='form-control' type='number' name="mso_velocity_check_txn_count"  value="1000">
                </div>
            </div>
		    </div>
	    <div class='col-md-2'></div>
		</div>
		
		<h4 class="text-center">Store</h4>
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>StoreName</label>
                    <input class='form-control' type='text' name="storename"  value="yyy store">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Store_ID</label>
                    <input class='form-control' type='text' name="store_id">
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Address1</label>
                    <input class='form-control' type='text' name="address1" value="New street">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Phone_No</label>
                    <input class='form-control' type='text' name="phone_no" value="98989988">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>City</label>
                    <input class='form-control' type='text' name="city" value="CHN">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Zip_Code</label>
                    <input class='form-control' type='text' name="zip_code"  value="50025">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Mobile_No</label>
                    <input class='form-control' type='text' name="mobile_no" value="9696968855">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Email_Address</label>
                    <input class='form-control' type='text' name="email_address"  value="email@email.com">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>LastModified_Date</label>
                    <input class='form-control' type='text' value="2017-01-01" name="lastmodified_date">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>Status</label>
                    <input class='form-control' type='text' name="status"  value="1">
                </div>
            </div>
		    </div>
	    <div class='col-md-2'></div>
		</div>
		<h4 class="text-center">Terminal</h4>
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TERMINAL_ID</label>
                    <input class='form-control' type='text' name="mso_terminal_id">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_CREATION_DATE</label>
                    <input class='form-control' type='text' value="2017-01-01" name="mso_ter_creation_date">
                </div>
            </div>
            <div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_INSTALL_DATE</label>
                    <input class='form-control' type='text' value="2017-01-01" name="mso_ter_install_date">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_ACTIVATION_DATE</label>
                    <input class='form-control' type='text' value="2017-01-01" name="mso_ter_activation_date">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_STATUS</label>
                    <input class='form-control' type='text' name="mso_ter_status" value="NA">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_LOCATION</label>
                    <input class='form-control' type='text' name="mso_ter_location"  value="CR">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_CITY_NAME</label>
                    <input class='form-control' type='text' name="mso_ter_city_name"  value="CH">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_STATE_CODE</label>
                    <input class='form-control' type='text' name="mso_ter_state_code" value="TN">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_COUNTRY_CODE</label>
                    <input class='form-control' type='text' name="mso_ter_country_code" value="IND" >
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TERMINAL_MODEL</label>
                    <input class='form-control' type='text' name="mso_terminal_model"  value="model">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_BRANCH</label>
                    <input class='form-control' type='text' name="mso_ter_branch"  value="branch">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_CUR_CODE</label>
                    <input class='form-control' type='text' name="mso_ter_cur_code"  value="USD">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_MAX_DAILY_FLOOR_LIMIT</label>
                    <input class='form-control' type='number' name="mso_ter_max_daily_floor_limit" value="1000" >
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_MAX_WEEKLY_FLOOR_LIMIT</label>
                    <input class='form-control' type='number' name="mso_ter_max_weekly_floor_limit" value="1000">
                </div>
            </div>
			<div class='form-row'>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_MONTHLY_FLOOR_LIMIT</label>
                    <input class='form-control' type='number' name="mso_ter_monthly_floor_limit" value="1000">
                </div>
                <div class='col-xs-6 form-group'>
                    <label class='control-label'>MSO_TER_DEVICE_MAC</label>
                    <input class='form-control' type='text' value="mac" name="mso_ter_device_mac">
                </div>
            </div>
			
		    </div>
	    <div class='col-md-2'></div>
		</div>
		
		
    <hr class="featurette-divider"></hr>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
            <div class='form-row'>
                <div class='col-xs-12 form-group'>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                </div>
            </div>
        </div>
        <div class='col-md-2'></div>
    </div>
    <br /><br />
    </form>
</div>
</body>
</html>
