jQuery(function ($) {
    var url_length = $('.abredirect').length;
    var default_url = new Array();
    if (!creative_param == '') {
        creative_param = '&creative=' + creative_param;
    }
    for (i = 0; i < url_length; i++) {
        default_url[i] = encodeURIComponent($('.abredirect').eq(i).attr('href'));
        $('.abredirect').eq(i).attr('href', abredirect_path + '/redirect.php?url=' + default_url[i] + creative_param);
    }
});