<!-- Add Bootstrap CSS and JavaScript CDNs to your HTML file -->
<div class="modal right fade come-from-modal" id="cartModal" tabindex="-1" role="dialog"
  aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-extraFeature" role="document">
    <div class="modal-content modal-content-extraFeature">

      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title fs-3" id="cartModalLabel">Your Cart <span>
          
          </span></h5>
        <span class="close p-1 fs-3" data-dismiss="modal" aria-label="Close">
          <i class="fa-solid fa-xmark"></i>
        </span>
      </div>
      <div class="modal-body" id="cartItems" style="overflow-y:'scroll';">
        <!-- Your cart content goes here -->

      </div>
      <div class="modal-footer">
        <a href="checkout.php"><button type="button" class="btn btn-primary w-100">Checkout</button></a>
      </div>
    </div>
  </div>
  <script src="assets/js/cartModal.js"></script>
</div>