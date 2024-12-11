class EncounterModalHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.image-modal').on('click', function(e) {
            let $target = $(e.target);
            let $modal = $target.closest('.participant-container').find('.modal.image-modal');
            $modal.addClass('is-active');
        });
        $('.modal-background').on('click', function(e) {
            $('.modal').removeClass('is-active');
        })
    }
}

new EncounterModalHelper();