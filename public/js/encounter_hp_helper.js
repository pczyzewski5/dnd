class EncounterHpHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.hp').on('click', function(e) {
            e.preventDefault()

            let $target = $(e.target);

            if ($target.hasClass('button') === false) {
                $target = $target.closest('.hp.button');
            }

            let $hp = $(e.target)
                .closest('.participant')
                .find('#hp')
                .val();

            if ($hp.length !== 0) {
                window.location.href =
                    $target
                    .data('href')
                    .replaceAll(':hp', parseInt($hp));
            }
        });
    }
}

new EncounterHpHelper();