class EncounterNoteHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.button.save-note').on('click', function(e) {
            e.preventDefault()

            let $notes = $(e.target).parent().find('#notes').val();

            if ($notes.length === 0) {
                $notes = ':note';
            } else {
                $notes = btoa($notes);
            }

            window.location.href = $(e.target).attr('href').replaceAll(':note', $notes);
        });
    }
}

new EncounterNoteHelper();