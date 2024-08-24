class EncounterHpHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.hp').on('click', function(e) {
            e.preventDefault()

            let $submitButton = $(e.target);
            let $hp = $submitButton.parent().find('#hp').val();

            if ($hp.length !== 0) {
                window.location.href = $submitButton.attr('href').replaceAll(':hp', parseInt($hp));
            }
        });
    }
}

new EncounterHpHelper();