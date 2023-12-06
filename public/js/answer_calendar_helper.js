class AnswerCalendarHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $day = $('.owner');
        var $willAttendInput = $('#calendar_answer_form_will_attend');
        var $maybeAttendInput = $('#calendar_answer_form_maybe_attend')
        var $willAttendDates =  '' == $willAttendInput.val()
            ? []
            : JSON.parse($willAttendInput.val());
        var $maybeAttendDates = '' == $maybeAttendInput.val()
            ? []
            : JSON.parse($maybeAttendInput.val());

        $day.on('click', function(e) {
            var $day = $(e.target).attr('class') == 'owner'
                ? $(e.target)
                : $(e.target).parents('.owner');
            var $date = $day.find('.date').html();
            var $icon = $day.find('.icon-container div');

            if ($icon.hasClass('not-responded')) {
                $icon.removeClass('not-responded');
                $icon.addClass('will-attend');

                $willAttendDates.push($date);
            } else if ($icon.hasClass('will-attend')) {
                $icon.removeClass('will-attend');
                $icon.addClass('maybe-attend');

                $willAttendDates = removeFromArray($date, $willAttendDates);
                $maybeAttendDates.push($date);
            } else if ($icon.hasClass('maybe-attend')) {
                $icon.removeClass('maybe-attend');
                $icon.addClass('not-responded');

                $maybeAttendDates = removeFromArray($date, $maybeAttendDates);
            }

            $willAttendInput.val(null);
            if ($willAttendDates.length > 0) {
                $willAttendInput.val(JSON.stringify($willAttendDates));
            }

            $maybeAttendInput.val(null);
            if ($maybeAttendDates.length > 0) {
                $maybeAttendInput.val(JSON.stringify($maybeAttendDates));
            }
        });

        function removeFromArray($data, $array) {
            return jQuery.grep($array, function($value) {
                return $value != $data;
            });
        }
    }
}

new AnswerCalendarHelper();