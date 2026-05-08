 <script src="./js/jquery-4.0.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showSuccessErrorMsg(status, msg) {
        // Purani classes aur alerts saaf karein
        $('.alert').hide().removeClass('animate__fadeInDown animate__fadeOutUp');

        let targetId = '';
        if (status == 'error') {
            targetId = '#res_error_msg';
            $(`#res_error_msg .error-msg`).html(msg);
        } else if (status == 'success') {
            targetId = '#res_success_msg';
            $(`#res_success_msg .success-msg`).html(msg);
        } else {
            targetId = '#res_warning_msg';
            $(`#res_warning_msg .warning-msg`).html(msg);
        }

        let $el = $(targetId);

        // 1. Show: Upar se Neeche (fadeInDown)
        $el.show().addClass('animate__fadeInDown');

        // 2. 3 Seconds ka wait
        setTimeout(() => {
            // 3. Hide: Neeche se Upar wapis (fadeOutUp)
            $el.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');

            // Animation khatam hone par hide karein
            $el.one('animationend', function() {
                if ($el.hasClass('animate__fadeOutUp')) {
                    $el.hide();
                }
            });
        }, 3000);
    }

    // Manual Close Button Logic
    function hideAlert(id) {
        let $el = $('#' + id);
        $el.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');
        $el.one('animationend', function() {
            $el.hide();
        });
    }


    $(document).ready(function() {
        let RES_MSG = "<?= $MSG ?>";
        if (RES_MSG != '') {
            let msgs = RES_MSG.split('--');
            let status = msgs[0];
            let msgText = msgs[1]; 
            showSuccessErrorMsg(status, msgText);
        }
    });
</script>


<script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>


    <!-- Vectormap -->
    <script src="./vendor/raphael/raphael.min.js"></script>
    <script src="./vendor/morris/morris.min.js"></script>


    <script src="./vendor/circle-progress/circle-progress.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>

    <script src="./vendor/gaugeJS/dist/gauge.min.js"></script>

    <!--  flot-chart js -->
    <script src="./vendor/flot/jquery.flot.js"></script>
    <script src="./vendor/flot/jquery.flot.resize.js"></script>

    <!-- Owl Carousel -->
    <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>

    <!-- Counter Up -->
    <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>


    <script src="./js/dashboard/dashboard-1.js"></script>

