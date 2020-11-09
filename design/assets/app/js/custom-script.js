$('[data-include]').each(function () {
    var t = this;
    $(this).load("components/" + $(this).data('include'), function (r) {
        $(t).replaceWith(r);
    })
});

//intialize select2
$(function () {
    if ($('.select2-flexable').length) {
        $('.select2-flexable').select2({
            dir: "rtl",
            width: '100%',
            tags: true,
            tokenSeparators: [',', ' ']

        });
    }
    if ($('.select2-static').length) {
        $('.select2-static').select2({
            dir: "rtl",
            width: '100%',
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function (params) {
                return undefined;
            }
        });
    }
})