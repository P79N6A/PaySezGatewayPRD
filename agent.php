<?php 
  require_once('header.php'); 
  if(!checkPermission('A'))
    include_once('forbidden.php');
?>       

<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#select1").change(function () {
    if ($(this).data('options') == undefined) {
        /*Taking an array of all options-2 and kind of embedding it on the select1*/
        $(this).data('options', $('#select2 option').clone());
    }
    var id = $(this).val();
    var options = $(this).data('options').filter('[value=' + id + ']');
    $('#select2').html(options);
});
});//]]>  

</script>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
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
                document.getElementById("affiliate-information").innerHTML = xmlhttp.responseText;
            }
        }     
        xmlhttp.open("GET","affiliate-information.php?q="+str,true);
        xmlhttp.open("GET","account-information.php?q="+str,true);
        xmlhttp.open("GET","processors.php?q="+str,true);
        xmlhttp.open("GET","fee-sechedule.php?q="+str,true);
        xmlhttp.open("GET","affiliate-status.php?q="+str,true);  
        xmlhttp.send();
    }
}
</script>


<div class="col-lg-10">
                    <div class="panel blank-panel">

                        <div class="panel-heading">
                            
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Affiliate Information</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Account Information</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="true">Proccessors</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Fee Schedule</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-5" aria-expanded="false">Affiliate Status</a></li>
                                    
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                
                                
                                
                                
                                 <!--tabcontent-->
                                 
                                 
                                
                                 
                                 
                                 <!---tabcontent-->
                                  
                               
                                 
                                </div>
     
                                <div id="tab-2" class="tab-pane">
                                   <div class="col-md-4">

                                   <label>User Name</label>
                                <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                          </div>
                                 <div class="form-group"><div class="col-lg-4">

                              <label>Password</label>
                             <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                         </div>
                              </div>
        
                           <div class="form-group"><div class="col-lg-4">
                               </br>
                            <button class="btn btn-primary" type="button"><i class="fa fa-check"></i>&nbsp;Login</button>

                                     </div>
        
        
        
        

                                </div>
                            </div>

                                <div id="tab-3" class="tab-pane">
                                   <div class="col-md-4">

                                   <label>User Name</label>
                                <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                          </div>
                                 <div class="form-group"><div class="col-lg-4">

                              <label>Password</label>
                             <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                         </div>
                              </div>
        
                           <div class="form-group"><div class="col-lg-4">
                              
                            

                                     </div>
                                     
                                     
                                         <div id="tab-4" class="tab-pane">
                                   <div class="col-md-4">

                                   <label>User Name</label>
                                <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                          </div>
                                 <div class="form-group"><div class="col-lg-4">

                              <label>Password</label>
                             <input id="user_name" name="user_name" type="text" class="form-control required" aria-required="true">
                         </div>
                              </div>
        
                           <div class="form-group"><div class="col-lg-4">
                               </br>
                            

                                     </div>


                        </div>

                    </div>
                </div>
                
                
                

      
    </div>
</div>
</div>                
        
        
        
        
<?php include 'affilaite-inofrmation.php'; ?>
<?php include 'account-inofrmation.php'; ?>
<?php include 'proccesors-inofrmation.php'; ?>
<?php include 'feee-sechedule.php'; ?>
<?php include 'affilaite-status.php'; ?>
<div id="txtHint">  </div>        
                
            
<?php require_once('footerjs.php'); ?>
<?php require_once('footer.php'); ?>
