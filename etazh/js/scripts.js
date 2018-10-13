(function ($) {
  $(document).ready(function(){
    $('#block-etazh-content #user-login-form #edit-name').attr('placeholder', 'Логин');
    $('#block-etazh-content #user-login-form #edit-pass').attr('placeholder', 'Пароль');

    // Добавляем название сканов документов в блоке справа на страницах Объектов.
    if ($('.page-node-type-object #block-views-block-frontpage-block-2').length > 0) {
      $('.page-node-type-object #block-views-block-frontpage-block-2 .field-content a img').each(function() {
        $(this).after('<span class="doc-title">' + $.trim($(this).attr('title')) + '</span>');
      });
    }

    // Удаляем ссылку на профиль пользователя в аватарках.
    $('.avatar img').each(function() {
      $(this).unwrap();
    });

    if ($('#object-id').length > 0) {
      $('#block-etazh-page-title h1 span').html($('#block-etazh-page-title h1 span').text() + ' <span class="object-id" title="ID объекта в системе">' + $('#object-id').text() + '</span>');
    }

    // Показываем Системные сообщения
    if ($('.message-area div div').length > 0) {
      $('.message-area').show();
      $('.message-area div div').before('<span class="close">x</close>');
      function hideMessage(){
        $('.message-area').hide();
      }
      setTimeout(hideMessage, 5000);
    }

    $('.message-area .close').on('click',function() {
      $('.message-area').hide();
    });
  });
})(jQuery);
