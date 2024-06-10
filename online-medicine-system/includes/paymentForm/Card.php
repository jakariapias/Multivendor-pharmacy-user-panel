<!-- <div class="card">
    <div class="card-header">
        Visa Card Payment Details
    </div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label for="cardNumber">Visa Card Number</label>
                <input type="text" class="form-control" id="cardNumber" placeholder="Enter Visa card number" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="expiryDate">Expiry Date</label>
                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="cvv">CVV</label>
                    <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cardHolder">Card Holder Name</label>
                <input type="text" class="form-control" id="cardHolder" placeholder="Enter card holder name" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
        </form>
    </div>
</div> -->

<form role="form" action="php_backend/order/order_confirm.php" method="post">
   <input type="text" name="pharmacy_id_list" value=<?=implode(",", $pharmacy_id_list)?> class="d-none" >
   <input type="text" name="user_id" value=<?=$userId?> class="d-none">
   <input type="text" name="payment_method" value="card" class="d-none">
    <div class="form-group">
        <label for="username">Full name (on the card)</label>
        <input type="text" name="username" placeholder="Your name.." required class="form-control" required>
    </div>
    <div class="form-group my-3">
        <label for="cardNumber">Card number</label>
        <div class="input-group">
            <input type="text" name="cardNumber" placeholder="Your card number" class="form-control" required>
            <div class="input-group-append ">
                <span class="input-group-text text-muted" style="min-height:39px;">
                    <i class="fa-brands fa-cc-visa fs-6"></i>
                    <i class="fa-brands fa-cc-amex mx-2 fs-6"></i>
                    <i class="fa-brands fa-cc-mastercard fs-6"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label><span class="hidden-xs">Expiration</span></label>
                <div class="input-group">
                    <input type="number" placeholder="MM" name="MM" class="form-control" required>
                    <input type="number" placeholder="YY" name="YY" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group mb-4">
                <label data-toggle="tooltip" title="Three-digits code on the back of your card">CVV
                    <i class="fa fa-question-circle"></i>
                </label>
                <input type="text" required class="form-control" name="CVV">
            </div>
        </div>
    </div>
    <button type="submit" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm w-100">
        Confirm </button>
</form>