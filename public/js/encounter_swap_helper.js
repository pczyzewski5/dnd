class EncounterSwapHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.swap-id').on('click', function(e) {
            e.preventDefault()

            buildModalContent(
                $(e.target).data('actual-id'),
                $('#participant-ids').data('ids').split('|')
            );

            $('.modal').addClass('is-active');
            $('.modal-background').on('click', function(e) {
                $('.modal').removeClass('is-active');
            })

            function buildModalContent($actualParticipantId, $participantsIds) {
                $('.modal-card-body').empty();

                $.each($participantsIds, function($key, $swapId) {
                    if ($actualParticipantId == $swapId) {
                        return;
                    }

                    let $button = buildSwapButton(
                        $swapId,
                        customizeHref($swapId, $(e.target).data('href'))
                    );

                    $('.modal-card-body').append($button);
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
                return $href.replaceAll(
                    ':swapId',
                    parseInt($swapId)
                )
            }
        });
    }
}

new EncounterSwapHelper();