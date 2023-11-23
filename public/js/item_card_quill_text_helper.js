class ItemCardQuillTextHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $typingTimer;
        var $doneTypingInterval = 500;
        var $quillEditor = $('.ql-editor:first');
        var $quillData = $('#quill-data-container');
        var $quillToolbar = $('.ql-toolbar');

        $quillEditor.on('keyup', function() {
            clearTimeout($typingTimer);
            $typingTimer = setTimeout(doneTyping, $doneTypingInterval);
        });

        $quillEditor.on('keydown', function() {
            clearTimeout($typingTimer);
        });

        $quillToolbar.on('click', function() {
            doneTyping();
        });

        function doneTyping() {
            let $request = $.ajax({
                url: "/quill",
                method: "POST",
                data: $quillData.val(),
                contentType: 'json'
            });

            $request.done(function($content) {
                $('#item-description').html($content);
            });
        }
    }
}

new ItemCardQuillTextHelper();