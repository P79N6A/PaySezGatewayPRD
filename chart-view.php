<?php require_once( 'header.php'); 
$iid = $_SESSION['iid'];
require_once('php/inc_chart-view.php');
?>
<script>
    function showAgent(str) {
        if (str == "") {
            document.getElementById("tab-content").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("tab-content").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "php/inc_chart-view.php?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>
<div class="col-lg-10">
    <div class="panel blank-panel">
        <div class="panel-heading">
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="active">
						<a data-toggle="tab" href="#tab-1" onclick="showAgent('affinfo')" aria-expanded="true">Sales & Refunds</a>
                    </li>
                    <li class="">
						<a data-toggle="tab" href="#tab-2" onclick="showAgent('accinfo')" aria-expanded="false">Transaction Count</a>
                    </li>
                    <li class="">
						<a data-toggle="tab" href="#tab-3" onclick="showAgent('processors')" aria-expanded="true">CHarge Backs</a>
                    </li>
                    <li class="">
						<a data-toggle="tab" href="#tab-4" onclick="showAgent('fee')" aria-expanded="false">Charge Back Ratio By Volume</a>
                    </li>
                    <li class="">
						<a data-toggle="tab" href="#tab-5" onclick="showAgent('affstatus')" aria-expanded="false">Charge Back / Decline Reasons</a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="tab-content" id="tab-content">
			<?php echo getAffInfo($_SESSION['iid']); ?>
			</div>
        </div>
	</div>
</div>
<?php require_once( 'footerjs.php'); ?>
<?php require_once( 'footer.php'); ?>