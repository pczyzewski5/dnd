class ItemCardTextHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $typingTimer;
        var $doneTypingInterval = 300;
        var $inputs = $('#item_card_form_item_title, #item_card_form_item_origin');
        var $outputMapping = {
            'item_card_form_item_title': '.item-title',
            'item_card_form_item_origin': '#item-origin'
        };

        $inputs.on('keyup', function() {
            clearTimeout($typingTimer);
            $typingTimer = setTimeout(doneTyping(this), $doneTypingInterval);
        });

        $inputs.on('keydown', function() {
            clearTimeout($typingTimer);
        });

        function doneTyping($input) {
            $($outputMapping[$input.id]).html($input.value);
        }
    }
}

new ItemCardTextHelper();