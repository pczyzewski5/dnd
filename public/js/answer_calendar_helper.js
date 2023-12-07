class AnswerCalendarHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $day = $('.can-vote');
        var $willAttendInput = $('#calendar_answer_form_will_attend');
        var $maybeAttendInput = $('#calendar_answer_form_maybe_attend')
        var $willAttendDates =  '' === $willAttendInput.val()
            ? []
            : JSON.parse($willAttendInput.val());
        var $maybeAttendDates = '' === $maybeAttendInput.val()
            ? []
            : JSON.parse($maybeAttendInput.val());

        $day.on('click', function(e) {
            var $day = $(e.target).attr('class') === 'can-vote'
                ? $(e.target)
                : $(e.target).parents('.can-vote');
            var $date = $day.find('.date').html();
            var $pointsContainer = $('#' + $date + '_points');
            var $actualPoints = parseInt($pointsContainer.html());
            var $icon = $day.find('.icon-container div');

            console.log($pointsContainer, $actualPoints);

            if ($icon.hasClass('not-responded')) {
                $icon.removeClass('not-responded');
                $icon.addClass('will-attend');

                $willAttendDates.push($date);
                $pointsContainer.html(
                    $actualPoints + 1
                );
            } else if ($icon.hasClass('will-attend')) {
                $icon.removeClass('will-attend');
                $icon.addClass('maybe-attend');

                $willAttendDates = removeFromArray($date, $willAttendDates);
                $maybeAttendDates.push($date);
                $pointsContainer.html(
                    $actualPoints - 1
                );
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