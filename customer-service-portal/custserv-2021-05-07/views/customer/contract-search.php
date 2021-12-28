
    <div class="container container-w98" id="customer-search-container">
        <h4 class="text-center text-uppercase hide-on-mobile">Customer Lookup</h4>
        <p class="text-center hide-on-mobile">Enter any search criteria that you can.</p>
        <div class="row">
            <div class="no-padding center-row">
                <div class="card no-border-radius primary-white">
                    <div class="card-body">
                        <div class="row sub-row">
                            <div class="col-12 no-padding">
                                <form action="index.php" method="post" name="contract-search-form" id="contract-search-form" onsubmit="return validateEditUserForm();">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="account-number">Customer Account Number</label>
                                            <input type="text" class="form-control form-control-sm required" id="account-number" aria-describedby="accountNumberHelp" placeholder="">
                                            <div class="invalid-feedback" id="account-number-error-message">
                                                Account Number is not valid.
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="contract-name">Contract Name</label>
                                            <input type="text" class="form-control form-control-sm required" id="contract-name" aria-describedby="contractNameHelp" placeholder="">
                                            <div class="invalid-feedback" id="contract-name-error-message">
                                                Contract Name is not valid.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="contract-id">Contract ID</label>
                                            <input type="text" class="form-control form-control-sm required" id="contract-id" aria-describedby="contractIDHelp" placeholder="">
                                            <div class="invalid-feedback" id="contract-id-error-message">
                                                Contract ID is not valid.
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="invoice-number">Invoice Number</label>
                                            <input type="text" class="form-control form-control-sm required" id="invoice-number" aria-describedby="invoiceNumberHelp" placeholder="">
                                            <div class="invalid-feedback" id="invoice-number-error-message">
                                                Invoice Number is not valid.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group no-padding-left submit-button-div">
                                        <div class="form-row">
                                            <div class="col-6"></div> 
                                            <div class="form-group col-md-6">
                                                <input class="btn btn-primary btn-sm mb-2 grey-button float-right-50" id="submit-button" type="submit" value="Search">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>