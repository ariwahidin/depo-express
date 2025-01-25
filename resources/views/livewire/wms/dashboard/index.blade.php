<div>
    <div class="card-body row p-0 pb-6 g-6">
        <div class="col-12 col-lg-8 card-separator">
            <h5 class="mb-2">Welcome back,<span class="h4"> {{ auth()->user()->name }} 👋🏻</span></h5>
            <div class="col-12 col-lg-5">
                <p>Your progress this week is Awesome. let's keep it up !</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
                <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-primary rounded">
                            <div>
                                <!-- <img src="{{ asset('/') }}assets/svg/laptop.svg" alt="paypal" class="img-fluid"> -->
                                <i class="ti ti-circle-check ti-28px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Inbound Open</p>
                        <h4 class="text-primary mb-0">0</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-warning rounded">
                            <div>
                                <!-- <img src="{{ asset('/') }}assets/svg/lightbulb.svg" alt="Lightbulb" class="img-fluid"> -->
                                <!-- <i class="ti ti-package ti-28px"></i> -->
                                <i class="ti ti-alert-triangle ti-28px"></i>
                            </div>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Outbound Open</p>
                        <h4 class="text-info mb-0">0</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar avatar-lg">
                        <div class="avatar-initial bg-label-info rounded">
                            <!-- <div>
                                <img src="{{ asset('/') }}assets/svg/check.svg" alt="Check" class="img-fluid">
                            </div> -->
                            <!-- <i class="ti ti-alert-triangle ti-28px"></i> -->
                            <i class="ti ti-package ti-28px"></i>
                        </div>
                    </div>
                    <div class="content-right">
                        <p class="mb-0 fw-medium">Stock Value</p>
                        <h4 class="text-warning mb-0">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>