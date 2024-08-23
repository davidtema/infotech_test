$(function () {
    $('.btn-subscribe').on('click', function () {
        $('body').append('<div class="window-subscription"><div class="window-subscription__body"></div></div>');
        $('.window-subscription__body').load('/index.php?r=subscription/form&id=1');
    });

    // $('body').on('click', '.window-subscription', function () {
    //     $(this).remove();
    // })

    $('body').on('submit', '#subscription-form', function (e) {
        e.preventDefault();

        console.log($(this).serialize());

        $.ajax($(this).attr('action'), {
            method: 'post',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status && response.status === 'ok') {
                    alert('Подписка оформлена.');
                    $('.window-subscription').remove();
                }
            }
        })
    })
})