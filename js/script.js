$(document).ready(function() {
    $('.ajax-form').on('submit', function(event) {
        event.preventDefault(); // предотвратить стандартное поведение формы
        var form = $(this);
        $.ajax({
            url: '', // адрес обработчика формы (текущий URL)
            type: 'POST',
            data: form.serialize(), // сериализуем данные формы
            success: function(response) {
                $('#cart-items').html($(response).find('#cart-items').html());
            },
            error: function() {
                alert('Ошибка при обработке запроса');
            }
        });
    });
});
