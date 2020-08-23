<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$purchase_return = new PurchaseReturn;
	$vendor = new Vendor;
	$products = new Product;
	$warehouses = new Warehouse;
	$return_reason = new Returnreason;
		
	if(partial_access('admin') || $store_access->have_module_access('returns')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	

	if(isset($_POST['edit_purchase'])){ $page_title = 'Edit Sale Return'; } else { $page_title = 'Add Purchase Return';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
?>

<?php if(isset($_GET['purchase_rt_id'])) { ?>
	<script type="text/javascript">
		window.open('reports/view_purchase_return_invoice.php?purchase_rt_id=<?php echo $_GET['purchase_rt_id']; ?>', '_blank'); 
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
<form action="includes/process_purchase_return.php" method="post">
      <div class="row">              
        <div class="col-sm-5">
        <table border="0" cellpadding="5">
        	<tr>
            	<td width="110">Date</td>
                <td width="300"><input type="text" name="date" class="form-control datepick" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" /></td>
            </tr>
            
            <tr>
            	<td>S.Inv#</td>
                <td><input type="text" placeholder="Sale Invoice number" name="purchase_inv_no" class="form-control" /></td>
            </tr>
            
            <tr>
            	<td>Memo</td>
                <td><textarea placeholder="Memo" name="memo" class="form-control"></textarea></td>
            </tr>
            
            <tr>
            	<th>Select Vendor</th>
                <td>
                	<select name="vendor_id" id="vendor_id" class="autofill" style="width:100%">
                    <option value="">Select Vendor by full name or mobile</option>
                    <?php $vendor->vendor_options($vendor->vendor_id); ?>	
                    </select>	
                </td>
            </tr>
            
            <tr>
            	<th>Return Reason</th>
                <td>
                	<select name="reason_id" id="reason_id" class="autofill" style="width:100%">
                    <option value="">Select Return Reason</option>
                    <?php 
						//accept parameter in case of edit.
						$return_reason->reason_options('0'); ?>	
                    </select>	
                </td>
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
	   var warehouse_id = $("#warehouse_id").val();
	   
	   var total_p = quantity*cost;
	   
	   var content_1 = "<tr class='item-row'><td><div class='delete-wpr'>"+product_manual_id+"<input type='hidden' name='product_id[]' value='"+product_id+"'><a class='delme' href='javascript:;' title='Remove row'>X</a></div></td>";
	   var content_2 = "<td>"+product_name+"</td>";
	   var content_3 = "<td><input type='text' readonly='readonly' class='qty' name='qty[]' value='"+quantity+"'></td>";
	   var content_4 = "<td><input type='text' readonly='readonly' class='cost' name='cost_p[]' value='"+cost+"'></td>";
	   var content_5 = "<td>"+warehouse_name+"<input type='hidden' name='warehouse_id[]' value='"+warehouse_id+"'></td>";
	   var content_6 = 	"<td class='total'>"+total_p+"</td></tr>";   
	   
	   $(".item-row:first").before(content_1+content_2+content_3+content_4+content_5+content_6);
	   
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
			var vendor_id = $('#vendor_id').val();
			var reason_id = $('#reason_id').val();
			var product_id = $("#product_id").val();
	  	 	var quantity = $("#quantity").val();
	   		var cost = $("#cost").val();
			
			if(vendor_id == '' || vendor_id == 0) { 
				alert('Please select vendor.');
			} else if(reason_id == '' || reason_id == 0) { 
				alert('Please select return reason.');
			} else if(product_id == '' || quantity == '' || cost == '') { 
				alert('Please set product, quantity, selling price.');
			} else { 
				//if client id and reason id is set this will proceed.
				getProduct();
			}
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
                    <td>Select Warehouse</td>
                    <td>
                    	<select name="warehouse" id="warehouse_id" class="autofill" style="width:400px;">
                    		<option value="0">Select Warehouse</option>
                        	<?php $warehouses->warehouse_options($warehouses->warehouse_id); ?>
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
                    <th width="60">Price</th>
                    <th>Warehouse</th>
                    <th>Total</th>
                </tr>
                
                <tr class='item-row'>
                    <td colspan="6">Invoice items</td>
                </tr>
            </table>
        </div>
        <div class="col-sm-3">
        	<div class="well">
            	<h4>Grand Total: <span id="grand_total">0.00</span></h4>
        		<h5>Payment Method</h5>
                <select name="payment_method" class="form-control">
                	<option value="0">Select receiving method</option>
                    <option value="credit">Invoice return</option>
                    <option value="cash">Cash Refund</option>
                </select><br />
            <input type="submit" class="btn btn-primary" name="save" value="Save" /> &nbsp;<input type="submit" class="btn btn-primary" name="print" value="Print" />
        	</div>
        </div>
    </div><!--product_Detail_row ends here.-->
    </form>
                       
<?php
	require_once("includes/footer.php");
?>