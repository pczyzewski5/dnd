class EncounterSwapHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.swap-modal').on('click', function(e) {
            e.preventDefault()

            let $target = $(e.target);

            if ($target.hasClass('button') === false) {
                $target = $target.closest('.button.swap-modal');
            }

            buildModalContent(
                $target.data('actual-id'),
                $('#participant-ids').data('ids').split('|')
            );

            $('.swap-modal-window').addClass('is-active');

            function buildModalContent($actualParticipantId, $participantsIds) {
                $('.swap-modal-window .modal-card-body .buttons').empty();

                $.each($participantsIds, function($key, $swapId) {
                    if ($actualParticipantId == $swapId) {
                        return;
                    }

                    let $button = buildSwapButton(
                        $swapId,
                        customizeHref($swapId, $target.data('href'))
                    );

                    $('.swap-modal-window .modal-card-body .buttons').append($button);
                });
            }

            function buildSwapButton($swapId, $href) {
                let $link = $('<a></a>');

                $link
                    .addClass('button is-success')
                    .text($swapId)
                    .attr('href', $href);

                return $link;
            }

            function customizeHref($swapId, $href) {
               console.log($href);
                return $href.replace(
                    ':swapId',
                    parseInt($swapId)
                )
            }
        });
    }
}

new EncounterSwapHelper();