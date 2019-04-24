<?php
require_once('database_config.php');
function getUserType($id){
global $db;
	$db->where("id",$id);
    $data = $db->getOne("users");
	return $data['user_type'];
}
//$testgetUserType = getUserType('69');
//returns 2
function getUserdata($userid){
global $db;
	$db->where("id",$userid);
    $data = $db->getOne("users");
	return $data;
}
//$testgetMerchantsofUser = json_encode(getMerchantsofUser('11'));
//[{"id":11,"username":"tedadmin","password":"Ger67Fiysmt","first_name":"Ted","last_name":"Byers","email_address":"r.ted.byers@gmail.com","phone":"7053251693","agent_id":null,"merchant_id":null,"user_type":1,"voicesave_acct":null,"voicesave_pin":null}]
function getAgentsofUser($agent_id){
global $db;
	$db->where("agent_id",$agent_id);
    $data = $db->get("users");
	return $data;
}
//$testgetAgentsofUser = json_encode(getAgentsofUser('11')); 
//[{"id":69,"username":"PriorityPayoutMA","password":"asdfasw2344234","first_name":"Stefan","last_name":"Gothe","email_address":"stefan@prioritypayout.com","phone":"(858) 254-6839","agent_id":11,"merchant_id":null,"user_type":2,"voicesave_acct":null,"voicesave_pin":null},{"id":72,"username":"NariM2033","password":"ert993Huue","first_name":"Nari","last_name":"Manmohansingh","email_address":"nari@prioritypayout.com","phone":"416 817 6274","agent_id":11,"merchant_id":null,"user_type":2,"voicesave_acct":null,"voicesave_pin":null},{"id":73,"username":"twells4663","password":"4334GG84gi3","first_name":"Tom","last_name":"Wells","email_address":"tomwells@prioritypayout.com","phone":"702 327 5550","agent_id":11,"merchant_id":null,"user_type":2,"voicesave_acct":null,"voicesave_pin":null}]
function getAgentsInfo($agent_id){
global $db;
	$db->where("idagents",$agent_id);
    $data = $db->get("agents");
	return $data;
}
//$testgetAgentsInfo = json_encode(getAgentsInfo('11'));
//[{"idagents":11,"agentname":"Priority Payout","shortname":"Priority","address1":"7040 Avenida Encinas","address2":"","city":"Carlsbad","us_state":"CA","country":"US","zippostalcode":"92011","csphone":"760 448 5522","csemail":"stefan@prioritypayout.com","skypeid":"segothe","logofile":"","affiliation":12,"tz_name":"America\/Los_Angeles","notes":"Related to Gothe2Gothe","real_agent_id":null}]
function getAffiliationofAgents($agent_id){
global $db;
	$db->where("affiliation",$agent_id);
    $data = $db->get("agents");
	return $data;
}

//$testgetAffiliationofAgents = json_encode(getAffiliationofAgents('11'));
//[{"idagents":14,"agentname":"Durango Merchant Services","shortname":"Durango ","address1":"2855 Main Ave Suite B105 ","address2":"","city":"Durango","us_state":"CO","country":"US","zippostalcode":"81301","csphone":"1 866 415 2636","csemail":"shanek@durango-direct.com","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/Denver","notes":"","real_agent_id":null},{"idagents":15,"agentname":"Atlantic Merchant LLC","shortname":"Atlantic Merchant","address1":" 1121 Situs Court, Suite 375","address2":"","city":" Raleigh","us_state":"NC","country":"US","zippostalcode":"27606","csphone":"877-947-1800 ","csemail":"AMS@atlanticmerchant.com ","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/New_York","notes":"","real_agent_id":null},{"idagents":16,"agentname":"Moolah","shortname":"Moolah","address1":"34700 Pacific Coast Highway Suite 200","address2":"","city":"Capistrano Beach","us_state":"CA","country":"US","zippostalcode":"92624","csphone":"800-625-1670","csemail":"kelly@mymoolah.com","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/Los_Angeles","notes":"","real_agent_id":null},{"idagents":17,"agentname":"Ekbalo LLC","shortname":"Ekbalo","address1":"no address provided","address2":"","city":"no address provided","us_state":"no address provided","country":"US","zippostalcode":"00000","csphone":"678 227 0223","csemail":"David@Ekbalo.com","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/New_York","notes":"","real_agent_id":null},{"idagents":18,"agentname":"i-Payout","shortname":"i-Payout","address1":"2500 E Hallandale Beach Blvd, suite 800","address2":"","city":"Hallandale Beach","us_state":"FL","country":"US","zippostalcode":"33009 ","csphone":"9545133150","csemail":"natalia.yenatska@i-payout.com","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/New_York","notes":"","real_agent_id":null},{"idagents":19,"agentname":"Merchant Services and Consulting","shortname":"Merchant Services and Consulting","address1":"na","address2":"na","city":"na","us_state":"na","country":"US","zippostalcode":"na","csphone":"602-904-5564","csemail":"support@merchantaz.com","skypeid":"","logofile":"","affiliation":11,"tz_name":"America\/New_York","notes":"","real_agent_id":null}]
function getMerchantsofAgents($agent_id){
global $db;
	$db->where("affiliate_id",$agent_id);
    $data = $db->get("merchants");
	return $data;
}
//$getMerchantsofAgents = json_encode(getMerchantsofAgents('17'));
//[{"idmerchants":44,"merchant_name":"CP-Invo-help.com","uid":"1","pwd":"1","affiliate_id":17,"tz_name_SQL":"America\/Los_Angeles","is_active":1,"is_invoiced":1,"tz_name":"America\/Los_Ange","currency_code":"USD","msc_customer":1,"big_merchant":0,"start_date":"2012-12-04","short_name":"CP-Invo-help.com","address1":"NA","address2":"NA","city":"NA","us_state":"NA","country":"US","zippostalcode":"NA","csphone":"NA","csemail":"NA","skypeid":"","logofile":"","tcemail":"NA","notes":"","voicesave_toll_free_no":"","vs_tfn_cust":"","call_center_code":"","vr_r_mandatory":0,"max_trans_value":null,"max_pc_trans_velocity":null,"is_in_test_mode":0,"download_from_nmi":0,"brand_id":1,"alt_name_id":null,"concatenated_merchant_id":null,"dremail":"","is_alias":0,"cbemail":"","white_label":"","out_email":null,"out_server":null,"out_username":null,"out_pass":null,"out_port":null,"send_to_sp":null,"send_to_client":null,"note":null,"display_cb_accounting":0,"website":null,"corp_of_conv":null,"reg_ips":null,"uses_actuity":0,"acuity_mid":null,"acuity_pwd":null},{"idmerchants":45,"merchant_name":"CP-Billconnect help.com","uid":"1","pwd":"1","affiliate_id":17,"tz_name_SQL":"America\/Los_Angeles","is_active":1,"is_invoiced":1,"tz_name":"America\/Los_Ange","currency_code":"USD","msc_customer":1,"big_merchant":0,"start_date":"2012-12-04","short_name":"CP-Billconnect help.com","address1":"NA","address2":"NA","city":"NA","us_state":"NA","country":"US","zippostalcode":"NA","csphone":"NA","csemail":"NA","skypeid":"","logofile":"","tcemail":"NA","notes":"","voicesave_toll_free_no":"","vs_tfn_cust":"","call_center_code":"","vr_r_mandatory":0,"max_trans_value":null,"max_pc_trans_velocity":null,"is_in_test_mode":0,"download_from_nmi":0,"brand_id":1,"alt_name_id":null,"concatenated_merchant_id":null,"dremail":"","is_alias":0,"cbemail":"","white_label":"","out_email":null,"out_server":null,"out_username":null,"out_pass":null,"out_port":null,"send_to_sp":null,"send_to_client":null,"note":null,"display_cb_accounting":0,"website":null,"corp_of_conv":null,"reg_ips":null,"uses_actuity":0,"acuity_mid":null,"acuity_pwd":null}]
function getUsersofmerchant($merchant_id){
global $db;
	$db->where("merchant_id",$merchant_id);
    $data = $db->get("users");
	return $data;
}
//$testgetUsersofmerchant = json_encode(getUsersofmerchant('44'));
//[{"id":87,"username":"CP06cardfile","password":"Cardfile176","first_name":"CP06","last_name":"CP06","email_address":"NA","phone":"NA","agent_id":null,"merchant_id":44,"user_type":4,"voicesave_acct":null,"voicesave_pin":null}]
//good id for data testing: 69=PriorityPayoutMA | 160 = Veripayuser1 | 18 = freddy | 119 = Richard Carson | 313 = veripay
//anything in red is another admin to see the account <-- selectable to impersonate user
//anything in purple is an agent <-- needs the +/- sign acts as a folder
//anything in green is a merchant company  <-- needs the +/- sign acts as a folder
//anything in dark red is a merchant account/user <-- selectable to impersonate user
$id = $_SESSION['iid']; //change this to the id of who your looking up
$usertype = getUserType($id);
//var_dump($usertype);
if ($usertype == 2 || $usertype == 3){
	$userdata = getUserdata($id);
	$userMerchantId = $userdata["merchant_id"];
	$userAgentId = $userdata["agent_id"];
	//var_dump($userAgentId); die();
	if($userMerchantId != NULL){
		$MerchantsofUser = getUsersofmerchant($userMerchantId);
	}
	if($userAgentId != NULL){
		$AgentsofUser = getAgentsofUser($userAgentId);
		$AffiliationofAgents = getAffiliationofAgents($userAgentId);
	}
	//var_dump($AgentsofUser);
	//var_dump($AffiliationofAgents);
	$AgentsofUsercolNames0 = array_keys(reset($AgentsofUser));
	
	$AffiliationofAgentscolNames1 = array_keys(reset($AffiliationofAgents));
	$chargebacks = 0;
	foreach($AffiliationofAgents as $AffiliationofAgentsrow1) {
		$MerchantsofAgentscb = getMerchantsofAgents($AffiliationofAgentsrow1['idagents']);
		foreach($MerchantsofAgentscb as $MerchantsofAgentscbrow2) { 
			$db->where("m_id",$MerchantsofAgentscbrow2['idmerchants']);
			$db->where("new",1);
			$cbdata = $db->get("chargebacks");
			$chargebacks = $db->count + $chargebacks;
			//$MerchantsofAgentscbrow2['idmerchants']
		} 
	} 
	/*echo "<table border='1'><tr>";
	
	foreach($AgentsofUser as $row0)
	{
		foreach($AgentsofUsercolNames0 as $colName0)
       {
          echo "<th>$colName0</th>";
       }
	  echo "<tr>";
	  foreach($AgentsofUsercolNames0 as $colName0)
	  {
		 echo "<td style='color:red'>1------".$row0[$colName0]."</td>";
	  }
	  ?>
	  <td style="padding-top: 12px;padding-left: 5px;padding-right: 5px;" >
	  <form action="#" method="post">
	  <input class="" type="submit" name="" value="<?php echo $row0['id']; ?>" />
	  </td></tr>
	  <?php 
		
	}	
		
		$AffiliationofAgentscolNames1 = array_keys(reset($AffiliationofAgents));

		foreach($AffiliationofAgents as $row1)
		{	
			foreach($AffiliationofAgentscolNames1 as $colName1)
		   {
			  echo "<th>$colName1</th>";
		   }
		  echo "<tr style='color:purple'>";
		  foreach($AffiliationofAgentscolNames1 as $colName1)
		  {
			 echo "<td>1------".$row1[$colName1]."</td>"; 
		  }
		  ?>
		  <td style="padding-top: 12px;padding-left: 5px;padding-right: 5px;" >
		  <form action="#" method="post">
		  <input class="" type="submit" name="" value="<?php echo $row1['idagents']; ?>" />
		  </td></tr>
		  <?php 
			$MerchantsofAgents = getMerchantsofAgents($row1['idagents']);
			 $MerchantsofAgentscolNames2 = array_keys(reset($MerchantsofAgents));
			 
			foreach($MerchantsofAgents as $row2)
			{
				foreach($MerchantsofAgentscolNames2 as $colName2)
			   {
				  echo "<th>$colName2</th>";
			   }
			  echo "<tr>";
			  foreach($MerchantsofAgentscolNames2 as $colName2)
			  {
				 echo "<td style='color:green'>2------".$row2[$colName2]."</td>";
			  }
			  ?>
			  <td style="padding-top: 12px;padding-left: 5px;padding-right: 5px;" >
			  <form action="#" method="post">
			  <input class="" type="submit" name="" value="<?php echo $row2['idmerchants']; ?>" />
			  </td></tr>
			  <?php 
			  
			  $Usersofmerchant = getUsersofmerchant($row2['idmerchants']);
			  $UsersofmerchantcolNames3 = array_keys(reset($Usersofmerchant));
				
				foreach($Usersofmerchant as $row3)
				{
					foreach($UsersofmerchantcolNames3 as $colName3)
				{
				  echo "<th>$colName3</th>";
				}
				  echo "<tr>";
				  foreach($UsersofmerchantcolNames3 as $colName3)
				  {
					 echo "<td style='color:darkred'>3------".$row3[$colName3]."</td>"; 
				  }
				  ?>
				  <td style="padding-top: 12px;padding-left: 5px;padding-right: 5px;" >
				  <form action="#" method="post">
				  <input class="" type="submit" name="" value="<?php echo $row3['id']; ?>" />
				  </td></tr>
				  <?php 
				}
			  
			}
		}
	
	
	echo "</table>";
	*/
	//echo $tree;
}elseif($usertype == 1){
	echo 'show all users This is a super admin account';
}elseif($usertype == 6){
	echo 'show virtual terminal';
}else{
	//echo '<a href="/login.php"> Please Login Again</a>';
}

//echo $testgetUsersofmerchant;

?>