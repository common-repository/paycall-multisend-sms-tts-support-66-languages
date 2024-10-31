(function ($) {

    $(document).ready(function () {

        var elements = ['first name', 'last name', 'order number', 'address', 'city', 'email'];


        $('.remove_status').click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        $('.multisend_add_custom_status').click(function (e) {
            e.preventDefault();

            var $this = $('#multisend_order_custom');
            var status = $this.val();
            var name = $this.find(':selected').data('name');
            console.log(name);

            $('.customs_rules table').append('<tr>\n' +
                '                            <td>' + name + ':</td>\n' +
                '                            <td><textarea id="multisend_order_' + status + '" name=" multisend_custom[' + status + ']"\n' +
                '                                          cols="80" rows="3" class="multisend_custom_text"\n' +
                '                                          class="all-options"></textarea>\n' +
                '                            </td>\n' +
                '                        </tr>')

        });

        $('#multisend_new_order_customer_content , #multisend_new_order_customer_manager_content , #multisend_order_complete_sms , #multisend_order_cancel_sms , #multisend_order_cancel_sms_customer').textcomplete([
            { // html
                mentions: elements,
                match: /\B@(\w*)$/,
                search: function (term, callback) {
                    callback($.map(this.mentions, function (mention) {
                        return mention.indexOf(term) === 0 ? mention : null;
                    }));
                },
                index: 1,
                replace: function (mention) {
                    return '[' + mention + ']';
                }
            }
        ]);

        $("#multisend_acount_form").on("submit", function (event) {
            event.preventDefault();
            $('.spinner').addClass('is-active');
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'multisend_update_account',
                    'data': data
                },
                success: function (response) {

                    var obj = jQuery.parseJSON(response);
                    console.log(obj.Status);
                    if (obj.Status == '0') {
                        $('.notice').removeClass('hidden notice-error').addClass('notice-success');
                        $('.multisend-success p').text(obj.Message);
                        $('.multisend-balance').text(obj.Balance);
                    } else {
                        $('.notice').removeClass('hidden notice-success').addClass('notice-error');
                        $('.multisend-success p').text(obj.Message);
                        $('.multisend-balance').text(obj.Balance);
                    }

                    $('.spinner').removeClass('is-active');
                }
            });
        });

        $("#multisend_option_form").on("submit", function (event) {
            event.preventDefault();
            $('.spinner').addClass('is-active');
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'multisend_update_option_page',
                    'data': data
                },
                success: function (response) {
                    $('.spinner').removeClass('is-active');
                    $('.notice').removeClass('hidden');
                }
            });
        });

        $('#multisend_cf7_user , #multisend_elementor_user').click(function () {
            var $this = $(this);
            console.log('fsfs');
            // $this will contain a reference to the checkbox
            if ($this.is(':checked')) {
                // the checkbox was checked
                $('.send_user_sms').show();
            } else {
                // the checkbox was unchecked
                $('.send_user_sms').hide();
            }
        });

        $('#multisend_pojo_user').click(function () {
            var $this = $(this);
            // $this will contain a reference to the checkbox
            if ($this.is(':checked')) {
                // the checkbox was checked
                $('.send_pojo_user_sms').show();
            } else {
                // the checkbox was unchecked
                $('.send_pojo_user_sms').hide();
            }
        });


        $('#multisend_order_cancel').click(function () {
            var $this = $(this);
            // $this will contain a reference to the checkbox
            if ($this.is(':checked')) {
                // the checkbox was checked
                $('.multisend_order_cancel_content').show();
            } else {
                // the checkbox was unchecked
                $('.multisend_order_cancel_content').hide();
            }
        });

        $('#multisend_new_order').click(function () {
            var $this = $(this);
            // $this will contain a reference to the checkbox
            if ($this.is(':checked')) {
                // the checkbox was checked
                $('.multisend_new_order_content').show();
            } else {
                // the checkbox was unchecked
                $('.multisend_new_order_content').hide();
            }
        });

        $('#multisend_order_complete').click(function () {
            var $this = $(this);
            // $this will contain a reference to the checkbox
            if ($this.is(':checked')) {
                // the checkbox was checked
                $('.multisend_order_complete_content').show();
            } else {
                // the checkbox was unchecked
                $('.multisend_order_complete_content').hide();
            }
        });

    });
})(jQuery);