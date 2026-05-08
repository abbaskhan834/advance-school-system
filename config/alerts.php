<style>
    .custom-alets{
        position: absolute;
        top : 4px;
        z-index: 9999999;
    }
</style>

<div class="custom-alets w-100">
    <div class="row d-flex flex-column align-items-center justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8 col-12">
            
            <div class="alert alert-info solid alert-right-icon alert-dismissible animate__animated" id="res_success_msg" style="display: none;">
                <span><i class="mdi mdi-email"></i></span>
                <button type="button" class="close h-100" onclick="hideAlert('res_success_msg')">
                    <span><i class="mdi mdi-close"></i></span>
                </button> 
                <strong>Success!</strong> <span class="success-msg"></span>
            </div>

            <div class="alert alert-warning solid alert-right-icon alert-dismissible animate__animated" id="res_warning_msg" style="display: none;">
                <span><i class="mdi mdi-alert"></i></span>
                <button type="button" class="close h-100" onclick="hideAlert('res_warning_msg')">
                    <span><i class="mdi mdi-close"></i></span>
                </button>
                <strong>Warning!</strong> <span class="warning-msg"></span>
            </div>

            <div class="alert alert-danger solid alert-right-icon alert-dismissible animate__animated" id="res_error_msg" style="display: none;">
                <span><i class="mdi mdi-help"></i></span>
                <button type="button" class="close h-100" onclick="hideAlert('res_error_msg')">
                    <span><i class="mdi mdi-close"></i></span>
                </button>
                <strong>Error!</strong> <span class="error-msg"></span>
            </div>

        </div>
    </div>
</div>

