class EncounterModalHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.image-modal').on('click', function(e) {
            $('.modal.image-modal').addClass('is-active');
        });
        $('.modal-background').on('click', function(e) {
            $('.modal').removeClass('is-active');
        })
    }
}

new EncounterModalHelper();