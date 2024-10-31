jQuery(document).ready(function ($) {
    $('.color-picker').wpColorPicker({
        change: function (event, ui) {
            var element = event.target;
            var color = ui.color.toString();
            const $container = $(element).parents('.wp-picker-container');
            $container.find('.wp-color-result-text').text(color);
        },
    });
    styleChange();

    $('.wp-picker-container').each(function() {
        const $container = $(this);
        let color = $container.find('.wp-color-picker').val();
        if (color !== '') {
            $container.find('.wp-color-result-text').text(color);
        }
    });

    // Get the element with the class "wp-picker-holder"
    const ignoreClickOnMeElement = document.querySelector('.wp-picker-holder');

    // Check if the element exists
    if (ignoreClickOnMeElement instanceof HTMLElement) {
        document.addEventListener('click', function (event) {
            var isClickInsideElement = ignoreClickOnMeElement.contains(event.target);
        });
    } else {
        console.log('Element with class "wp-picker-holder" not found.');
    }
});

function changeColor(id, rgb) {
    jQuery('#' + id).css('backgroundColor', rgb).val(rgb);
}

function styleChange() {
    const orig = jQuery.fn.css;

    jQuery.fn.css = function () {
        const result = orig.apply(this, arguments);
        jQuery(this).trigger('stylechanged');
        return result;
    }
}
