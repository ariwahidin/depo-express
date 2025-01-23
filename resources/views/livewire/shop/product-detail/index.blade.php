<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Checkout</h5>
        <!-- Bcak button -->
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group" role="group" aria-label="First group">
                <a href="javascript:window.history.back();" class="btn btn-primary"><i class="ti ti-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="bs-stepper">
            <div class="bs-stepper-content">
                <form id="wizard-checkout-form" onsubmit="return false">
                    <!-- Confirmation -->
                    <div id="checkout-confirmation" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                        <div class="row mb-6">
                            <div class="col-12">
                                <ul class="list-group list-group-horizontal-md">
                                    <li class="list-group-item flex-fill p-6 text-body">
                                        <h6 class="d-flex align-items-center gap-2"><i class="ti ti-map-pin"></i> Shipping</h6>
                                        <address class="mb-0">
                                            John Doe <br>
                                            4135 Parkway Street,<br>
                                            Los Angeles, CA 90017,<br>
                                            USA
                                        </address>
                                        <p class="mb-0 mt-4">
                                            +123456789
                                        </p>
                                    </li>
                                    <li class="list-group-item flex-fill p-6 text-body">
                                        <h6 class="d-flex align-items-center gap-2"><i class="ti ti-credit-card"></i> Billing Address</h6>
                                        <address class="mb-0">
                                            John Doe <br>
                                            4135 Parkway Street,<br>
                                            Los Angeles, CA 90017,<br>
                                            USA
                                        </address>
                                        <p class="mb-0 mt-4">
                                            +123456789
                                        </p>
                                    </li>
                                    <li class="list-group-item flex-fill p-6 text-body">
                                        <h6 class="d-flex align-items-center gap-2"><i class="ti ti-ship"></i> Shipping Method</h6>
                                        <p class="fw-medium mb-4">Preferred Method:</p>
                                        Standard Delivery<br>
                                        (Normally 3-4 business days)
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Confirmation items -->
                            <div class="col-xl-9 mb-6 mb-xl-0">
                                <ul class="list-group">
                                    <li class="list-group-item p-6">
                                        <div class="d-flex gap-4">
                                            <div class="flex-shrink-0">
                                                <img src="../../assets/img/products/2.png" alt="google home" class="w-px-75">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <a href="javascript:void(0)">
                                                            <h6 class="mb-2">Apple iPhone 11 (64GB, Black)</h6>
                                                        </a>
                                                        <div class="text-body mb-2 d-flex flex-wrap"><span class="me-1">Sold by:</span> <a href="javascript:void(0)">Apple</a></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-md-end">
                                                            <div class="my-2 my-lg-6"><span class="text-primary">$299/</span><s class="text-muted">$359</s></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- Confirmation total -->
                            <div class="col-xl-3">
                                <div class="border rounded p-6">
                                    <!-- Price Details -->
                                    <h6>Price Details</h6>
                                    <dl class="row mb-0 text-heading">

                                        <dt class="col-6 fw-normal">Order Total</dt>
                                        <dd class="col-6 text-end">$1198.00</dd>

                                        <dt class="col-sm-6 text-heading fw-normal">Delivery Charges</dt>
                                        <dd class="col-sm-6 text-end"><s class="text-muted">$5.00</s> <span class="badge bg-label-success ms-1">Free</span></dd>
                                    </dl>
                                    <hr class="mx-n6 mb-6">
                                    <dl class="row mb-0">
                                        <dt class="col-6 text-heading">Total</dt>
                                        <dd class="col-6 fw-medium text-end text-heading mb-0">$1198.00</dd>
                                    </dl>

                                </div>
                                <div class="d-grid mt-6">
                                    <a wire:navigate.hover href="{{ route('shop.checkout') }}" class="btn btn-primary btn-next waves-effect waves-light">Checkout</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>