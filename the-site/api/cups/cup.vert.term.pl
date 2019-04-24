#!perl
use CGI;
use CGI::Session;
use CGI::Carp qw(fatalsToBrowser);
use DBI;
use Locale::SubCountry;
use Locale::Currency;
use lib './REJBlib';
#use access;
use access;
use URI::Escape;

use CGI::Carp::DebugScreen (
    engine => 'TT',
    debug          => 1,
    lines          => 5,
    modules        => 1,
    environment    => 1,
    raw_error      => 1,
    overload       => 1,
);

my $db = 'profitorius';
my $hostname = 'localhost';
my $user = 'rejbyers';
my $dbpwd = 'Didr39Qcab';
my $dbh = DBI->connect_cached("DBI:mysql:database=$db;host=$hostname",$user,$dbpwd,{RaiseError => 1}) or die "Failed to connect to the DB.\n";

my $sql = "SELECT * FROM states ORDER BY state;";
my $sth = $dbh->prepare($sql) or die $dbh->errstr;
my %provinces,%states;
$sth->execute;
while (my $href = $sth->fetchrow_hashref) {
  my $id = $href->{'id'};
  my $state = $href->{'state'};
  my $abbrev = $href->{'abbrev'};
  if ($id < 55) {
    $states{$abbrev} = $state;
  } else {
    $provinces{$abbrev} = $state;
  }
}
$sth->finish;

my $query = new CGI;
my $session = CGI::Session->load('driver:mysql',$query,{ DataSource  => 'dbi:mysql:profitorius',
							  User        => 'rejbyers',
							  Password    => 'Didr39Qcab' });
return unless (1 == access::is_session_valid($query,$session));
my $access_obj = access->new($query,$session);
$access_obj->print_session_header;
$access_obj->print_html_header;
my $userid = $access_obj->idusers;
&print_body(\%provinces,\%states,$access_obj->idusers,$access_obj);
$access_obj->print_end;
exit(0);

sub print_body {
  my ($pr,$sr,$userid, $a)= @_;
  my %p = %{$pr};
  my %s = %{$sr};
#  print "<table border>";
#  foreach my $k (sort keys %s) {
#    print "<tr><td>$k</td><td>$s{$k}</td></tr>";
#  }
#  foreach my $k (sort keys %p) {
#    print "<tr><td>$k</td><td>$p{$k}</td></tr>";
#  }
#  print "</table>";
  my %proc_vals;
  $proc_vals{45} = 'nmi';
  $proc_vals{46} = 'ss';
  $proc_vals{47} = 'mp';
  $sql = "SELECT idmerchants,merchant_name FROM `profitorius`.`user_merchant` LEFT JOIN `profitorius`.`merchants` ON id_merchant = idmerchants WHERE id_user = ?;";
  $sth = $dbh->prepare($sql) or die $dbh->errstr;
  $sth->execute($userid) or die $sth->errstr;
  my ($mid423,$merchant) = $sth->fetchrow_array;
  $sth->finish;

  print "<table cellpadding=0 cellspacing=0 ><tr><td colspan=2 id='headerBarStyle'  style=\"height:70px\"><table style=\"width:100%;\"><tr><td><div id=\"main_logo\"><h1 class='page_title'>Virtual Terminal</h1></div></td><td align=\"right\">";
  #$a->print_logout_button;

  print "</td></table></td></tr><tr><td class='left_menu_td' >";

  $a->print_menu;

  print "</td><td><div id=\"tabs\" style=\"height:100%;width:100%\"><div class='tabs_container'>
    <ul>";
  print "    <li><a href=\"#vt\">Sales and Authorizations</a></li>
      <li><a href=\"#cvr\">Captures, Refunds and Voids</a></li>
      <li><a href=\"#rec\">Authorization Recordings</a></li>";
  print "  </ul></div>
    <div id=\"vt\" >";
  my $sthun = $dbh->prepare("SELECT first_name, last_name FROM users WHERE id = $userid;");
  $sthun->execute;
  my ($fn,$ln) = $sthun->fetchrow_array;
  $sthun->finish;
  print "<table width=\"100%\"><tr><td>";
  if (defined $merchant) {
    print "<h4>Merchant: $merchant</4>";
  } else {
    print "<h4>This form should not be used except by a merchant's user.</h4>";
  }
  print "</td><td style=\"text-align:right\"><h4>Session User: $fn $ln</h4></td></tr></table>";
#  print "<h4>Session User: $username</h4>";
  &print_sale_form($pr,$sr,$query,$mid423);
  print "</div><div id=\"cvr\" >";
  print "<table width=\"100%\"><tr><td>";
  if (defined $merchant) {
    print "<h4>Merchant: $merchant</h4>";
  } else {
    print "This form should not be used except by a merchant's user.</h1>";
  }
#  print "<h4>Session User: $username</h4>";
  print "</td><td style=\"text-align:right\"><h4>Session User: $fn $ln</h4></td></tr></table>";
  &print_cvr_form($query);
  print "</div>";
  print "<div id=\"rec\" >";
  print "<table width=\"100%\"><tr><td>";
  if (defined $merchant) {
    print "<h4>Merchant: $merchant</h4>";
  } else {
    print "This form should not be used except by a merchant's user.</h1>";
  }
  print "</td><td style=\"text-align:right\"><h4>Session User: $fn $ln</h4></td></tr></table>";
  &print_rec_form($mid423,$merchant);
  print "</div>";

#  print "<div id=\"accordion\" style=\"height:100%;width:100%\">
#    <h3><a href=\"#\">Sales and Authorizations</a></h3>
#    <div id=\"vt\" style=\"height:100%;width:100%\"><p>Content of Sales and Authorizations page</p></div>
#    <h3><a href=\"#cvr\">Captures, Refunds and Voids</a></h3>
#    <div id=\"cvr\" style=\"height:100%;width:100%\"><p>Content of Captures, Refunds and Voids Page</p></div>
#  </div>";
  print "</td></tr></table>";
  &print_js($pr,$sr);
  print "<script>
		\$('.flexme').flexigrid({
			height : 150,
                        width  : 1600,
			striped : true
		});
		
		function submit_transaction()
		{
			if(!validateFormData(\$('form#vt')))
			{
				return;
			}
			
			data = \$('form#vt').serialize();
			show_notification('load','Posting Transaction...');
			\$('form#vt input[type=\"button\"]').attr('disabled', 'disabled');
			\$.ajax({
			  type: 'POST',
			  url: 'api.pl',
			  data: data,
			  success: function(d){
			  	if(d == 1)
				{
					\$('form#vt input[type=\"button\"]').removeAttr('disabled');
					show_notification('success','Transaction Posted');
					//window.reload();
				}else{
					//alert('Transaction Post Failed because:'+d);
					show_notification('error',d);
					\$('form#vt input[type=\"button\"]').removeAttr('disabled');
				}
				
				
			  },
			  error: function(d){
			  	show_notification('error','<br>Error: '+d.statusText);
				\$('form#vt input[type=\"button\"]').removeAttr('disabled');
			  }
			});
		
		}
		
		function submit_transaction2()
		{
			data = \$('form#cvrf').serialize();
			show_notification('load','Posting Transaction...');
			\$('form#cvrf input[type=\"button\"]').attr('disabled', 'disabled');
			\$.ajax({
			  type: 'POST',
			  url: 'api.pl',
			  data: data,
			  success: function(d){
			  	if(d == 1)
				{
					\$('form#cvrf input[type=\"button\"]').removeAttr('disabled');
					show_notification('success','Transaction Posted');
					//window.reload();
				}else{
					//alert('Transaction Post Failed because:'+d);
					show_notification('error',d);
					\$('form#cvrf input[type=\"button\"]').removeAttr('disabled');
				}
				
				
			  },
			  error: function(d){
			  	show_notification('error','<br>Error: '+d.statusText);
				\$('form#cvrf input[type=\"button\"]').removeAttr('disabled');
			  }
			  
			});
		
		}
		
        </script>";
}


sub print_sale_form {
  my ($pr,$sr,$query,$mmid) = @_;
  my %p = %{$pr};
  my %s = %{$sr};
  my $api_script = $query->url(-path=>1);
  $api_script =~ s/vt\.pl/api.pl/;
  print "<p><small><b style=\"color:red\">**</b> denotes required information</small></p>";
  my $psql = "SELECT p_id, processor_name, processor_name2 FROM (SELECT processor_id FROM user_merchant LEFT JOIN merchant_processor_creds ON id_merchant = merchant_id WHERE id_user = ?) A LEFT JOIN processors ON p_id = processor_id;";
  $sth = $dbh->prepare($psql) or die $dbh->errstr;
  $sth->execute($userid) or die $sth->errstr;
  my %proc_tmp;
  my %proc_vals;
  my $pcount = 0;
  my $target = '';
  my $pn;
  my $requd_str = "required=\"required\"";
  my $requd_str2 = "<b style=\"color:red\">**</b>";
  while (my $href = $sth->fetchrow_hashref) {
    my $p_id = $href->{'p_id'};
    my $pname = $href->{'processor_name'};
    $pn = $href->{'processor_name2'};
    $proc_tmp{$p_id} = $pname;
    $proc_vals{$p_id} = $pn;
    if ($pn =~ m/se/) {
      $target = " target=\"_blank\" ";
#      $requd_str = '';
#      $requd_str2 = '';
    }
    $pcount++;
  }
  $sth->finish;
  
  my $msql = "SELECT id_merchant FROM user_merchant WHERE id_user = $userid;";
  my $vrmid;
  $sth = $dbh->prepare($msql);
  $sth->execute;
  ($vrmid) = $sth->fetchrow_array;
  $sth->finish;
  $vrmid = 1 unless defined $vrmid;
  $msql = "SELECT call_center_code,voicesave_toll_free_no,vs_tfn_cust,vr_r_mandatory,note FROM merchants WHERE idmerchants = $vrmid;";
  $sth = $dbh->prepare($msql);
  $sth->execute;
  my ($code,$vstfn,$vstfncc,$reqd,$vtnote) = $sth->fetchrow_array;
  $sth->finish;
  print "<input type='hidden' value='".$userid."' namme='asd' />";
  $vtnote = uri_unescape($vtnote);
  print "<form $target method=\"post\" id=\"vt\" name=\"vt\", action=\"$api_script\", onsubmit=\"return validateFormData(this)\">";
  print "<table><tr><td>";
  print "<input type=\"hidden\" name=\"source\" value =\"vt\"  />";
  if ($pcount > 1) {
    print "<p>Processor<br /><select name=\"processor\" style=\"width: 225px\"></p>";
    foreach $k (keys %proc_tmp) {
      print "<option value=\"$proc_vals{$k}\" selected=\"selected\" >$proc_tmp{$k}</option>";
    }
    print "</select><br /><br />";
  } else {
#   print "<p>Processor<br />";
    foreach $k (keys %proc_tmp) {
      # although the structure of a loop is used here, there is only one key/value pair
      # we make a hidden field with the right value, and print out the processor name (which we may decide we don't want to do.
      print "<input type=\"hidden\" name=\"processor\" value =\"$proc_vals{$k}\"  />";
#     print "$proc_tmp{$k}<br /><br />===== $k ===== $proc_vals{$k} =====<br />";
    }
  }
  print "Transaction Type<br /><select name=\"type\" id=\"type\" style=\"width: 225px\"><option value=\"auth\">Authorization</option><option value=\"sale\" selected=\"selected\" >Sale</option></select><br />";
  print "<h4>Billing Information</h4>";
  print "<table >";
  print "<tr><td style=\"width: 225px\">Credit Card Number $requd_str2</td><td><input type=\"text\" name=\"ccn\" id=\"ccn\" style=\"width: 250px\" $requd_str maxlength=\"16\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Credit Card Expiry Date (MMYY) $requd_str2</td><td><input type=\"text\" name=\"ccexp\" id=\"ccexp\" style=\"width: 250px\" $requd_str maxlength=\"4\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Total Amount <b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"totamt\" id=\"totamt\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td>Currency</td><td>";
  &print_currency_select($mmid);
  print "</td></tr>";
  print "<tr><td style=\"width: 225px\">Card Security Code (cvv)</td><td><input type=\"text\" name=\"cvv\" id=\"cvv\" style=\"width: 250px\" maxlength=\"4\" /></td></tr>";
  print "</table>";
  print "<h4>Order Information</h4>";
  print "<table >";
  print "<tr><td style=\"width: 225px\">Order ID<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"orderid\" id=\"orderid\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Order Description $requd_str2<br />Between 5 and 255 characters</td><td><textarea id=\"orderdesc\" name=\"orderdesc\" title=\"Description\" rows=4 style=\"width: 250px\" $requd_str></textarea></td></tr>";
  print "<tr><td style=\"width: 225px\">Purchase Order Number</td><td><input type=\"text\" name=\"pon\" id=\"pon\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Shipping</td><td><input type=\"text\" name=\"shipping\" id=\"shipping\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Tax</td><td><input type=\"text\" name=\"tax\" id=\"tax\" style=\"width: 250px\" /></td></tr>";
  print "</table>";

  print "<h4>Billing Address</h4>";
  print "<table >";
  print "<tr><td style=\"width: 225px\">First Name<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"bfn\" id=\"bfn\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Last Name<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"bln\" id=\"bln\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Company</td><td><input type=\"text\" name=\"bcn\" id=\"bcn\" style=\"width: 250px\" /></td></tr>";
#  print "<tr><td style=\"width: 225px\">Country</td><td><select name=\"bcountry\" id=\"bcountry\" size=\"1\" style=\"width: 250px\" onchange=countrychange(this.form,this.options.selectedIndex,1)><option value=\"CA\">Canada</option><option value=\"US\" selected=\"selected\">USA</option></select></td></tr>";
#  print "<tr><td style=\"width: 225px\">State</td><td><select name=\"bstate\" size=\"1\" style=\"width: 250px\">";
#  foreach my $k (sort keys %s) {
#    print "<option value=\"$k\">$s{$k}</option>";
#  }
  print "<tr><td style=\"width: 225px\">Country<b style=\"color:red\">**</b></td><td><select name=\"bcountry\" id=\"bcountry\">";
  my $world = new Locale::SubCountry::World;
  my %all_country_keyed_by_name   = $world->full_name_code_hash;
  foreach my $c (sort keys %all_country_keyed_by_name) {
    print "<option value=\"$all_country_keyed_by_name{$c}\">$c</option>";
  }
  print "</select></td></tr>";
  print "<tr><td>Province or state</td><td><select name=\"bstate\" id=\"bstate\"><option value=\"-1\">Select a country first</option></select></td></tr>\n";
  print "<tr><td style=\"width: 225px\">Address<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"baddress1\" id=\"baddress1\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Address (cont.)</td><td><input type=\"text\" name=\"baddress2\" id=\"baddress2\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">City<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"bcity\" id=\"bcity\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">zip/postal code<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"bzip\" id=\"bzip\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Phone<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"bphone\" id=\"bphone\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Fax</td><td><input type=\"text\" name=\"bfax\" id=\"bfax\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Email<b style=\"color:red\">**</b></td><td><input type=\"email\" name=\"bemail\" id=\"bemail\" style=\"width: 250px\" required=\"required\" /></td></tr>";
#  print "<tr><td style=\"width: 225px\">Website</td><td><input type=\"url\" name=\"bwsite\" id=\"bwsite\" style=\"width: 250px\" /></td></tr>";
  print "</table>";
  print "<h4>Shipping Address</h4>";
  print "<p><label> <input type=checkbox id=\"sasaba\" name=\"sasaba\" onchange=basacb(this.form)>The shipping address is the same as the billing address.</label></p>";
  print "</td><td style='margin-left: 30px;width: 50%;vertical-align: top;color:black;'><h1>Sale Script</h1>$vtnote</td></tr></table>";
   print "<div id=\"shippingaddress\">";
   
  print "<table >";
  print "<tr><td style=\"width: 225px\">First Name<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"sfn\" id=\"sfn\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Last Name<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"sln\" id=\"sln\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Company</td><td><input type=\"text\" name=\"scn\" id=\"scn\" style=\"width: 250px\" /></td></tr>";
#  print "<tr><td style=\"width: 225px\">Country</td><td><select name=\"scountry\" size=\"1\" style=\"width: 250px\" onchange=countrychange(this.form,this.options.selectedIndex,2)><option value=\"CA\">Canada</option><option value=\"US\" selected=\"selected\">USA</option></select></td></tr>";
#  print "<tr><td style=\"width: 225px\">State</td><td><select name=\"sstate\" size=\"1\" style=\"width: 250px\">";
#  foreach my $k (sort keys %s) {
#    print "<option value=\"k\">$s{$k}</option>";
#  }
  print "<tr><td style=\"width: 225px\">Country</td><td><select name=\"scountry\" id=\"scountry\">";
  foreach my $c (sort keys %all_country_keyed_by_name) {
    print "<option value=\"$all_country_keyed_by_name{$c}\">$c</option>";
  }
  print "</select></td></tr>";
  print "<tr><td>Province or state</td><td><select name=\"sstate\" id=\"sstate\"><option value=\"-1\">Select a country first</option></select></td></tr>\n";
  print "<tr><td style=\"width: 225px\">Address<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"saddress1\" id=\"saddress\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Address (cont.)</td><td><input type=\"text\" name=\"saddress2\" id=\"saddress2\" style=\"width: 250px\"  /></td></tr>";
  print "<tr><td style=\"width: 225px\">City<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"scity\" id=\"scity\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">zip/postal code<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"szip\" id=\"szip\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Phone<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"sphone\" id=\"sphone\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Fax</td><td><input type=\"text\" name=\"sfax\" id=\"sfax\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Email</td><td><input type=\"email\" name=\"semail\" id=\"semail\" style=\"width: 250px\" /></td></tr>";
  print "</table>";
  print "</div>";

  my $msql = "SELECT id_merchant FROM user_merchant WHERE id_user = $userid;";
  my $vrmid;
  $sth = $dbh->prepare($msql);
  $sth->execute;
  ($vrmid) = $sth->fetchrow_array;
  $sth->finish;
  $vrmid = 1 unless defined $vrmid;
#   $msql = "SELECT call_center_code,voicesave_toll_free_no,vs_tfn_cust,vr_r_mandatory FROM merchants WHERE idmerchants = $vrmid;";
#   $sth = $dbh->prepare($msql);
#   $sth->execute;
#   my ($code,$vstfn,$vstfncc,$reqd) = $sth->fetchrow_array;
#   $sth->finish;
  unless (defined $vstfn) {
    print "<p>This merchant is not configured to record voice authorizations</p>";
  } else {
    my $usql = "SELECT voicesave_acct FROM users WHERE id = $userid;";
    $sth = $dbh->prepare($usql);
    $sth->execute;
    ($vsacct) = $sth->fetchrow_array;
    $sth->finish;
    my $ro = ($reqd == 1) ? " disabled=\"disabled\" "  : '';
    print "<h4>Record Authorization</h4>";
    
    if($reqd == 1)
	{
	    print "<p><label><input type=hidden id=\"voicerec\" name=\"voicerec\" value='1'  /><input type=checkbox disabled='disabled' checked=\"checked\" $ro>The authorization call with the customer is recorded</label></p>";

	}else{
	    print "<p><label><input type=checkbox id=\"voicerec\" name=\"voicerec\" value='1' onchange=recordcall(this.form) checked=\"checked\" >The authorization call with the customer is recorded</label></p>";

	}
    print "<div id=\"voicestamps\">";
    print "<table >";
    print "<tr><td style=\"width: 225px\">Voice Authorization Phone Number</td><td style=\"width: 250px\" >$vstfn";
    print "<input type=\"hidden\" name=\"vapn\" id=\"vapn\" value =\"$vstfncc\"  /></td></tr>";
    print "<tr><td style=\"width: 225px\">Merchant Code</td><td>$code<input type=\"hidden\" name=\"callcentercode\" id=\"callcentercode\" value =\"$code\"  /></td></tr>";
    print "<tr><td style=\"width: 225px\">Account Code</td><td>$vsacct <input type=\"hidden\" name=\"csrid\" id=\"csrid\" value =\"$vsacct\"  /></td></tr>";
    print "<tr><td style=\"width: 225px\">Agent Password<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"csrpin\" id=\"csrpin\" style=\"width: 250px\" required=\"required\" /></td></tr>";
    print "<tr><td style=\"width: 225px\">Confirmation Number<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"confnum\" id=\"confnum\" style=\"width: 250px\" required=\"required\"  /></td></tr>";
    print "<tr><td style=\"width: 225px\">Confirmation Pin<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"confpin\" id=\"confpin\" style=\"width: 250px\" required=\"required\"  /></td></tr>";
    print "<tr><td style=\"width: 225px\">Bank Name (ACH only)</td><td><input type=\"text\" name=\"bankname\" id=\"bankname\" style=\"width: 250px\" /></td></tr>";
    print "<tr><td style=\"width: 225px\">Bank City (ACH only)</td><td><input type=\"text\" name=\"bankcity\" id=\"bankcity\" style=\"width: 250px\" /></td></tr>";
    print "<tr><td style=\"width: 225px\">Bank State (ACH only)</td><td><input type=\"text\" name=\"bankstate\" id=\"bankstate\" style=\"width: 250px\" /></td></tr>";
    print "</table>";
    print "</div>";
  }
#  &sermepa_subform if ($pn =~ m/se/);
  #print $query->submit('Charge/Authorize Card');
  print "<input type='button' name='Charge/Authorize Card' value='Charge/Authorize Card' onclick='submit_transaction()' /> ";
  #print $query->submit(-name=>'sermepasave', -value=>'Save Data') if ($pn =~ m/se/);
  #print $query->reset("Reset!");
#  print "<input type=\"submit\" name='sermepasave'  value=\"Save Data\"  style=\"width:150px\"/>";
  print "<input type=\"reset\"  value=\"Reset!\" style=\"width:150px\" />";
  print $query->endform;
}

sub print_cvr_form {
  my $query = shift;
  my $uid = $query->param('uid');
  my $api_script = $query->url(-path=>1);
  $api_script =~ s/vt\.pl/api.pl/;
  print "<table border ><tr><td  style=\"vertical-align: top;width:500\">";
  print "<h3>Process Capture, Refund, and Void Transactions</h3>";
  print "<form name=\"cvrf\" id=\"cvrf\" method=\"post\" name=\"vt\", action=\"$api_script?uid=$uid\", onsubmit=\"return validateCVRFormData(this)\">";
  print "<input type=\"hidden\" name=\"source\" value =\"vt\"  />";
  print "<table>";
  print "<tr><td style=\"width: 225px\">Transaction Type</td><td><SELECT name=\"type\" id=\"type\" style=\"width: 250px\"><option value=\"capture\" selected=\"selected\" >Capture</option><option value=\"refund\">Refund</option><option value=\"void\">Void</option></select></td></tr>";
  print "<tr><td style=\"width: 225px\">Transaction ID<mark style=\"color:red\">*</mark></td><td><input type=\"text\" name=\"tid\" id=\"tid\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Amount</td><td><input type=\"text\" name=\"tamnt\" id=\"tamnt\" style=\"width: 250px\" /></td></tr>";
  print "</table>";
  #print $query->submit;
  #print $query->reset("Reset!");
  print "<input type=\"button\" value=\"Submit\"  style=\"width:150px\" onclick='submit_transaction2()' />";
  print "<input type=\"reset\"  value=\"Reset!\" style=\"width:150px\" />";
  print $query->endform;
  print "<br /><hr /><br /><p>The transaction ID is always required for all supported transactions.  The amount is required unless the transaction type is 'void'.</p>";
  $search_api = $scriptname;
  $search_api =~ s/jq\.test\.pl/trans.search.pl/;
  print "</td><td><h3>Search for the original transaction</h3><br />";
#  print "<iframe src=\"$search_api\" width=\"700px\" height=\"700px\"></iframe>";
  &print_search_form;
  &print_results;
  print "</td></tr></table>";
}

sub print_rec_form {
  my ($mid423a,$merc) = @_;
  print "<table border><tr><td>";
  &print_search_form('rec');
  print "</td><td>";
  my $api_script = $query->url(-path=>1);
  $api_script =~ s/vt\.pl/api.vrec.pl/;
  print "<form method=\"post\" id=\"vrecf\" name=\"vrecf\", action=\"$api_script\" >";
  print "<input type=\"hidden\" name=\"merchant\" id=\"merchant\" value =\"$mid423a\"  />";
  print "<input type=\"hidden\" name=\"tid\" id=\"tid\" value =\"0\"  />";
  print "<h4>Record Authorization</h4>";
  print "<table >";
  print "<tr><td>First name</td><td><b><input type=\"text\" name=\"fname\" id=\"fname\" style=\"width: 100%;background-color:lightgrey\" readonly=\"readonly\" /></b></td></tr><tr><td>Last name</td><td><b><input type=\"text\" name=\"lname\" id=\"lname\" style=\"width: 100%;background-color:lightgrey\" readonly=\"readonly\" /></b></td></tr>";
  print "<tr><td>Phone</td><td><b><input type=\"text\" name=\"bphone\" id=\"bphone\" style=\"width: 100%;background-color:lightgrey\" readonly=\"readonly\" /></b></td></tr>";
# need SQL to get merchant's voicestamps call center number
  my $msql = "SELECT id_merchant FROM user_merchant WHERE id_user = $userid;";
  my $vrmid;
  $sth = $dbh->prepare($msql);
  $sth->execute;
  ($vrmid) = $sth->fetchrow_array;
  $sth->finish;
  $vrmid = 1 unless defined $vrmid;
  $msql = "SELECT call_center_code,voicesave_toll_free_no,vs_tfn_cust FROM merchants WHERE idmerchants = $vrmid;";
  $sth = $dbh->prepare($msql);
  $sth->execute;
  my ($vrmid,$vstfn,$vstfncc) = $sth->fetchrow_array;
  $sth->finish;
  print "<tr><td style=\"width: 225px\">Voice Authorization Phone Number</td><td style=\"width: 250px\" >$vstfn</td></tr>";
  print "<input type=\"hidden\" name=\"vapn\" value =\"$vstfncc\"  />";
  my $usql = "SELECT voicesave_acct FROM users WHERE id = $userid;";
  $sth = $dbh->prepare($usql);
  $sth->execute;
  my ($vsacct) = $sth->fetchrow_array;
  $sth->finish;
  print "<input type=\"hidden\" name=\"callcentercode\" value =\"$vrmid\"  />";
  print "<tr><td style=\"width: 225px\">Merchant Code</td><td>$vrmid</td></tr>";
  print "<tr><td style=\"width: 225px\">Account Code</td><td>$vsacct<input type=\"hidden\" name=\"callcenteragent\" id=\"callcenteragent\" value =\"$vsacct\"  /></td></tr>";
  print "<tr><td style=\"width: 225px\">Agent Password<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"csrpin\" id=\"csrpin\" style=\"width: 250px\" required=\"required\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Confirmation Number<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"confnum\" id=\"confnum\" style=\"width: 250px\"required=\"required\"  /></td></tr>";
  print "<tr><td style=\"width: 225px\">Confirmation Pin<b style=\"color:red\">**</b></td><td><input type=\"text\" name=\"confpin\" id=\"confpin\" style=\"width: 250px\"required=\"required\"  /></td></tr>";
  print "</table>";
  print $query->submit('Save Data');
  print "<input type=\"reset\"  value=\"Reset!\" style=\"width:150px\" />";
  print $query->endform;
  print "</td></tr></table>";
  &print_results2;
}

sub print_js {
  my ($pr,$sr) = @_;
  my %p = %{$pr};
  my %s = %{$sr};
  print "\n<script type=\"text/javascript\">\n<!--\n";
  print "\$(document).ready(function(){
	  \$('#bcountry').change(function(){
               sendvalue(\$(this).val());
             });
	  \$('#scountry').change(function(){
               sendvalue2(\$(this).val());
             });
         });
        function sendvalue(str) {
          \$.ajax({
				  type: 'GET',
                  url: \"states.pl\",
                  data: 'countrycode='+str,
                  success: function(data) {
                               \$('#bstate').html(data);},
                  datatype: \"html\" });
        }
        function sendvalue2(str) {
          \$.ajax({
				  type: 'GET',
                  url: \"states.pl\",
                  data: 'countrycode='+str,
                  success: function(data) {
                               \$('#sstate').html(data);},
                  datatype: \"html\" });
        }\n";
  print "function basacb(vtf1) {
           var x = !vtf1.sasaba.checked;
           vtf1.sfn.required = x;
           vtf1.sln.required = x;
           vtf1.saddress1.required = x;
           vtf1.scity.required = x;
           vtf1.szip.required = x;
           vtf1.sphone.required = x;
           if (!x) {
             vtf1.scountry.value = vtf1.bcountry.value;
             sendvalue2(vtf1.bcountry.value);
             vtf1.sstate.value = vtf1.bstate.value;
           }
           vtf1.sfn.value = (x) ? '' : vtf1.bfn.value ;
           vtf1.sln.value = (x) ? '' : vtf1.bln.value ;
           vtf1.saddress1.value = (x) ? '' : vtf1.baddress1.value;
           vtf1.saddress2.value = (x) ? '' : vtf1.baddress2.value;
           vtf1.scity.value = (x) ? '' : vtf1.bcity.value;
           vtf1.szip.value = (x) ? '' : vtf1.bzip.value;
           vtf1.sphone.value = (x) ? '' : vtf1.bphone.value;
           vtf1.scn.value = (x) ? '' : vtf1.bcn.value;
           vtf1.sfax.value = (x) ? '' : vtf1.bfax.value;
           vtf1.semail.value = (x) ? '' : vtf1.bemail.value;
           shippingaddress.hidden=!x;
         }\n";
  print "function isNumber(n) { 
           return !isNaN(parseFloat(n)) && isFinite(n); 
         }\n";
  print "function validateCVRFormData(vtf2) {
           var x = vtf2.tid.value
           if (!rv) {
             alert(msg);
           }
           return rv;
         }\n";
  print "function validateSearchFormData(vtf2) {
           var x = vtf2.firstname.value
           var msg = \"\";
           var rv = true;
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"First name must be provided\");
             rv = false;
           }
           x = vtf2.firstname.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Last name must be provided\");
             rv = false;
           }
           x = vtf2.bzip.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Postal Code must be provided\");
             rv = false;
           }
           x = vtf2.bphone.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Phone number must be provided\");
             rv = false;
           }
           if (!rv) {
             alert(msg);
           }
           return rv;
         }\n";

  print "function validateFormData(vtf2) {
			vtf2 = vtf2[0];
			console.log('starting validation...');
           var x = vtf2.ccn.value
           var msg = \"\";
           var rv = true;
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Credit card number must be provided\");
             rv = false;
           }
           if (!isNumber(x)) {
             msg = msg.concat(\"\\r\\n\",\"Credit card number must be a number\");
           }
           x = vtf2.ccexp.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Credit card expiry date must be provided\");
             rv = false;
           }
           if (!isNumber(x)) {
             msg = msg.concat(\"\\r\\n\",\"Credit card expiry date must be a number\");
             rv = false;
           }
           x = vtf2.totamt.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Transaction amount must be provided\");
             rv = false;
           }
           if (!isNumber(x)) {
             msg = msg.concat(\"\\r\\n\",\"Transaction amount must be a number\");
             rv = false;
           }
           //x = vtf2.cvv.value
           //if (x==null || x==\"\") {
            // msg = msg.concat(\"\\r\\n\",\"Credit card security code must be provided\");
             //rv = false;
           //}
           if (!isNumber(x)) {
             msg = msg.concat(\"\\r\\n\",\"Credit card security code must be a number\");
             rv = false;
           }
            x = vtf2.orderid.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Order ID must be provided\");
             rv = false;
           }
           x = vtf2.orderdesc.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Order description must be provided\");
             rv = false;
           }

           x = vtf2.bfn.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"First name must be provided\");
             rv = false;
           }
           x = vtf2.bln.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Last name must be provided\");
             rv = false;
           }
           x = vtf2.baddress1.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Address must be provided\");
             rv = false;
           }
           x = vtf2.bcity.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"City must be provided\");
             rv = false;
           }
           x = vtf2.bzip.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"ZIP or postal code must be provided\");
             rv = false;
           }
           x = vtf2.bphone.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"A phone number must be provided\");
             rv = false;
           }

           x = vtf2.bemail.value
           var atpos = x.indexOf(\"@\")
           var dotpos = x.lastIndexOf(\".\")
           if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
             msg = msg.concat(\"\\r\\n\",\"Not a valid e-mail address\");
             rv = false;
           }
           if (!vtf2.sasaba.checked)
		   {
			   x = vtf2.sfn.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"First name must be provided\");
				 rv = false;
			   }
			   x = vtf2.sln.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"Last name must be provided\");
				 rv = false;
			   }
			   x = vtf2.saddress1.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"Address must be provided\");
				 rv = false;
			   }
			   x = vtf2.scity.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"City must be provided\");
				 rv = false;
			   }
			   x = vtf2.szip.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"ZIP or postal code must be provided\");
				 rv = false;
			   }
			   x = vtf2.sphone.value
			   if (x==null || x==\"\") {
				 msg = msg.concat(\"\\r\\n\",\"A phone number must be provided\");
				 rv = false;
			   }
			 }
			 
			 if (vtf2.voicerec.checked)
		   {
			 x = vtf2.csrpin.value
			 
           if (x==null || x==\"\") {
		   console.log('->'+x+'<-');
             msg = msg.concat(\"\\r\\n\",\"Agent PIN number must be provided\");
             rv = false;
           }
           x = vtf2.confnum.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Confirmation number must be provided\");
             rv = false;
           }
           x = vtf2.confpin.value
           if (x==null || x==\"\") {
             msg = msg.concat(\"\\r\\n\",\"Confirmation PIN must be provided\");
             rv = false;
           }
		   x = vtf2.csrpin.value
           if (!(x==null || x==\"\")) {
             if (!isNumber(x)) {
               msg = msg.concat(\"\\r\\n\",\"CSR Pin must be a number when provided\");
               rv = false;
             }
           }
           x = vtf2.confnum.value
           if (!(x==null || x==\"\")) {
             if (!isNumber(x)) {
               msg = msg.concat(\"\\r\\n\",\"Confirmation Number must be a number when provided\");
               rv = false;
             }
           }
           x = vtf2.confpin.value
           if (!(x==null || x==\"\")) {
             if (!isNumber(x)) {
               msg = msg.concat(\"\\r\\n\",\"Confirmation PIN must be a number when provided\");
               rv = false;
             }
           }
		   }
		   
           x = vtf2.shipping.value
           if (!(x==null || x==\"\")) {
             if (!isNumber(x)) {
               msg = msg.concat(\"\\r\\n\",\"Shipping must be a number when provided\");
               rv = false;
             }
           }
           x = vtf2.tax.value
           if (!(x==null || x==\"\")) {
             if (!isNumber(x)) {
               msg = msg.concat(\"\\r\\n\",\"Tax must be a number when provided\");
               rv = false;
             }
           }
           
           if (!rv) {
             alert(msg);
           }
		   console.log('ending validation...');
           return rv;
         }\n";
  print "function recordcall(vtf3) {
    var x = vtf3.voicerec.checked;
    vtf3.csrpin.required = x;
    vtf3.confnum.required = x;
    vtf3.confpin.required = x;
    voicestamps.hidden = !x;
  }\n";
  print "\n-->\n</script>";
}


sub print_search_form {
  my $a = shift;
  $script_name = $query->script_name;
#  $search_script = "$script_name/search";
#  print "<form method=\"post\" name=\"search\", action=\"$search_script\", onsubmit=\"return validateSearchFormData(this)\">";
  print "<form method=\"post\" name=\"search\", action=\"$script_name\" >";
  if (defined $a) {
    if (length($a) > 1) {
      print "<input type=\"hidden\" name=\"vrec\" value =\"vrec\"  />";
    }
  }
  my $m = $query->param('Month');
  my @months = qw(January February March April May June July August September October November December);
  print "<input type=\"hidden\" name=\"source\" value =\"vt\"  />";
  print "<input type=\"hidden\" name=\"search\" value =\"vtsearch\"  />";
  print "Transaction ID: <input type=\"text\" name=\"transactionid\" id=\"transactionid\" style=\"width: 250px\" /><br /><br />";
  print "<table >";
  print "<tr><td style=\"width: 225px\">Month</td><td><select name=\"Month\" style=\"width: 225px\">";
  my ($i,$j);
  for ($i = 0 ; $i < 12 ; $i++ ) {
    $j = $i + 1;
    if (defined $m) {
      my $sel = ($m eq $months[$i]) ? "selected=\"selected\"" : '';
    }
    print "<option value=\"$j\" >$months[$i]</option>";
  }
#  print "<option value=\"1\" selected=\"selected\" >January</option>";
#  print "<option value=\"2\" >February</option>";
#  print "<option value=\"3\" >March</option>";
#  print "<option value=\"4\" >April</option>";
#  print "<option value=\"5\" >May</option>";
#  print "<option value=\"6\" >June</option>";
#  print "<option value=\"7\" >July</option>";
#  print "<option value=\"8\" >August</option>";
#  print "<option value=\"9\" >September</option>";
#  print "<option value=\"10\" >October</option>";
#  print "<option value=\"11\" >November</option>";
#  print "<option value=\"12\" >December</option>
  print "</select></td><td style=\"width: 250px\">Year (yyyy)</td><td><input type=\"text\" name=\"year\" id=\"year\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">First Name</td><td><input type=\"text\" name=\"firstname\" id=\"firstname\" style=\"width: 250px\"  /></td><td style=\"width: 225px\">Last Name</td><td><input type=\"text\" name=\"lastname\" id=\"lastname\" style=\"width: 250px\" /></td></tr>";
  print "<tr><td style=\"width: 225px\">Zip/Postal Code</td><td><input type=\"text\" name=\"bzip\" id=\"bzip\" style=\"width: 250px\" /></td><td style=\"width: 225px\">Phone</td><td><input type=\"text\" name=\"bphone\" id=\"bphone\" style=\"width: 250px\" /></td></tr>";
  print "</table><br /><br />";
#  print $query->submit;
#  print $query->reset("Reset!");
  print "<input type=\"submit\" value=\"Submit\"  style=\"width:150px\"/>";
  print "<input type=\"reset\"  value=\"Reset!\" style=\"width:150px\" />";
  print $query->endform;
}

sub print_results {
  unless (defined $mid) {
    $sql = "SELECT id_merchant FROM user_merchant WHERE id_user = $userid;";
    $sth = $dbh->prepare($sql) or die $dbh->errstr;
    $sth->execute() or die $sth->errstr;
    my ($merchant) = $sth->fetchrow_array;
    $sth->finish;
    $mid = $merchant;
    unless (defined $mid) {
      print "<h1>This form can not be used unless you are a merchant's user!</h1>"; return;
    }
  }
  my $m = $query->param('Month');
  my $m_str = '';
  $m_str = "AND MONTH(transaction_date) = $m" if ((defined $m) && (length($m) > 0));
  my $y = $query->param('year');
  my $y_str = '';
  $y_str  = "AND YEAR(transaction_date) = $y" if ((defined $y) && (length($y) > 0));
  my $fn = $query->param('firstname');
  my $fn_str = '';
  $fn_str = "AND first_name LIKE \'$fn%\'" if ((defined $fn) && (length($fn) > 0));
#  return unless defined $fn;
  my $ln = $query->param('lastname');
  my $ln_str = "AND last_name LIKE \'$ln%\'" if ((defined $ln) && (length($ln) > 0));
  my $zip = $query->param('bzip');
  my $zstr = '';
  $zstr == "AND postal_code = \'$zip%\'" if ((defined $zip) && (length($zip) > 0));
  my $ph = $query->param('bphone');
  my $ph_str = '';
  $ph_str = "AND phone = \'$ph%\'" if ((defined $ph) && (length($ph) > 0));
  my $tid = '';
  $tid = $query->param('transactionid');
  my $sql = "SELECT * FROM transactions JOIN actions ON transactions.transaction_id = actions.transaction_id WHERE merchant_id = $mid $m_str $y_str $fn_str $ln_str $zstr $ph_str";
  $sql .= " AND transactions.transaction_id LIKE \'$tid%\'" if ((defined $tid) && (length($tid) > 0));
  $sql .= " ORDER BY transaction_date DESC LIMIT 100;";
#  open(FOUT, ">> refund.search.debug.txt");
#  print "<h2>$sql</h2>";return;
#  print FOUT $sql,"\n";
#  close(FOUT);
  my $sth = $dbh->prepare($sql) or die $dbh->errstr;
  $sth->execute;
  my @rows;
  my $count = 0;
  while (my $href = $sth->fetchrow_hashref) {
    $count++;
    my $id = $href->{'transaction_id'};
    my $td = $href->{'transaction_date'};
    my $ph = $href->{'phone'};
    my $f = $href->{'first_name'};
    my $l = $href->{'last_name'};
    my $a1 = $href->{'address1'};
    my $a2 = $hred->{'address2'};
    $a2 = ' ' unless defined $a2;
    my $city = $href->{'city'};
    my $s = $href->{'us_state'};
    my $c = $href->{'country'};
    my $z = $href->{'postal_code'};
    my $e = $href->{'email'};
    my $po = $href->{'ponumber'};
    $po = ' ' unless defined $po;
    my $on = $href->{'order_id'};
    my $od = $href->{'order_description'};
    $od = ' ' unless defined $od;
    my $amt = $href->{'amount'};
    my $ac = $href->{'action_type'};
    my $success = $href->{'success'};
    $success = ($success) ? 'SUCCESS' : 'FAILED';
	
	
	
    my @row = ($id,$td,$ac,$success,$amt,$f,$l,$ph,$a1,$a2,$city,$s,$c,$z,$e,$po,$on,$od);
    foreach my $field (@row) {
      $field = ' ' unless defined $field;
    }
    push @rows,\@row;
#    print "<p>$count<br />",join(',',@row),"</p>";
  }
  if ($count == 0) {
    print "<br /><hr /><br /><h1>No results were found for the search parameters provided</h1>";
    return;
  }
  print "<hr /><h3>Search Results</h3>";
  print "<table  id=\"cvrres\" name=\"cvrres\"  class=\"flexme\"><thead><tr><th width=\"140\">Transaction ID<th width=\"150\">Transaction Date</th><th width=\"80\">Transaction<br /> Type</th><th width=\"80\">Status</th><th width=\"60\">Amount</th><th width=\"140\">First Name</th><th width=\"140\">Last Name</th><th width=\"140\">Phone</th><th width=\"140\">Address</th><th width=\"140\">Address (cont.)</th><th width=\"140\">City</th><th width=\"140\">State/Province</th><th width=\"60\">Country</th><th width=\"90\">ZIP or<br /> Postal Code</th><th width=\"140\">Email</th><th width=\"60\">PO Number</th><th width=\"60\">Order ID</th><th width=\"140\">Order Description</th></tr></thead>";
  foreach my $rref (@rows) {
    my @r = @{$rref};
    my $r_str = join('</td><td onclick=getTransRowCVR(this)>',@r);
    print "<tr><td onclick=getTransRowCVR(this)>$r_str</td></tr>";
  }
  print "</table>";
}

sub print_results2 {
  unless (defined $mid) {
    $sql = "SELECT id_merchant FROM user_merchant WHERE id_user = $userid;";
    $sth = $dbh->prepare($sql) or die $dbh->errstr;
    $sth->execute() or die $sth->errstr;
    my ($merchant) = $sth->fetchrow_array;
    $sth->finish;
    $mid = $merchant;
    unless (defined $mid) {
      print "<h1>This form can not be used unless you are a merchant's user!</h1>"; return;
    }
  }
  my $m = $query->param('Month');
  my $m_str = '';
  $m_str = "AND MONTH(transaction_date) = $m" if ((defined $m) && (length($m) > 0));
  my $y = $query->param('year');
  my $y_str = '';
  $y_str  = "AND YEAR(transaction_date) = $y" if ((defined $y) && (length($y) > 0));
  my $fn = $query->param('firstname');
  my $fn_str = '';
  $fn_str = "AND first_name LIKE \'$fn%\'" if ((defined $fn) && (length($fn) > 0));
#  return unless defined $fn;
  my $ln = $query->param('lastname');
  my $ln_str = "AND last_name LIKE \'$ln%\'" if ((defined $ln) && (length($ln) > 0));
  my $zip = $query->param('bzip');
  my $zstr = '';
  $zstr == "AND postal_code = \'$zip%\'" if ((defined $zip) && (length($zip) > 0));
  my $ph = $query->param('bphone');
  my $ph_str = '';
  $ph_str = "AND phone = \'$ph%\'" if ((defined $ph) && (length($ph) > 0));
  my $tid = '';
  $tid = $query->param('transactionid');
  my $sql = "SELECT * FROM transactions JOIN actions ON transactions.transaction_id = actions.transaction_id WHERE merchant_id = $mid $m_str $y_str $fn_str $ln_str $zstr $ph_str";
  $sql .= " AND transactions.transaction_id LIKE \'$tid%\'" if ((defined $tid) && (length($tid) > 0));
  $sql .= " ORDER BY transaction_date DESC LIMIT 100;";
#  print "<h2>$sql</h2>";return;
  my $sth = $dbh->prepare($sql) or die $dbh->errstr;
  $sth->execute;
  my @rows;
  my $count = 0;
  while (my $href = $sth->fetchrow_hashref) {
    $count++;
    my $id = $href->{'transaction_id'};
    my $td = $href->{'transaction_date'};
    my $f = $href->{'first_name'};
    my $l = $href->{'last_name'};
    my $a1 = $href->{'address1'};
    my $a2 = $hred->{'address2'};
    $a2 = ' ' unless defined $a2;
    my $city = $href->{'city'};
    my $s = $href->{'us_state'};
    my $c = $href->{'country'};
    my $z = $href->{'postal_code'};
    my $e = $href->{'email'};
    my $po = $href->{'ponumber'};
    $po = ' ' unless defined $po;
    my $on = $href->{'order_id'};
    my $od = $href->{'order_description'};
    $od = ' ' unless defined $od;
    my $amt = $href->{'amount'};
    my $ac = $href->{'action_type'};
    my $success = $href->{'success'};
    $success = ($success) ? 'SUCCESS' : 'FAILED';
    my $phone = $href->{'phone'};
    my $user = $href->{'mdf_3'};
    $user = '' unless defined $user;
    my $cn = $href->{'mdf_5'};
	
	my $agent_pass = $href->{'mdf_4'};
	my $confnum = $href->{'mdf_5'};
	my $confpin = $href->{'mdf_13'};
	
    $cn  = '' unless defined $cn;
    my @row = ($user,$id,$td,$ac,$success,$amt,$f,$l,$phone,$a1,$a2,$city,$s,$c,$z,$e,$po,$on,$od,$confnum);
    foreach my $field (@row) {
      $field = ' ' unless defined $field;
    }
    push @rows,\@row;
#    print "<p>$count<br />",join(',',@row),"</p>";
  }
  if ($count == 0) {
    print "<br /><hr /><br /><h1>No results were found for the search parameters provided</h1>";
    return;
  }
  print "<h3>Search Results</h3>";
  print "<table id=\"vrec\" name=\"vrec\"  class=\"flexme\" ><thead><tr><th width=\"32\">Done</th><th width=\"60\">User ID</th><th width=\"140\">Transaction ID</th><th width=\"150\">Transaction Date</th><th width=\"60\">Transaction Type</th><th width=\"80\">Status</th><th width=\"80\">Amount</th><th width=\"140\">First Name</th><th width=\"140\">Last Name</th><th width=\"60\">Phone</th><th width=\"140\">Address</th><th width=\"140\">Address (cont.)</th><th width=\"60\">City</th><th width=\"60\">State/Province</th><th width=\"60\">Country</th><th width=\"100\">ZIP or <br />Postal Code</th><th width=\"140\">Email</th><th width=\"60\">PO Number</th><th width=\"60\">Order ID</th><th width=\"140\">Order Description</th>
  <th width=\"140\">Confirmation Number</th>
  </tr></thead>";
  my $source = $query->script_name;
  $source =~ s/cgi-bin\/\/vt.pl/check_graphic2.png/;
  foreach my $rref (@rows) {
    my @r = @{$rref};
    my $img = $source;
    my $len = length($r[19]);
    $img =~ s/check_graphic2.png/redX.jpg/ if ($len < 2);
    my $r_str = join('</td><td onclick=getTransRowVR(this)>',@r);
    print "<tr><td><img src=\"$img\" /></td><td onclick=getTransRowVR(this)>$r_str</td></tr>";
  }
  print "</table>";
}


sub sermepa_subform {
  print "<hr><h1>Enter transaction Result</h1><p>With this mid, you need to charge the transaction, and then, once the transaction is complete, in the new tab that opens, copy the result  for the transaction here, and click 'Save Data'</p>";
  print "<p><label><input type=checkbox name=\"transsuccess\" id=\"transsuccess\" checked=\"checked\" >The transaction was approved (checked indicates true, unchecked, not))</label></p>";
#  print "<p><input type=\"radio\" name=\"transsuccess\" checked=\"checked\"
  print "<table >";
  print "<tr><td>Order Reference Number</td><td><input type=\"text\" name=\"tid\" id=\"tid\"  style=\"width: 250px\" /></td></tr>";
  print "<tr><td>Authorization Code</td><td><input type=\"text\" name=\"authcode\" id=\"authcode\"  style=\"width: 250px\" /></td></tr>";
  print "<tr><td>Authorization Text</td><td><input type=\"text\" name=\"authtext\" id=\"authcode\"  style=\"width: 250px\" /></td></tr>";
  print "</table><hr>";
}

sub print_currency_select {
  my $m = shift;
  my @codes   = all_currency_codes();
  my %cc;
  foreach my $c (@codes) {
    my $n = code2currency($c);
    $cc{$n} = $c;
  }
  my %cr;
  my $rv = get_merchant_currencies($m);
  if ((defined $m) && (defined $rv)) {
    %cr = %$rv;
    print "<select name=\"currency\" id=\"currency\" size=\"1\" >";
    foreach my $n (sort keys %cc) {
      my $code = $cc{$n};
      my $selected = ($code =~ m/USD/) ? ' selected="selected" ' : '';
      print "<option value=\"$code\"$selected>$n ($code)</option>" if (exists $cr{$code});
    }
    print "</select>";
  } else {
    print "<select name=\"currency\" id=\"currency\" size=\"1\" >";
    foreach my $n (sort keys %cc) {
      my $code = $cc{$n};
      my $selected = ($code =~ m/USD/) ? ' selected="selected" ' : '';
      print "<option value=\"$code\"$selected>$n ($code)</option>";
    }
    print "</select>";
  }
}

sub get_merchant_currencies {
  my $mid = shift;
  return unless defined $mid;
  my $sql = "SELECT DISTINCT currency FROM merchant_processors_mid WHERE merchant_id = $mid;";
#  die "$sql\n";
  my $aref = $dbh->selectcol_arrayref($sql);
  my @cur;
  return unless defined $aref;
  @cur = @$aref;
  my $c = @cur;
  return unless $c > 0;
  my %c;
  foreach my $v (@cur) {
    $c{$v} = 1;
  }
  my $rv = \%c;
  return $rv;
}
