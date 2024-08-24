class EncounterNoteHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.save-note').on('click', function(e) {
            e.preventDefault()

            let $submitButton = $(e.target);
            let $notes = $submitButton.parent().find('#notes').val();

            if ($notes.length === 0) {
                $notes = ':note';
            } else {
                $notes = btoa($notes);
            }

            window.location.href = $submitButton.attr('href').replaceAll(':note', $notes);
        });
    }
}

new EncounterNoteHelper();