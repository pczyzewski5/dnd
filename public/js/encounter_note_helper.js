class EncounterNoteHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.save-note').on('click', function(e) {
            e.preventDefault()

            let $target = $(e.target);

            if ($target.hasClass('button') === false) {
                $target = $target.closest('.save-note.button');
            }

            let $notes = $target.closest('.participant').find('#notes').val();

            if ($notes.length === 0) {
                $notes = ':note';
            } else {
                $notes = btoa($notes);
            }

            window.location.href = $target.data('href').replaceAll(':note', $notes);
        });
    }
}

new EncounterNoteHelper();