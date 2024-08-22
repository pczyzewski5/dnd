class ItemCardImageHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('#item_card_form_item_image').on('input', function(e) {
            $('.description-section-back').css('background-image', 'url(' + URL.createObjectURL(e.target.files[0]) + ')');
            $('.description-section-back').css('background-size', 'revert-layer');
        });
    }
}

new ItemCardImageHelper();