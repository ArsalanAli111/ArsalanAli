<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
		
	if(partial_access('admin') || $store_access->have_module_access('purchase')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	

	if(isset($_POST['edit_purchase'])){ $page_title = 'Edit Purchase'; } else { $page_title = 'Add Purchase';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
?>

<?php if(isset($_GET['purchase_id'])) { ?>
	<script type="text/javascript">
		window.open('reports/view_purchase_invoice.php?purchase_id=<?php echo $_GET['purchase_id']; ?>', '_blank'); 
	</script>
<?php } ?>
<?php
//display message if exist.
	if(isset($_GET['message']) && $_GET['message'] != '') { 
		echo '<div class="alert alert-success">';
		echo $_GET['message'];
		echo '</div>';
	}
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
<style type="text/css">
textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delme:hover { background-color:#EEFF88; }

#items input[type=text] {width:60px;border:0px;}
.delete-wpr { position: relative; }
.delme { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }
</style>                    

<script type="text/javascript">
jQuery(function($) {
	$('form[data-async]').on('submit', function(event) {
		
		var $form = $(this);
		var $target = $($form.attr('data-target'));

		$.ajax({
			type: $form.attr('method'),
			url: 'includes/otherprocesses.php',
			data: $form.serialize(),
			dataType: 'json',
 
		success: function(response) {
			var message = response.message;
			var vendor_options = response.vendor_options;
			var vendor_id = response.vendor_id;
			
			$('#vendor_options').html(vendor_options);
			$("#vendor_options").select2().select2('val', vendor_id);
			$('#success_message').html('<div class="alert alert-success">'+message+'</div>');
		}
	});
	event.preventDefault();
});
});
</script>				
<!-- Add new vendor modal starts here. -->
<div class="modal fade" id="addnewvendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add new vendor</h4>
      </div>
     	
         <div class="modal-body">
         <form data-async data-target="#addnewvendor" method="POST" enctype="multipart/form-data" role="form">
         <div id="success_message"></div>
         		<table style="width:100%;">
                	<tr>
                    	<td>
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="full_name" value="" placeholder="Full name of business" required="required" />
                      </div>
                      		</td>
                            <td>
                      <div class="form-group">
                        	<label class="control-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="" />
                      </div>
                      	</td>
                        </tr>
                        <tr>
                        <td>
                      <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" value="" />
                      </div>
                      </td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" value="" />
                      </div>
                      </td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="" />
                      </div>
                      </td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="" />
                      </div>
                      </td>
                      <td>
				     <div class="form-group">
                        	<label class="control-label">Provider of</label>
                            <input type="text" class="form-control" name="provider_of" placeholder="Provider Of" value="" />
                      </div>
                      </td>
                      </tr>
                      </table>	
						<input type="hidden" name="add_vendor" value="1" />
                         <input type="submit" id="submit" class="btn btn-primary" value="Add vendor">
                      </form>   
                              </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--add new vendor modal ends here.-->

<form action="includes/process_purchase.php" method="post">
      <div class="row">              
        <div class="col-sm-5">
        <table border="0" cellpadding="5">
        	<tr>
            	<td width="110">Date</td>
                <td width="300"><input type="text" name="date" class="form-control datepick" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" /></td>
            </tr>
            
            <tr>
            	<td>Supp Inv#</td>
                <td><input type="text" placeholder="Supplier Invoice number" name="supp_inv_no" class="form-control" /></td>
            </tr>
            
            <tr>
            	<td>Memo</td>
                <td><textarea placeholder="Memo" name="memo" class="form-control"></textarea></td>
            </tr>
            
            <tr>
            	<th>Select Vendor</th>
                <td>
                	<select id="vendor_options" name="vendor_id" class="autofill" style="width:100%">
                    	<option value=''>Select Vendor (By full name or Phone#)</option>
                    	<?php echo $vendor->vendor_options($vendor->vendor_id); ?>	
                    </select>	
                </td>
            </tr>
            
            <tr>
            	<td>&nbsp;</td>
                <td><a class="btn btn-default btn-xs" data-toggle="modal" href="#addnewvendor">Add new Vendor</a></td>
            </tr>
            
        </table>
       </div><!--left-side-form ends here.-->
       
<script type="text/javascript">
function update_total() { 
	var grand_total = 0;
	
	i = 1;	
	$('.total').each(function(i) {
        var total = $(this).html();
		
		total = parseFloat(total);
		
		grand_total = total+grand_total;
    });
	$('#grand_total').html(grand_total.toFixed(2));
	
}//Update total function ends here.

function hy(){
    var grnd = 0;
  
  i = 1;  
  $('.total').each(function(i) {
        var total = $(this).html();
    
    total = parseFloat(total);
    
    grnd = total+grnd;
    });
    
    var gr = grnd/100;
    var b = document.getElementById("dis_sale").value;
    var th = gr*b;
     var gh = parseFloat(grnd-th);
     

     $('#grand_total').html(gh.toFixed(2));

  }

  function hyd(){
    var grnd = 0;
  
  i = 1;  
  $('.total').each(function(i) {
        var total = $(this).html();
    
    total = parseFloat(total);
    
    grnd = total+grnd;
    });
    var bd = document.getElementById("grand_total").value;
    
    var gr = grnd/100;
    var b = document.getElementById("dis_sale").value;
    var th = gr*b;
     var gh = parseFloat(grnd-th);
    var bd = document.getElementById("dis_sol").value;
    
   
     var nyh = parseFloat(gh-bd);


           

     $('#grand_total').html(nyh.toFixed(2));

  }

function getProduct() {
	$.ajax({
	 data: {
	  product_id: $("#product_id").val(),
	  warehouse_id: $("#warehouse_id").val()
	 },
	 type: 'POST',
	 dataType: 'json',
	 url: 'includes/get_purchase_data.php',
	 success: function(response) {
	   var product_name = response.product_name;
	   var product_manual_id = response.product_manual_id;
	   var warehouse_name = response.warehouse_name;
	   
	   var product_id = $("#product_id").val();
	   var quantity = $("#quantity").val();
	   var cost = $("#cost").val();
     var bonus_id = $("#bonus_id").val();    
     var warehouse_id = $("#warehouse_id").val();
	   var discount = $("#discount").val();
	   
	   var content_1 = "<tr class='item-row'><td><div class='delete-wpr'>"+product_manual_id+"<input type='hidden' name='product_id[]' value='"+product_id+"'><a class='delme' href='javascript:;' title='Remove row'>X</a></div></td>";
	   var content_2 = "<td>"+product_name+"</td>";
	   var content_3 = "<td><input type='text' readonly='readonly' class='qty' name='qty[]' value='"+quantity+"'></td>";
	   var content_4 = "<td><input type='text' readonly='readonly' class='cost' name='cost[]' value='"+cost+"'></td>";
	   var content_5 = "<td><input type='text' readonly='readonly' class='discount' name='discount[]' value='"+discount+"'>"+"<input type='hidden' name='warehouse_id[]' value='"+warehouse_id+"'></td>";
     var content_6 = "<td>"+bonus_id+"<input type='hidden' name='bonus_id[]' value='"+bonus_id+"'></td>";
      var gr_total= cost*quantity;
      var to = gr_total/100;
     var new_to = to*discount;
     var ok = gr_total-new_to;
	   var content_7 = 	"<td class='total'>"+ok+"</td></tr>";   
	   
	   $(".item-row:first").before(content_1+content_2+content_3+content_4+content_5+content_6+content_7);
	   
	   $("#product_id").select2("val", null);
	   $("#quantity").val('');
	   $("#cost").val(''); 
	   $("#warehouse_id").select2("val", null);
	   update_total();
	   }
	});
}
	$(document).ready(function(e) {
    	$("#add_product").click(function() {
			getProduct();
		});    
	//delete Row.
	$('#items').on('click', '.delme', function() {
		   $(this).parents('.item-row').remove();
		   update_total();
		});
    });
	
</script>
       <div class="col-sm-7">
       		<h4>Add Product</h4>
            <table border="0" cellpadding="5">
				<tr>
                    <td>Select Product</td>
                    <td width="400">
                    <select name="product" id="product_id" style="width:400px;" class="autofill">
                        <option value="">Select Item ID or Name</option>
                        <?php $products->product_options($products->product_id); ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td width="400">
                    	<input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" />
                    </td>
                </tr>
                <tr>
                    <td>Cost</td>
                    <td width="400">
                    	<input type="text" name="cost" id="cost" class="form-control" placeholder="Enter cost" />
                    </td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td>
                      <input type="text" name="bonus_id" id="bonus_id" class="form-control" placeholder="Enter Bonus" />
                     
                    </td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>
                      <input type="text" name="discount" id="discount" class="form-control" placeholder="Enter Discount" />
                     
                    </td>
                </tr>
                
                <tr style="display: none;">
                    <td>Select Warehouse</td>
                    <td>
                    	<select name="warehouse" id="warehouse_id" class="autofill" style="width:400px;">
                    		<option value="0">Select Warehouse</option>
                        	<?php $warehouses->warehouse_options(get_option($_SESSION['store_id'].'_default_warehouse')); ?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td><div id="add_product" class="btn btn-default">Add product</div></td>
                </tr>
            </table>
       </div><!--add product Section-->
	</div><!--row ends here.-->
    <br />
    <div class="row">
    	<div class="col-sm-9">
        	<table id="items" class="table table-condensed table-hover table-bordered">
            	<tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th width="60">Qty</th>
                    <th width="60">Cost</th>
                    <th>Dis</th>
                    <th>Bonus</th>
                    
                    <th>Total</th>
                </tr>
                
                <tr class='item-row'>
                    <td colspan="7">Invoice items</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-3">
        	<div class="well">
            
            	
        		<h5>Payment Method</h5>
                <select name="payment_method" class="form-control">
                	<option value="0">Select payment method</option>
                    <option value="credit">Credit</option>
                    <option value="cash">Cash</option>
                </select>
<h5>Discount</h5>
                <input type="text" id="dis_sale" onkeyup="hy()" class="form-control" name="dis_sale">
                
                <h5>Extra Charges</h5>
                <input type="text" id="dis_sol" onkeyup="hyd()" class="form-control" name="dis_sol">
                <br>
                <h4>Grand Total: <span id="grand_total">0.00</span></h4>
            <input type="submit" class="btn btn-primary" name="save" value="Save" /> &nbsp;<input type="submit" class="btn btn-primary" name="print" value="Print" />
        	</div>
        </div>
    </div><!--product_Detail_row ends here.-->
    </form>
                       
<?php
	require_once("includes/footer.php");
?>