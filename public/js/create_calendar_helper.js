class CalendarHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $day = $('.day');
        var $datesInput = $('#create_calendar_form_dates');
        var $dates = '' === $datesInput.val()
            ? []
            : JSON.parse($datesInput.val());

        jQuery.each($dates, function($index, $item) {
            $('.day_' + $item).removeClass('will-not-attend');
            $('.day_' + $item).addClass('will-attend');
        });

        $day.on('click', function(e) {
            var $day = $(e.target);
            var $date = $day.find('.date').html();

            if ($day.hasClass('will-not-attend')) {
                $day.removeClass('will-not-attend');
                $day.addClass('will-attend');

                $dates.push($date);
            } else if ($day.hasClass('will-attend')) {
                $day.removeClass('will-attend');
                $day.addClass('will-not-attend');

                $dates = removeFromArray($date, $dates);
            }

            $datesInput.val(null);
            if ($dates.length > 0) {
                $datesInput.val(
                    JSON.stringify($dates)
                );
            }
        });

        function removeFromArray($data, $array) {
            return jQuery.grep($array, function($value) {
                return $value !== $data;
            });
        }
    }
}

new CalendarHelper();