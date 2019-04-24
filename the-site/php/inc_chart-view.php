<?php
require_once('database_config.php');

if(isset($_GET['q'])){
$q = $_GET['q'];
$iid = $_SESSION['iid'];
switch ($q) {
    case 'affinfo':
        echo getAffInfo($iid);
        break;
    case 'accinfo':
        echo getAccInfo($iid);
        break;
    case 'processors':
        echo getProcessors($iid);
        break;
	case 'fee':
        echo getFee($iid);
        break;
	case 'affstatus':
        echo getAffStatus($iid);
        break;
}

}
function getAffInfo($iid){
	global $db;
	$db->where("id",$iid);
	$userdata = $db->getOne("users");
	if($db->count > 0){
	$db->where("idagents",$userdata['agent_id']);
	$agentdata = $db->getOne("agents");
    if($db->count > 0){
		return '<div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/sales-and-refunds.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
    }else{
		return false;
	}
	}else{
		return false;
	}
}
function getAccInfo($id){
	
	return '   <div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/transaction-count.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
}
function getProcessors($id){
	
	return '<div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/chargeback.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
}
function getFee($id){
	
	return '<div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/chargebackbyvolume.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
}
function getAffStatus($id){
	
	return '
 <div class="panel panel-primary">
    <div class="panel-heading">
        Agent Information
    </div>
    <div class="panel-body">

        <div class="form-group">
            <table style="border: 0px solid gray;" cellpadding="3" cellspacing="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td class="tableheader" style="border-bottom: 0px"></td>
                    </tr>
                    <tr>
                        <td align="left" class="mainarea" style="padding: 10px;"><center>

                            <img src="/img/chargeback-decline.jpg"><br>
                        </center>
                      </td>
                    </tr>
                </tbody>
            </table>';
}
?>