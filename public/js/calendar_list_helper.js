class CalendarListHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $calendar = $('.content');

        $calendar.hover(
            function (e) {
                let $content = $(e.target).attr('class') == 'content'
                    ? $(e.target)
                    : $(e.target).parents('.content');

                $content.find('.button').css('background-color', 'rgba(74, 74, 74, 0.6)');
            },
            function (e) {
                let $content = $(e.target).attr('class') == 'content'
                    ? $(e.target)
                    : $(e.target).parents('.content');

                $content.find('.button').css('background-color', 'initial');;
            }
        );

        $calendar.on('click', function(e) {
            let $content = $(e.target).attr('class') == 'content'
                ? $(e.target)
                : $(e.target).parents('.content');

            window.location.href = $content.attr('href');
        });
    }
}

new CalendarListHelper();