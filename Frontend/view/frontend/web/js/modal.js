<!--alert “Hello World!”

require(['jquery'],function ($){
    $('#btn_open_modal').click(function (){
        alert("Hello World")
    });
});
-->
require([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
], function ($, alert, modal) {
    $('#open_modal').click(function () {
        alert({
            title: $.mage.__('Modal'),
            content: $.mage.__('Hello World'),
            actions: {
                always: function () {
                }
            }
        });
    });

    let options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Login Form',
        buttons: [{
            text: $.mage.__('Login'),
            class: '',
            click: function () {
                this.closeModal();
                $('#popup-modal').html(" ");
            }
        }]
    };
    let popup = modal(options, $('#form_login'));
    $("#magento_login_modal").on("click", function () {
        $('#form_login').modal('openModal');
    });
});