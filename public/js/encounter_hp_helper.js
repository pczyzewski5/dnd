class EncounterHpHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.hp').on('click', function(e) {
            e.preventDefault()

            let $hp = $(e.target).parent().find('#hp').val();

            if ($hp.length !== 0) {
                window.location.href = $(e.target).data('href').replaceAll(':hp', parseInt($hp));
            }
        });
    }
}

new EncounterHpHelper();