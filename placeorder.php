<?php

	include("include/header.php");
	include_once("include/connect.php");
	$ur = $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$user_id = $_SESSION['user_id'];
	
		$size = sizeof($_POST);
		if($size>0)
		{
			$session_data=$_POST;
			$_SESSION['data']=$session_data;
		}
		else
		{
			$session_data= $_SESSION['data'];
		}
	
	  $delivery_center = $_SESSION['data']['delivery_center'];
	  $delivery_center1 = $_SESSION['data']['delivery_center1'];
	  
	if($delivery_center != "")
	{	
		if(isset($_SESSION['data']['educational_institute_name']))
		{
			$educational_institute_name = $_SESSION['data']['educational_institute_name'];
		}
		else
		{
			$educational_institute_name = "";
		}
		if(isset($_SESSION['data']['student_name']))
		{
			$student_name = $_SESSION['data']['student_name'];
		}
		else
		{
			$student_name = "";
		}
		if(isset($_SESSION['data']['class']))
		{
			$class = $_SESSION['data']['class'];
		}
		else
		{
			$class = "";
		}
		if(isset($_SESSION['data']['section']))
		{
			$section = $_SESSION['data']['section'];
		}
		else
		{
			$section = "";
		}
		if(isset($_SESSION['data']['roll_no']))
		{
			$roll_no = $_SESSION['data']['roll_no'];
		}
		else
		{
			$roll_no = "";
		}
		if(isset($_SESSION['data']['organisation_name']))
		{
			$organisation_name = $_SESSION['data']['organisation_name'];
		}
		else
		{
			$organisation_name = "";
		}
		$delivery_plot_no = $_SESSION['data']['delivery_plot_no'];
		$delivery_area_village = $_SESSION['data']['delivery_area_village'];
		$delivery_post = $_SESSION['data']['delivery_post'];
		$delivery_land_mark = $_SESSION['data']['delivery_land_mark'];
		$delivery_country_id = $_SESSION['data']['delivery_country_id'];
		$delivery_state_id = $_SESSION['data']['delivery_state_id'];
		$delivery_dist = $_SESSION['data']['delivery_dist'];
		$delivery_pin = $_SESSION['data']['delivery_pin'];
		$delivery_city = $_SESSION['data']['delivery_city'];
	}
	if($delivery_center1 == "Shree_Ganesh_Delivery_Center")  
	{	
		$delivery_outlet_code = $_SESSION['data']['delivery_outlet_code'];
		$delivery_outlet_name= $_SESSION['data']['delivery_outlet_name'];
	}

	 $sql5 = "select * from customer_registration where email='$user_id'";
	 $res5 = mysql_query($sql5);
	 $row5 = mysql_fetch_array($res5);
	 
	 $sql1 = "SELECT * FROM  `area_wise_shipping` WHERE  `area_pin_code` =  '$delivery_pin'";
     $res1 = mysql_query($sql1);
     $row1 = mysql_fetch_array($res1);
	
	 $area = $row1['area_name'];
	 $shipping_per_gram = $row1['shipping_per_gram'];
	 $min_shipping_charges = $row1['min_shipping_charges'];
	
?>
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<?php
			include("include/side_menu.php");
				?>
			<!--left content column-->
			
			<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
				<h2 class="tt_uppercase color_dark m_bottom_20">Place Order</h2>
				<div class="table_box5">
				<form method="post" action="delivery_action.php">
				<input type="hidden" name="pincode1" value="<?php echo $delivery_pin;?>" />
				<input type="hidden" name="educational_institute_name" value="<?php echo $educational_institute_name;?>" />
				<input type="hidden" name="student_name" value="<?php echo $student_name;?>" />
				<input type="hidden" name="class" value="<?php echo $class;?>" />
				<input type="hidden" name="section" value="<?php echo $section;?>" />
				<input type="hidden" name="roll_no" value="<?php echo $roll_no;?>" />
				<input type="hidden" name="organisation_name" value="<?php echo $organisation_name;?>" />
				<input type="hidden" name="delivery_plot_no" value="<?php echo $delivery_plot_no;?>" />
				<input type="hidden" name="delivery_area_village" value="<?php echo $delivery_area_village;?>" />
				<input type="hidden" name="delivery_post" value="<?php echo $delivery_post;?>" />
				<input type="hidden" name="delivery_land_mark" value="<?php echo $delivery_land_mark;?>" />
				<input type="hidden" name="delivery_country_id" value="<?php echo $delivery_country_id;?>" />
				<input type="hidden" name="delivery_state_id" value="<?php echo $delivery_state_id;?>" />
				<input type="hidden" name="delivery_dist" value="<?php echo $delivery_dist;?>" />
				<input type="hidden" name="delivery_pin" value="<?php echo $delivery_pin;?>" />
				<input type="hidden" name="delivery_center" value="<?php echo $delivery_center;?>" />
				<input type="hidden" name="delivery_center1" value="<?php echo $delivery_center1;?>" />
				<input type="hidden" name="delivery_city" value="<?php echo $delivery_city;?>" />
				<input type="hidden" name="delivery_outlet_code" value="<?php echo $delivery_outlet_code;?>" />
				<input type="hidden" name="delivery_outlet_name" value="<?php echo $delivery_outlet_name;?>" />
			<div class="table-responsive m_top_20">	
			  <table class="table table-bordered">
				<thead class="text-center">
				  <tr>
					<th>Sl No</th>
					<th>Product Code</th>
					<th>Product Name</th>
					<th>Product Image</th>
					<th>Quantity</th>
					<th>Product Price</th>
					<th>Total</th>
					<th>Shipping Charge</th>
					<th>Sub Total</th>
                    <th>Ogst</th>
                    <th>Cgst</th>
					<th>Igst</th>
					<th>Total Tax</th>
					<th>Grand Total</th>
					<th>Cancel</th>
				  </tr>
				</thead>
				<tbody>
					<?php 
						$cart_items = 1;
						$f_total = 0;
						$weight = 0;
						$f_weight = 0;
						$f_shipping = 0;
						$s_total = 0;
						$f_tax = 0;
						$f_sub_total = 0;
					
					foreach ($_SESSION["products"] as $cart_itm)
					{	
						
						$product_code = $cart_itm["code"];
						$results = mysql_query("SELECT * FROM products WHERE product_code='$product_code' LIMIT 1");
						$row = mysql_fetch_array($results);
						$category_id = $row['category_id'];
						$subcategory_id = $row['subcategory_id'];
						$price = $row['price'];
						$product_id = $row['id'];
						@$quantity = $cart_itm["qty"];
						
						
						$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
						$total = ($total + $subtotal);
							
				
						$sql2 = "SELECT * FROM `products` WHERE `id`='$product_id'";
						$res2 = mysql_query($sql2);
						$row2 = mysql_fetch_array($res2);
						
						$weight += $row2['weight_in_gram']*$quantity;
						
						
						if($weight <= 1000)
						{
							$s_charge = $min_shipping_charges;
						}
						else if($weight > 1000)
						{
							$s_charge1 = $min_shipping_charges;
							$rest_weight = $weight-1000;
							$s_charge2 = ($rest_weight*$shipping_per_gram)/100;
							
							$s_charge = $s_charge1+$s_charge2;
						}
						
						
						if($delivery_state_id == 1 || $delivery_state_id == 'ODISHA' || $delivery_center1 == "Shree_Ganesh_Delivery_Center")
						{
							$ogst = $row2['tax'];
							$cgst = $row2['cgst'];
							$igst = 0;
						}
						else
						{
							$ogst = 0;
							$cgst = 0;
							$igst = $row2['igst'];
						}
						
						$gst = $ogst+$cgst+$igst;
						
						$s_charge_pergram = $s_charge/$weight;	
						$total_weight = $row2['weight_in_gram']*$quantity;
						$total_shipping = $s_charge_pergram*$total_weight;
						$total = $row2['price']*$quantity;
						$total_tax = ($total+$total_shipping)*$gst/100;
						$sub_total = $total+$total_shipping+$total_tax;
						$sub_total1 = $total + $total_shipping;
						$shipping_charge = $subtotal + $total_shipping;
						
						
						$f_total += $total;
						$f_weight += $total_weight;
						$f_shipping += $total_shipping;
						$s_total += $sub_total1; 
						$f_tax += $total_tax;
						$f_sub_total += $sub_total;
											
						$product_code = $cart_itm["code"];
						$results = mysql_query("SELECT * FROM products WHERE product_code='$product_code' LIMIT 1");
						$row = mysql_fetch_array($results);
						
						$total_weight = ($row["weight_in_gram"]*$cart_itm["qty"]);
						$category_id = $row['category_id'];
						$subcategory_id = $row['subcategory_id'];
						$price = $row['price'];
						$product_id = $row['id'];
						
						@$f_weight += $total_weight;
						$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
						$total = ($total + $subtotal);
					?>
				  <tr>
							<td><?php echo $cart_items;?></td>
							<!--product name and category-->
							<td>
							<p class="default_t_color"><?php echo $row['product_code'];?></p>
							</td>
							<!--product price-->
							<td>
								<p class="default_t_color"><?php echo $row['product_name'];?></p>
							</td>
							<!--quanity-->
							<td>
								<img src="logo/<?php echo $row['product_img_name']; ?>" width="50">
							</td>
							<!--add or remove buttons-->
							<td>
								<p class="default_t_color"><?php echo $cart_itm["qty"];?></p>
							</td>
							<td>
								<p class="default_t_color"><?php echo $row['price'];?></p>
							</td>
							<td>
								<p class="default_t_color"><?php echo $subtotal;?></p>
							</td>
							<td>
								<p class="default_t_color"><?php echo number_format($total_shipping,2);?></p>
							</td>
							<td>
								<p class="default_t_color"><?php echo number_format($shipping_charge,2);?></p>
							</td>
                            <td>
								<p class="default_t_color"><?php echo $ogst;?>%</p>
							</td>
                            <td>
								<p class="default_t_color"><?php echo $cgst;?>%</p>
							</td>
							<td>
								<p class="default_t_color"><?php echo $igst;?>%</p>
							</td>
							<td>
								<p class="default_t_color"><?php echo number_format($total_tax,2);?></p>
							</td>
							<td>
								<p class="default_t_color"><?php echo number_format($sub_total,2);?></p>
							</td>
							<td>
								<a href="cart_update.php?removep=<?php echo $cart_itm["code"];?>&return_url=<?php echo $current_url;?>" class="color_dark"><i class="fa fa-times m_right_5"></i> Remove</a>
							</td>
				  </tr>
				  <?php
					$cart_items ++;
                       }
				  ?>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php echo $f_total; ?></td>
					<td><?php echo number_format($f_shipping,2); ?></td>
					<td><?php echo number_format($s_total,2); ?></td>
					<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td><?php echo $f_tax; ?></td>
					<td><?php echo number_format($f_sub_total,2); ?></td>
					<td></td>
					<input type="hidden" name="grand_total" value="<?php echo $f_sub_total; ?>">
					<input type="hidden" name="pincode" value="<?php echo $delivery_pin; ?>">
				  </tr>
				  
				</tbody>
			  </table>
			</div>
			 <div class="col-md-6">
				 <div class="col-md-6 m_top_5">
						<div class="form-group">
							<input type="submit" name="submit" value="Payment Details" class="button_type_4 tr_all_hover r_corners f_left bg_scheme_color color_light f_mxs_none m_mxs_bottom_15">
						</div>
				  </div>
				  <div class="col-md-6 m_top_5">
					 
				  </div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6 m_top_5">
					
				  </div>
				  <div class="col-md-6 m_top_5">
					  <p><a href="index.php"><< Continue Shopping</a></p>
				  </div>
			</div>
			</form>
			 <div class="clear_fix"></div>
		</div>
				<!--alert boxex-->
				
			</section>
			<!--right column-->
			
		</div>
	</div>
</div>
		<br />
<?php
	include("include/footer.php");
?>			